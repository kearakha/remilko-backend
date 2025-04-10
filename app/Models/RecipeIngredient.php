<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    protected $table = 'recipe_ingredients';
    protected $fillable = [
        'recipe_id',
        'ingredient_id', // Diganti dari ingredient_name ke ingredient_id
        'amount',
        'unit'
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'id'); // Relasi ke Ingredient
    }
}
