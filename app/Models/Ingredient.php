<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'ingredients';
    protected $fillable = ['ingredient_name', 'photo_ingredient', 'calories'];

    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::class, 'ingredient_id', 'id');
    }
}

