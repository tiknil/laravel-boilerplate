<?php

namespace App\Enums;

enum UserRole
{
    use EnumOptions;

    case Admin;

    case User;

    public function label(): string
    {
        return __('user.roles.'.$this->name);
    }
}
