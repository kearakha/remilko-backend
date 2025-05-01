<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin', // Sesuaikan jika ada field role
                'photo_user' => 'images1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Recipe Creator',
                'email' => 'creator@example.com',
                'password' => Hash::make('password123'),
                'role' => 'creator',
                'photo_user' => 'images2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'photo_user' => 'images3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
