<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\RecipeStep;

class RecipeStepSeeder extends Seeder
{
    public function run()
    {
        $nasiGoreng = Recipe::where('title', 'Nasi Goreng Sederhana')->first();
        $mieRebus = Recipe::where('title', 'Mie Rebus Telur')->first();

        if ($nasiGoreng) {
            RecipeStep::create([
                'recipe_id' => $nasiGoreng->id,
                'step_number' => 1,
                'step_description' => 'Panaskan minyak di wajan.',
                'photo_step' => 'https://example.com/photo1-1.jpg'
            ]);

            RecipeStep::create([
                'recipe_id' => $nasiGoreng->id,
                'step_number' => 2,
                'step_description' => 'Masukkan bumbu halus dan tumis hingga harum.',
                'photo_step' => 'https://example.com/photo1-2.jpg'
            ]);

            RecipeStep::create([
                'recipe_id' => $nasiGoreng->id,
                'step_number' => 3,
                'step_description' => 'Tambahkan nasi dan aduk rata.',
                'photo_step' => 'https://example.com/photo1-3.jpg'
            ]);
        }

        if ($mieRebus) {
            RecipeStep::create([
                'recipe_id' => $mieRebus->id,
                'step_number' => 1,
                'step_description' => 'siapkan barang barangnya terlebih dahulu.',
                'photo_step' => "https://example.com/photo1.jpg"
            ]);

            RecipeStep::create([
                'recipe_id' => $mieRebus->id,
                'step_number' => 2,
                'step_description' => 'masak air hingga mendidih.',
                'photo_step' => 'https://example.com/photo2.jpg'
            ]);

            RecipeStep::create([
                'recipe_id' => $mieRebus->id,
                'step_number' => 3,
                'step_description' => 'masukkan semua dan tunggu hingga matang.',
                'photo_step' => 'https://example.com/photo3.jpg'
            ]);

            RecipeStep::create([
                'recipe_id' => $mieRebus->id,
                'step_number' => 4,
                'step_description' => 'sajikan di mangkok kesayangan anda!',
                'photo_step' => 'https://example.com/photo4.jpg'
            ]);
        }
    }
}
