<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'formatted_price' => $this->formatted_price,
            'type' => $this->type,
            'is_available' => $this->is_available,
            'image_url' => $this->image_url,
            'quantity' => $this->when(isset($this->pivot), $this->pivot->quantity),
            'unit_price' => $this->when(isset($this->pivot), $this->pivot->unit_price),
            'total_price' => $this->when(isset($this->pivot), $this->pivot->total_price),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
