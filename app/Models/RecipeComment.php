<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeComment extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'recipe_comments';
    protected $fillable = [
        'id',
        'user_id',
        'recipe_id',
        'comment_text',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }
}
