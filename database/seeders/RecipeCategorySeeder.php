<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class recipeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nasiGorengId = DB::table('recipes')->where('title', 'Nasi Goreng Sederhana')->value('id');
        $mieRebusId = DB::table('recipes')->where('title', 'Mie Rebus Telur')->value('id');
        $sandwichId = DB::table('recipes')->where('title', 'Sandwich Telur Keju')->value('id');

        DB::table('recipe_categories')->insert([
            [
                'id' => Str::random(8),
                'recipe_id' => $nasiGorengId,
                'category_name' => 'Makan Siang'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $mieRebusId,
                'category_name' => 'Makan Malam'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $sandwichId,
                'category_name' => 'Sarapan'
            ]
        ]);
    }
}
