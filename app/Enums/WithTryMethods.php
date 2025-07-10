<?php

namespace App\Enums;

/**
 * Mette a disposizione i metodi from e tryFrom anche per gli enum "puri" (UnitEnum).
 * Gli enum con un valore collegato (BackedEnum) hanno già questi metodi.
 */
trait WithTryMethods
{
    public static function from(string $from): self
    {
        foreach (self::cases() as $type) {
            if ($from === $type->name) {
                return $type;
            }
        }

        throw new \ValueError("$from is not a valid backing value for enum ".self::class);
    }

    public static function tryFrom(string $from): ?self
    {
        try {
            return self::from($from);
        } catch (\ValueError $error) {
            return null;
        }
    }
}
