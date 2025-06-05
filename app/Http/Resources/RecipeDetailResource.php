<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RecipeNutritionResource;
use App\Http\Resources\RecipeStepResource;
use App\Http\Resources\RecipeToolResource;
use App\Http\Resources\RecookResource;
use App\Http\Resources\RecipeIngredientsResource;

class RecipeDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'photo' => $this->photo,
            'rating' => $this->rating,
            'cook_time' => $this->cook_time,
            'portion_size' => $this->portion_size,
            'category' => $this->category,
            'label' => $this->label,
            'user' => UserResource::make($this->whenLoaded('user')),
            'ingredients' => RecipeIngredientsResource::collection($this->whenLoaded('recipeIngredient')),
            'tools' => RecipeToolResource::collection($this->whenLoaded('recipeTool')),
            'nutrition' => RecipeNutritionResource::collection($this->whenLoaded('recipeNutrition')),
            'steps' => RecipeStepResource::collection($this->whenLoaded('recipeStep')),
            'comments' => RecipeCommentResource::collection($this->whenLoaded('comments')),
            'recooks' => RecookResource::collection($this->whenLoaded('recook')),
        ];
    }
}
