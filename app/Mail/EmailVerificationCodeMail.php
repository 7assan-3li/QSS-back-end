<?php

namespace App\Mail;


use Illuminate\Mail\Mailable;

class EmailVerificationCodeMail extends Mailable
{
    public function __construct(public string $code) {}

    public function build()
    {
        return $this->subject('رمز توثيق البريد الإلكتروني')
            ->view('emails.verify-code');
    }
}
