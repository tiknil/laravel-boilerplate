<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends \Illuminate\Auth\Notifications\ResetPassword
{
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Reimposta la tua password'))
            ->line(Lang::get('Ricevi questa mail perché è stato richiesto il reset password del tuo account '.config('app.name').'.'))
            ->action(Lang::get('Reimposta password'), $url)
            ->line(Lang::get('Questo link scadrà tra :count minuti.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('Se non sei stato tu a fare richiesta, puoi ignorare questa email.'));
    }
}
