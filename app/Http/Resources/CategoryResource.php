<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon_url' => $this->icon_url,
            'is_active' => $this->is_active,
            'facilities_count' => $this->when(isset($this->facilities_count), $this->facilities_count),
            'facilities' => FacilityResource::collection($this->whenLoaded('facilities')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
