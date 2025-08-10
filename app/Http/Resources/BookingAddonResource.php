<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingAddonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'plot_booking_id' => $this->plot_booking_id,
            'equipment_rental_id' => $this->equipment_rental_id,
            'quantity' => $this->quantity,
            'price_per_day' => $this->price_per_day,
            'days' => $this->days,
            'total_price' => $this->total_price,
            'formatted_price_per_day' => 'Rp ' . number_format($this->price_per_day, 0, ',', '.'),
            'formatted_total_price' => 'Rp ' . number_format($this->total_price, 0, ',', '.'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Relationship
            'equipment' => new EquipmentRentalResource($this->whenLoaded('equipmentRental')),
            
            // Computed fields
            'subtotal_breakdown' => [
                'quantity' => $this->quantity,
                'price_per_day' => $this->price_per_day,
                'days' => $this->days,
                'calculation' => "{$this->quantity} × Rp " . number_format($this->price_per_day, 0, ',', '.') . " × {$this->days} hari",
                'total' => $this->total_price,
            ],
        ];
    }
}
