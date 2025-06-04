<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeToolResource extends JsonResource
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
                'tool_name' => $this->tool_name,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
    }
}
