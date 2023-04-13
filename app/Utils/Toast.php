<?php

namespace App\Utils;

use Illuminate\Support\Facades\Session;

class Toast implements \JsonSerializable
{
    const SESSION_KEY = '_toasts';

    private function __construct(public string $type, public string $message)
    {
    }

    public static function create(string $type, string $message): self
    {
        return new Toast($type, $message);
    }

    /**
     * Creates a new toast and pushes it immediately
     */
    public static function show(string $type, string $message): self
    {
        $toast = self::create($type, $message);

        $toast->push();

        return $toast;
    }

    /**
     * Retrieve all flashes from the session
     */
    public static function all(bool $flush = true): array
    {
        $toasts = Session::get(self::SESSION_KEY);

        if (empty($toasts)) {
            return [];
        }

        if ($flush) {
            Session::forget(self::SESSION_KEY);
        }

        return array_map(fn ($t) => self::create($t[0], $t[1]), $toasts);
    }

    /**
     * Push the toast to the session
     */
    public function push(): void
    {
        Session::push(self::SESSION_KEY, [$this->type, $this->message]);
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'type' => $this->type,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
