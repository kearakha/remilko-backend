<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeNutritionResource extends JsonResource
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
            'calories' => $this->calories,
            'protein' => $this->protein,
            'carbohydrates' => $this->carbohydrates,
            'fat' => $this->fat,
            'fiber' => $this->fiber,
            'sugar' => $this->sugar,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
