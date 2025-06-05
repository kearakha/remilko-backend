<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_id = User::where('role', 'admin')->first()->id;
        $recipes = [
            [
                'id' => Str::random(8),
                'user_id' => $user_id,
                'title' => 'Nasi Goreng Sederhana',
                'description' => 'Nasi goreng dengan bumbu minimalis, cocok untuk anak kos.',
                'rating' => 4.5,
                'price_estimate' => 15000,
                'cook_time' => 15,
                'portion_size' => '1-2 porsi',
                'label' => 'Halal',
                'photo' => asset('/images/recipes/makan-siang.jpg'),
                'url_video' => 'https://www.youtube.com/watch?v=example1',
                'is_recommended' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::random(8),
                'user_id' => $user_id,
                'title' => 'Mie Rebus Telur',
                'description' => 'Mie instan dengan tambahan telur dan sayur agar lebih sehat.',
                'rating' => 4.0,
                'price_estimate' => 10000,
                'cook_time' => 10,
                'portion_size' => '1 porsi',
                'label' => 'Halal',
                'photo' => asset('/images/recipes/makan-malam.jpg'),
                'url_video' => 'https://www.youtube.com/watch?v=example2',
                'is_recommended' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::random(8),
                'user_id' => $user_id,
                'title' => 'Sandwich Telur Keju',
                'description' => 'Sandwich praktis dengan isian telur dan keju.',
                'rating' => 4.7,
                'price_estimate' => 20000,
                'cook_time' => 5,
                'portion_size' => '1 porsi',
                'label' => 'Vegetarian',
                'photo' => asset('/images/recipes/sarapan.jpg'),
                'url_video' => 'https://www.youtube.com/watch?v=example3',
                'is_recommended' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('recipes')->insert($recipes);
    }
}
