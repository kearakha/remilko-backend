<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeTool extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'recipe_tools';
    protected $fillable = [
        'id',
        'recipe_id',
        'tool_name',
        'created_at',
        'updated_at'
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }
}
