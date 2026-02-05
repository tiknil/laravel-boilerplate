<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends \Illuminate\Auth\Notifications\ResetPassword
{
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject(__('login.reset_email.subject'))
            ->line(__('login.reset_email.main_text', ['name' => config('app.name')]))
            ->action(__('login.reset_email.reset_btn'), $url)
            ->line(__('login.reset_email.expiration_notice', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(__('login.reset_email.final_text'));
    }
}
