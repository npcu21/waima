<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ResetPasswordNotificationCustom extends Notification
{
    public $token;
    public $langCode;

    public function __construct($token, $langCode = 'en')
    {
        $this->token = $token;
        $this->langCode = $langCode;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $tr = new GoogleTranslate($this->langCode);

        $resetUrl = url("/password/reset/{$this->token}?email={$notifiable->email}");

        return (new MailMessage)
                    ->subject($tr->translate('Reset Password Notification'))
                    ->line($tr->translate('You are receiving this email because we received a password reset request for your account.'))
                    ->action($tr->translate('Reset Password'), $resetUrl)
                    ->line($tr->translate('If you did not request a password reset, no further action is required.'));
    }
}
