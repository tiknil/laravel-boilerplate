<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::where('email', 'info@tiknil.com')->doesntExist()) {
            User::factory()->admin()->create([
                'email' => 'info@tiknil.com',
            ]);
        }

    }
}
