<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacilityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'formatted_price' => $this->formatted_price,
            'capacity' => $this->capacity,
            'rating' => $this->rating,
            'total_bookings' => $this->total_bookings,
            'images' => $this->images,
            'primary_image' => $this->primary_image,
            'features' => $this->features,
            'is_available' => $this->is_available,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'facility_images' => FacilityImageResource::collection($this->whenLoaded('facilityImages')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
