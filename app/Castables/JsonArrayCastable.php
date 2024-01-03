<?php

namespace App\Castables;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * Extend this to make your custom class Castable by just implementing two methods:
 * fromArray => create an instance from a data array
 * toArray => create the array representation of the instance
 *
 * The class will be persisted in the DB as a json-encoded string
 */
abstract class JsonArrayCastable implements Arrayable, Castable, JsonSerializable
{
    abstract public static function fromArray(?array $data): self;

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public static function castUsing(array $arguments): CastsAttributes
    {
        $className = static::class;

        return new class($className) implements CastsAttributes
        {
            public function __construct(private readonly string $className)
            {
            }

            public function get($model, string $key, $value, array $attributes)
            {
                return $this->className::fromArray(json_decode($value, true));
            }

            public function set($model, string $key, $value, array $attributes): string
            {
                if (!$value instanceof $this->className) {
                    throw new \InvalidArgumentException("The given value is not a '{$this->className}' instance.");
                }

                return json_encode($value);
            }
        };
    }
}
