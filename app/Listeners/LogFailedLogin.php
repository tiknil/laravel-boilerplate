<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Request;
use OwenIt\Auditing\Models\Audit;

class LogFailedLogin
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
    public function handle(Failed $event): void
    {
        $user = $event->user;
        $email = $user?->email ?? ($event->credentials['email'] ?? null);

        Audit::create([
            'user_type' => null,
            'user_id' => null,
            'event' => 'login_failed',
            'auditable_type' => $user ? get_class($user) : null,
            'auditable_id' => $user?->getAuthIdentifier(),
            'old_values' => [],
            'new_values' => [
                'email' => $email,
            ],
            'url' => Request::fullUrl(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
