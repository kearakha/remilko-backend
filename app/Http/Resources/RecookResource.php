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
            'recipe_id' => $this->recipe_id,
            'user_id' => $this->user_id,
            'username' => $this->whenLoaded('user', function () {
                return $this->user->name ?? $this->user->username ?? 'Pengguna Tidak Dikenal';
            }),
            'recipe_id' => $this->recipe_id,
            // Mengambil recipe_title dari relasi recipe
            'recipe_title' => $this->whenLoaded('recipe', function () {
                return $this->recipe->title ?? 'Resep Tidak Dikenal';
            }),
            'recook_photo' => $this->photo_recook ? asset('images/recook/' . $this->photo_recook) : null,
            'status' => $this->status,
            'description' => $this->description,
            'difficulty' => $this->difficulty,
            'taste' => $this->taste,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
