<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;
use OwenIt\Auditing\Models\Audit;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;

        Audit::create([
            'user_type' => get_class($user),
            'user_id' => $user->getKey(),
            'event' => 'login',
            'auditable_type' => get_class($user),
            'auditable_id' => $user->getKey(),
            'old_values' => [],
            'new_values' => [
                'email' => $user->email,
            ],
            'url' => Request::fullUrl(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
