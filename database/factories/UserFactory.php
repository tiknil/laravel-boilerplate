<?php

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),

            'role' => UserRole::User,

        ];
    }

    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => UserRole::Admin,
            ];
        });
    }
}
