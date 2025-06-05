<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipeCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nasiGorengId = DB::table('recipes')->where('title', 'Nasi Goreng Sederhana')->value('id');
        $mieRebusId = DB::table('recipes')->where('title', 'Mie Rebus Telur')->value('id');
        $sandwichId = DB::table('recipes')->where('title', 'Sandwich Telur Keju')->value('id');
        $userId = DB::table('users')->where('role', 'user', 'creator')->value('id');

        DB::table('recipe_comments')->insert([
            [
                'id' => Str::random(8),
                'user_id' => $userId,
                'recipe_id' => $nasiGorengId,
                'comment_text' => 'Resepnya mudah diikuti, hasilnya enak!',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::random(8),
                'user_id' => $userId,
                'recipe_id' => $mieRebusId,
                'comment_text' => 'Mie rebusnya enak, tapi saya tambahkan sedikit sayuran.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::random(8),
                'user_id' => $userId,
                'recipe_id' => $sandwichId,
                'comment' => 'Sandwichnya lezat, saya suka dengan keju yang meleleh.',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
