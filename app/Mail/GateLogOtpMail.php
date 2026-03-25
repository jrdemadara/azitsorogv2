<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GateLogOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $otpCode)
    {
    }

    public function build(): self
    {
        return $this->subject('GateLog OTP Verification')
            ->view('emails.gatelog-otp', [
                'otpCode' => $this->otpCode,
                'expiresMinutes' => 5,
            ]);
    }
}
