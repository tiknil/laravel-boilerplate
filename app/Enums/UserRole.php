<?php

namespace App\Enums;

enum UserRole
{
    case Admin;

    case User;

    public function label(): string
    {
        return __('user.roles.'.$this->name);
    }
}
