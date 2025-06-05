<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipeToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nasiGorengId = DB::table('recipes')->where('title', 'Nasi Goreng Sederhana')->value('id');
        $mieRebusId = DB::table('recipes')->where('title', 'Mie Rebus Telur')->value('id');
        $sandwichId = DB::table('recipes')->where('title', 'Sandwich Telur Keju')->value('id');

        DB::table('recipe_tools')->insert([
            [
                'id' => Str::random(8),
                'recipe_id' => $nasiGorengId,
                'tool_name' => 'Wajan'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $mieRebusId,
                'tool_name' => 'Panci'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $sandwichId,
                'tool_name' => 'Teflon'
            ]
        ]);
    }
}
