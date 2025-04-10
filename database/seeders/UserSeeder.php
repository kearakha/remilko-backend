<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin', // Sesuaikan jika ada field role
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Recipe Creator',
                'email' => 'creator@example.com',
                'password' => Hash::make('password123'),
                'role' => 'creator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
