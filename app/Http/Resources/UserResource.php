<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'image_url' => $this->image_url,
            'total_transactions' => $this->total_transactions,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'bookings' => BookingResource::collection($this->whenLoaded('bookings')),
        ];
    }
}
