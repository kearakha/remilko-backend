<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeStepResource extends JsonResource
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
                'step_number' => $this->step_number,
                'step_description' => $this->step_description,
                'photo_step' => $this->photo_step ? asset('images/recipe/step/' . $this->photo_step) : null,
            ];
    }
}
