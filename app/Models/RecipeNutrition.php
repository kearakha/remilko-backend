<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeNutrition extends Model
{
    protected $table = 'recipe_nutritions';
    protected $fillable = [
        'recipe_id',
        'calories',
        'carbohydrates',
        'protein',
        'fat',
        'saturated_fat',
        'cholesterol',
        'sodium',
        'fiber',
        'sugar',
        'vitamin_d',
        'calcium',
        'iron',
        'potassium',
        'created_at',
        'updated_at'
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }
}
