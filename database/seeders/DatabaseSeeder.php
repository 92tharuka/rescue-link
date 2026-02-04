<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if the admin already exists to prevent errors
        if (!User::where('email', 'admin@rescue.com')->exists()) {
            User::create([
                'name' => 'Rescue Admin',
                'email' => 'admin@rescue.com',
                'password' => Hash::make('password123'), // Encrypt the password
            ]);
        }
    }
}
