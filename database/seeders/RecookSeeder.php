<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nasiGorengId = DB::table('recipes')->where('title', 'Nasi Goreng Sederhana')->value('id');
        $mieRebusId = DB::table('recipes')->where('title', 'Mie Rebus Telur')->value('id');
        $sandwichId = DB::table('recipes')->where('title', 'Sandwich Telur Keju')->value('id');
        $userId = DB::table('users')->where('role', 'user')->value('id');

        DB::table('recooks')->insert([
            [
                'id' => Str::random(8),
                'user_id' => $userId,
                'recipe_id' => $nasiGorengId,
                'photo_recook' => null,
                'difficulty' => 'Mudah',
                'taste' => 'Enak',
                'description' => 'Enak banget!',
                'status' => 'Diterima',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::random(8),
                'user_id' => $userId,
                'recipe_id' => $sandwichId,
                'photo_recook' => null,
                'difficulty' => 'Sedang',
                'taste' => 'Biasa',
                'description' => 'Cukup oke',
                'status' => 'Diterima',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::random(8),
                'user_id' => $userId,
                'recipe_id' => $mieRebusId,
                'photo_recook' => null,
                'difficulty' => 'Mudah',
                'taste' => 'Biasa',
                'description' => 'Cukup oke',
                'status' => 'Diterima',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
