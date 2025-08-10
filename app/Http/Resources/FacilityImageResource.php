<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacilityImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image_url' => $this->image_url,
            'alt_text' => $this->alt_text,
            'sort_order' => $this->sort_order,
            'is_primary' => $this->is_primary,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
