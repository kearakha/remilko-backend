<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeNutrition extends Model
{
    protected $table = 'recipe_nutrition';
    protected $fillable = [
        'recipe_id',
        'nutrition_name',
        'nutrition_value',
        'nutrition_unit',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }
}
