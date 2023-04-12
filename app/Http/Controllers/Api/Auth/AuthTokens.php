<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Carbon\Carbon;
use Laravel\Sanctum\NewAccessToken;

class AuthTokens
{
    private function __construct(public NewAccessToken $accessToken, public NewAccessToken $refreshToken)
    {
    }

    public static function forUser(User $user, string $deviceId): self
    {
        $accessToken = $user->createToken(
            name: $deviceId,
            abilities: ['access'],
            expiresAt: Carbon::now()->addHours(23)
        );

        $refreshToken = $user->createToken(
            name: $deviceId,
            abilities: ['refresh'],
            expiresAt: Carbon::now()->addYear(1)
        );

        return new self($accessToken, $refreshToken);
    }

    public function toMetaArray(): array
    {
        return [
            'access' => [
                'token' => $this->accessToken->plainTextToken,
                'expires_at' => $this->accessToken->accessToken->expires_at,
            ],
            'refresh' => [
                'token' => $this->refreshToken->plainTextToken,
                'expires_at' => $this->refreshToken->accessToken->expires_at,
            ],
        ];
    }
}
