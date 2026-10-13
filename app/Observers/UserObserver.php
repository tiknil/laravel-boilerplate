<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use OwenIt\Auditing\Models\Audit;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->wasChanged('password')) {

            $performer = Auth::user();

            Audit::create([
                'user_type' => $performer ? get_class($performer) : null,
                'user_id' => $performer ? $performer->getKey() : null,
                'event' => 'password_changed',
                'auditable_type' => get_class($user),
                'auditable_id' => $user->getKey(),
                'old_values' => [],
                'new_values' => [
                    'message' => 'Password aggiornata con successo.',
                    'target_user_email' => $user->email,
                ],
                'url' => Request::fullUrl(),
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
