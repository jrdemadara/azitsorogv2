<?php

namespace App\Services\Gatelog;

use App\Models\Gatelog\GateLog;
use App\Models\Gatelog\ParentDevice;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Throwable;

class PushNotificationService
{
    private ?string $lastError = null;

    public function send(ParentDevice $device, GateLog $gateLog): bool
    {
        $this->lastError = null;
        try {
            $messaging = Firebase::messaging();

            $message = CloudMessage::withTarget("token", (string) $device->push_token)
                ->withAndroidConfig(
                    AndroidConfig::fromArray([
                        "notification" => [
                            // Must match a drawable resource name in the Android app.
                            "icon" => "ic_notification",
                            "color" => "#FFFFFF",
                        ],
                    ]),
                )
                ->withNotification(
                    Notification::create("New Gate Log", "A new gate activity is available."),
                )
                ->withData([
                    "event" => "gatelog.new_entry",
                    "gate_log_id" => (string) $gateLog->id,
                    "student_id" => (string) $gateLog->student_id,
                    "direction" => (string) $gateLog->direction,
                    "logged_at" => (string) optional($gateLog->logged_at)->toIso8601String(),
                ]);

            $messaging->send($message);

            return true;
        } catch (MessagingException | FirebaseException $e) {
            $this->lastError = substr($e->getMessage(), 0, 500);
            logger()->error("FCM push failed", [
                "error" => $e->getMessage(),
                "device_id" => $device->id,
                "gate_log_id" => $gateLog->id,
            ]);
            return false;
        } catch (Throwable $e) {
            $this->lastError = substr($e->getMessage(), 0, 500);
            logger()->error("FCM push failed (unexpected)", [
                "error" => $e->getMessage(),
                "device_id" => $device->id,
                "gate_log_id" => $gateLog->id,
            ]);
            return false;
        }
    }

    public function lastErrorMessage(): ?string
    {
        return $this->lastError;
    }
}
