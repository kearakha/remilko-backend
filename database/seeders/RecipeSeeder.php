<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipes = [
            [
                'user_id' => 1, // Sesuaikan dengan ID user yang ada
                'title' => 'Nasi Goreng Sederhana',
                'description' => 'Nasi goreng dengan bumbu minimalis, cocok untuk anak kos.',
                'rating' => 4.5,
                'price_estimate' => 15000,
                'cook_time' => 15,
                'portion_size' => '1-2 porsi',
                'category' => 'Hemat',
                'label' => 'Halal',
                'photo' => 'nasi-goreng.jpg',
                'url_video' => 'https://www.youtube.com/watch?v=example1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Mie Rebus Telur',
                'description' => 'Mie instan dengan tambahan telur dan sayur agar lebih sehat.',
                'rating' => 4.0,
                'price_estimate' => 10000,
                'cook_time' => 10,
                'portion_size' => '1 porsi',
                'category' => 'Tanpa Kompor',
                'label' => 'Halal',
                'photo' => 'mie-rebus.jpg',
                'url_video' => 'https://www.youtube.com/watch?v=example2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Sandwich Telur Keju',
                'description' => 'Sandwich praktis dengan isian telur dan keju.',
                'rating' => 4.7,
                'price_estimate' => 20000,
                'cook_time' => 5,
                'portion_size' => '1 porsi',
                'category' => 'Cepat Saji',
                'label' => 'Vegetarian',
                'photo' => 'sandwich.jpg',
                'url_video' => 'https://www.youtube.com/watch?v=example3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('recipes')->insert($recipes);
    }
}
