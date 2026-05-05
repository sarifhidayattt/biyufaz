<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otpCode;
    public string $userName;

    public function __construct(string $otpCode, string $userName)
    {
        $this->otpCode  = $otpCode;
        $this->userName = $userName;
    }

    public function build(): static
    {
        return $this
            ->subject('Kode OTP Verifikasi Akun - ' . config('app.name'))
            ->view('emails.otp');
    }
}
