<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeStep extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'recipe_steps';
    protected $fillable = [
        'id',
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
