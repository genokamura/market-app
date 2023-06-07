<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends ResetPassword
{
    public function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject(__('パスワード再設定'))
            ->line(__('下のボタンをクリックしてパスワードを再設定してください。'))
            ->action(__('再設定'), $url)
            ->line(__('このリンクは60分で期限切れになります。'))
            ->line(__('もし心当たりがない場合は、このメールを破棄してください。'));
    }
}
