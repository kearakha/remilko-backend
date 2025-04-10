<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeStep extends Model
{
    protected $table = 'recipe_steps';
    protected $fillable = [
        'recipe_id',
        'step_number',
        'step_description',
        'photo_step',
        'created_at',
        'updated_at'
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }
}
