<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GateLog OTP</title>
</head>
<body style="margin:0; padding:24px 0; background:#f3f4f6; font-family:Arial,sans-serif; color:#111827; line-height:1.5;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" width="620" style="max-width:620px; width:100%; background:#ffffff; border-radius:14px; overflow:hidden; border:1px solid #e5e7eb;">
                    <tr>
                        <td align="center" style="padding:20px 24px 10px 24px; background:#ffffff;">
                            <h1 style="margin:0; font-size:28px; line-height:1.2; color:#111827; font-weight:700;">Azitsorog Inc.</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 24px 26px 24px;">
                            <h2 style="margin:0 0 8px 0; font-size:24px; line-height:1.25; color:#111827;">GateLog Verification Code</h2>
                            <p style="margin:0 0 16px 0; color:#374151;">Use this one-time password to verify your email in GateLog:</p>

                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="margin:0 0 14px 0;">
                                <tr>
                                    <td align="center" style="background:#eef2ff; border:1px dashed #c7d2fe; border-radius:10px; padding:14px 12px;">
                                        <span style="font-size:34px; letter-spacing:6px; font-weight:700; color:#111827;">{{ $otpCode }}</span>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 6px 0; color:#374151;">This code expires in <strong>{{ $expiresMinutes }} minutes</strong>.</p>
                            <p style="margin:0; color:#6b7280; font-size:13px;">If you did not request this, you can safely ignore this email.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 24px; background:#f9fafb; border-top:1px solid #e5e7eb;">
                            <p style="margin:0; font-size:12px; color:#6b7280; text-align:center;">
                                Azitsorog Inc. · High-End ID Solutions<br>
                                GateLog Security Notice: Never share your OTP with anyone.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
