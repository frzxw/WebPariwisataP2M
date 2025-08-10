<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'facility' => new FacilityResource($this->whenLoaded('facility')),
            'booking_id' => $this->booking_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'images' => $this->images,
            'is_approved' => $this->is_approved,
            'formatted_date' => $this->formatted_date,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
