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
                'nutrition_name' => $this->nutrition_name,
                'nutrition_value' => $this->nutrition_value,
                'nutrition_unit' => $this->nutrition_unit,
            ];
    }
}
