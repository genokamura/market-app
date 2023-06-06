<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends VerifyEmailBase implements ShouldQueue
{
    use Queueable;

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     *
     * @return string
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            \Carbon\Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => \sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage())
            ->subject('本登録のお願い')
            ->line('下のボタンをクリックして、本登録を完了してください。')
            ->action('本登録', $verificationUrl)
            ->line('もしメールアドレスを登録していない場合は、このメールを無視してください。');
    }
}
