<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipeIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nasiGorengId = DB::table('recipes')->where('title', 'Nasi Goreng Sederhana')->value('id');
        $mieRebusId = DB::table('recipes')->where('title', 'Mie Rebus Telur')->value('id');
        $sandwichId = DB::table('recipes')->where('title', 'Sandwich Telur Keju')->value('id');

        DB::table('recipe_ingredients')->insert([
            [
                'id' => Str::random(8),
                'recipe_id' => $nasiGorengId,
                'ingredient_name' => 'Nasi putih',
                'ingredient_amount' => '1',
                'ingredient_unit' => 'piring'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $nasiGorengId,
                'ingredient_name' => 'Telur',
                'ingredient_amount' => '1',
                'ingredient_unit' => 'butir'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $mieRebusId,
                'ingredient_name' => 'Mie instan',
                'ingredient_amount' => '1',
                'ingredient_unit' => 'bungkus'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $mieRebusId,
                'ingredient_name' => 'Telur',
                'ingredient_amount' => '1',
                'ingredient_unit' => 'butir'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $sandwichId,
                'ingredient_name' => 'Roti tawar',
                'ingredient_amount' => '2',
                'ingredient_unit' => 'lembar'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $sandwichId,
                'ingredient_name' => 'Keju',
                'ingredient_amount' => '1',
                'ingredient_unit' => 'lembar'
            ],
        ]);
    }
}
