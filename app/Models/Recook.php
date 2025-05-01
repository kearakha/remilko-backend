<?php

namespace App\Models;

use App\Models\Recipe;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Recook extends Model
{
    protected $table = 'recooks';
    protected $fillable = [
        'recipe_id',
        'user_id',
        'photo_recook',
        'difficulty',
        'taste',
        'description',
        'created_at',
        'updated_at'
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
