<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipes';
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'rating',
        'price_estimate',
        'cook_time',
        'portion_size',
        'category',
        'label',
        'photo',
        'url_video',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function recipeIngredient()
    {
        return $this->hasMany(RecipeIngredient::class, 'recipe_id', 'id');
    }

    public function recipeStep()
    {
        return $this->hasMany(RecipeStep::class, 'recipe_id', 'id');
    }

    public function recipeTool()
    {
        return $this->hasMany(RecipeTool::class, 'recipe_id', 'id');
    }

    public function favorite()
    {
        return $this->hasMany(Favorite::class, 'recipe_id', 'id');
    }

    public function recipeNutrition()
    {
        return $this->hasMany(RecipeNutrition::class, 'recipe_id', 'id');
    }

    public function recook()
    {
        return $this->hasMany(Recook::class, 'recipe_id', 'id');
    }
}
