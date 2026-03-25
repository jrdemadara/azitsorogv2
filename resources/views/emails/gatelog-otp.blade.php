<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GateLog OTP</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.5;">
    <h2 style="margin-bottom: 8px;">GateLog Verification Code</h2>
    <p style="margin-top: 0;">Use this one-time password to verify your email in GateLog:</p>
    <p style="font-size: 28px; letter-spacing: 4px; font-weight: 700; margin: 16px 0;">{{ $otpCode }}</p>
    <p>This code expires in {{ $expiresMinutes }} minutes.</p>
    <p style="margin-top: 24px; color: #6b7280; font-size: 12px;">If you did not request this, you can safely ignore this email.</p>
</body>
</html>
