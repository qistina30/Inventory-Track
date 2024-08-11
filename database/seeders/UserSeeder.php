<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ali',
            'email' => 'ali12@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'), // Always hash passwords
            'userCategory' => 'staff',
        ]);

        User::create([
            'name' => 'Nur Qistina',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'), // Always hash passwords
            'userCategory' => 'admin',
        ]);
    }
}
