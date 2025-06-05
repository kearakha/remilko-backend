<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeIngredientsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'id' => $this->id,
                'recipe_id' => $this->recipe_id,
                'ingredient_name' => $this->ingredient_name,
                'ingredient_amount' => $this->ingredient_amount,
                'ingredient_unit' => $this->ingredient_unit,
            ];
    }
}
