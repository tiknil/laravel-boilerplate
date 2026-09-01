<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorAuthEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Questo parametro definisce se l'utente è costretto ad applicare la 2FA. Di default è opzionale, quindi impostato a false
        // Per forzare l'utilizzo a tutti gli utenti, impostarlo a true; in alternativa si può condizionare al ruolo utente o a ciò che si preferisce
        $forceAuthForUser = false;

        if ($user && !$user->hasEnabledTwoFactorAuthentication() && $forceAuthForUser) {
            return redirect()->route('two-factor.setup');
        }

        return $next($request);
    }
}
