<?php

namespace App\Enums;

enum AuditEvents
{
    use WithTryMethods;
    case login;
    case login_failed;
    case logout;
    case updated;
    case created;
    case deleted;
    case restored;
    case password_changed;

    public function toLabel(): string
    {
        return match ($this) {
            self::login => 'Login',
            self::login_failed => 'Login fallito',
            self::logout => 'Logout',
            self::updated => 'Modifica',
            self::created => 'Creazione',
            self::deleted => 'Eliminazione',
            self::restored => 'Reintegrata',
            self::password_changed => 'Cambio password',
        };
    }

    public function isAccess()
    {
        return match ($this) {
            self::login, self::login_failed, self::logout => true,
            default => false
        };
    }
}
