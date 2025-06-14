<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipeStepSeeder extends Seeder
{
    public function run()
    {
        $nasiGorengId = DB::table('recipes')->where('title', 'Nasi Goreng Sederhana')->value('id');
        $mieRebusId = DB::table('recipes')->where('title', 'Mie Rebus Telur')->value('id');
        $sandwichId = DB::table('recipes')->where('title', 'Sandwich Telur Keju')->value('id');

        DB::table('recipe_steps')->insert([
            [
                'id' => Str::random(8),
                'recipe_id' => $nasiGorengId,
                'step_number' => 1,
                'step_description' => 'Panaskan minyak, tumis bawang.'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $nasiGorengId,
                'step_number' => 2,
                'step_description' => 'Masukkan telur dan nasi, aduk rata.'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $mieRebusId,
                'step_number' => 1,
                'step_description' => 'Rebus mie hingga matang.'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $mieRebusId,
                'step_number' => 2,
                'step_description' => 'Tambahkan telur saat merebus.'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $sandwichId,
                'step_number' => 1,
                'step_description' => 'Goreng telur.'
            ],
            [
                'id' => Str::random(8),
                'recipe_id' => $sandwichId,
                'step_number' => 2,
                'step_description' => 'Susun telur dan keju di roti, panggang sebentar.'
            ],
        ]);
    }
}
