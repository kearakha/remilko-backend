<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeNutrition extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'recipe_nutrition';
    protected $fillable = [
        'id',
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
