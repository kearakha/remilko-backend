<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecipeCategory extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'recipe_id',
        'category_name',
        'photo_category',
    ];

    public function recipe()
    {
        return $this->hasMany(Recipe::class);
    }
}
