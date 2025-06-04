<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'recipe_ingredients';
    protected $fillable = [
        'id',
        'recipe_id',
        'ingredient_name',
        'ingredient_amount',
        'ingredient_unit',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }
}
