<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipeNutritionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nasiGorengId = DB::table('recipes')->where('title', 'Nasi Goreng Sederhana')->value('id');
        $mieRebusId = DB::table('recipes')->where('title', 'Mie Rebus Telur')->value('id');
        $sandwichId = DB::table('recipes')->where('title', 'Sandwich Telur Keju')->value('id');

        DB::table('recipe_nutrition')->insert([
            [
                'id' => Str::random(8),
                'recipe_id' => $nasiGorengId,
                'nutrition_name' => 'Kalori',
                'nutrition_value' => 500,
                'nutrition_unit' => 'kcal'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $mieRebusId,
                'nutrition_name' => 'Kalori',
                'nutrition_value' => 450,
                'nutrition_unit' => 'kcal'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $sandwichId,
                'nutrition_name' => 'Kalori',
                'nutrition_value' => 350,
                'nutrition_unit' => 'kcal'
            ]
        ]);
    }
}
