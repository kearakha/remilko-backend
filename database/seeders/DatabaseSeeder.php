<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Recipe;
use App\Models\Recook;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RecipeSeeder;
use Database\Seeders\RecipeStepSeeder;
use Database\Seeders\RecipeIngredientSeeder;
use Database\Seeders\RecipeCategorySeeder;
use Database\Seeders\RecipeToolSeeder;
use Database\Seeders\RecipeNutritionSeeder;
use Database\Seeders\CommentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RecipeSeeder::class,
            RecipeStepSeeder::class,
            RecipeIngredientSeeder::class,
            RecipeCategorySeeder::class,
            RecipeToolSeeder::class,
            RecipeNutritionSeeder::class,
            RecipeCommentSeeder::class,
            RecookSeeder::class,
        ]);
    }
}
