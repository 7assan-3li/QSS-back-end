<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerifyEmailForMobile extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    /**
     * توليد رابط API موقّع
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'api.email.verify',
            Carbon::now()->addMinutes(60),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('تأكيد البريد الإلكتروني')
            ->line('يرجى الضغط على الزر أدناه لتأكيد بريدك الإلكتروني.')
            ->action('تأكيد البريد', $this->verificationUrl($notifiable))
            ->line('إذا لم تقم بإنشاء هذا الحساب، تجاهل هذه الرسالة.');
    }
}