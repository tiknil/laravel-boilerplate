<?php

namespace App\Enums;

use BackedEnum;
use UnitEnum;

trait EnumOptions
{
    public static function toOptions(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $key = '';
            if (is_a($case, BackedEnum::class)) {
                $key = $case->value;
            }

            if (is_a($case, UnitEnum::class)) {
                $key = $case->name;
            }

            $label = $key;

            if (method_exists($case, 'toLabel')) {
                $label = $case->toLabel();
            }

            $options[$key] = $label;
        }

        return $options;
    }
}
