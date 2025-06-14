<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
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
                'title' => $this->title,
                'description' => $this->description,
                'rating' => $this->rating,
                'price_estimate' => $this->price_estimate,
                'cook_time' => $this->cook_time,
                'portion_size' => $this->portion_size,
                'label' => $this->label,
                'photo' => $this->photo ? asset($this->photo) : null,
                'url_video' => $this->url_video,
                'is_recommended' => $this->is_recommended,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
    }
}
