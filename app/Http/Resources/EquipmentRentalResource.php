<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentRentalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'description' => $this->description,
            'price_per_day' => $this->price_per_day,
            'formatted_price' => 'Rp ' . number_format($this->price_per_day, 0, ',', '.'),
            'stock_quantity' => $this->stock_quantity,
            'is_available' => $this->is_available,
            'image_url' => $this->image_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Computed fields
            'available_stock' => $this->when(method_exists($this, 'getAvailableStock'), $this->getAvailableStock()),
            'is_in_stock' => $this->stock_quantity > 0 && $this->is_available,
            'rental_count' => $this->when(isset($this->booking_addons_count), $this->booking_addons_count),
            'popularity_rank' => $this->when(isset($this->popularity_rank), $this->popularity_rank),
        ];
    }
}
