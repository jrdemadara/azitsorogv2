<?php

namespace App\Services\Gatelog;

use App\Models\Gatelog\GateLog;
use App\Models\Gatelog\ParentDevice;
use Illuminate\Support\Facades\Http;

class PushNotificationService
{
    private static ?string $accessToken = null;

    private static int $accessTokenExpiresAt = 0;

    public function send(ParentDevice $device, GateLog $gateLog): bool
    {
        $projectId = (string) env('FCM_PROJECT_ID', '');
        if ($projectId === '') {
            logger()->warning('FCM_PROJECT_ID is missing.');
            return false;
        }

        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return false;
        }

        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                'message' => [
                    'token' => $device->push_token,
                    'notification' => [
                        'title' => 'New Gate Log',
                        'body' => 'A new gate activity is available.',
                    ],
                    'data' => [
                        'event' => 'gatelog.new_entry',
                        'gate_log_id' => (string) $gateLog->id,
                        'student_id' => (string) $gateLog->student_id,
                        'direction' => (string) $gateLog->direction,
                        'logged_at' => (string) optional($gateLog->logged_at)->toIso8601String(),
                    ],
                ],
            ]);

        if (!$response->successful()) {
            logger()->error('FCM v1 push failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'device_id' => $device->id,
                'gate_log_id' => $gateLog->id,
            ]);
            return false;
        }

        return (bool) data_get($response->json(), 'name');
    }

    private function getAccessToken(): ?string
    {
        $now = time();
        if (self::$accessToken && $now < self::$accessTokenExpiresAt - 60) {
            return self::$accessToken;
        }

        $jsonPath = (string) env('FCM_SERVICE_ACCOUNT_JSON', '');
        if ($jsonPath === '' || !is_file($jsonPath)) {
            logger()->warning('FCM_SERVICE_ACCOUNT_JSON is missing or invalid.', ['path' => $jsonPath]);
            return null;
        }

        $credentials = json_decode((string) file_get_contents($jsonPath), true);
        if (!is_array($credentials) || empty($credentials['client_email']) || empty($credentials['private_key'])) {
            logger()->error('Invalid FCM service account JSON.');
            return null;
        }

        $jwt = $this->buildGoogleJwt($credentials['client_email'], $credentials['private_key']);
        if (!$jwt) {
            return null;
        }

        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if (!$tokenResponse->successful()) {
            logger()->error('Failed to get Google OAuth token.', [
                'status' => $tokenResponse->status(),
                'body' => $tokenResponse->body(),
            ]);
            return null;
        }

        $data = $tokenResponse->json();
        self::$accessToken = (string) ($data['access_token'] ?? '');
        self::$accessTokenExpiresAt = $now + (int) ($data['expires_in'] ?? 0);

        return self::$accessToken !== '' ? self::$accessToken : null;
    }

    private function buildGoogleJwt(string $clientEmail, string $privateKey): ?string
    {
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $now = time();
        $payload = [
            'iss' => $clientEmail,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ];

        $encodedHeader = $this->base64UrlEncode(json_encode($header));
        $encodedPayload = $this->base64UrlEncode(json_encode($payload));
        $toSign = $encodedHeader . '.' . $encodedPayload;

        $signature = '';
        $ok = openssl_sign($toSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        if (!$ok) {
            logger()->error('Failed to sign Google JWT.');
            return null;
        }

        return $toSign . '.' . $this->base64UrlEncode($signature);
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
