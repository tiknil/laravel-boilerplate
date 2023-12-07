<?php

namespace App\Enums;

enum UserRole
{
    case Admin;

    case User;

    public function label(): string
    {
        return match ($this) {
            UserRole::Admin => 'Admin',
            UserRole::User => 'User',
        };
    }
}
