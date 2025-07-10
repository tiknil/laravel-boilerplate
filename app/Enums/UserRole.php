<?php

namespace App\Enums;

enum UserRole
{
    use EnumOptions, WithTryMethods;

    case Admin;

    case User;

    public function label(): string
    {
        return __('user.roles.'.$this->name);
    }
}
