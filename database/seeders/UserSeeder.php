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
                'id' => Str::random(8),
                'username' => 'Admin',
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin', // Sesuaikan jika ada field role
                'photo_user' => null,
                'status' => 'Diterima',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::random(8),
                'username' => 'Admin2',
                'name' => 'Administrator',
                'email' => 'admin2@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin', // Sesuaikan jika ada field role
                'photo_user' => null,
                'status' => 'Diterima',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::random(8),
                'username' => 'najwahajah',
                'name' => 'Najwah Kamilah',
                'email' => 'creator@example.com',
                'password' => Hash::make('password123'),
                'role' => 'creator',
                'status' => 'Diterima',
                'photo_user' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::random(8),
                'username' => 'puffer',
                'name' => 'Pufferfish',
                'email' => 'creator2@example.com',
                'password' => Hash::make('password123'),
                'role' => 'creator',
                'status' => 'Menunggu',
                'photo_user' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::random(8),
                'username' => 'Hirarea',
                'name' => 'Sabrina Carpenter',
                'email' => 'user@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'photo_user' => null,
                'status' => 'Diterima',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
