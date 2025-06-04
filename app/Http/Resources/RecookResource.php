<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecookResource extends JsonResource
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
            'photo_recook' => $this->photo_recook ? asset($this->photo_recook) : null,
            'recipe_id' => $this->recipe_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'recipe' => new RecipeResource($this->whenLoaded('recipe')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
