<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampingPlotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'camping_location_id' => $this->camping_location_id,
            'plot_number' => $this->plot_number,
            'plot_type' => $this->plot_type,
            'max_capacity' => $this->max_capacity,
            'price_per_night' => $this->price_per_night,
            'formatted_price' => 'Rp ' . number_format($this->price_per_night, 0, ',', '.'),
            'description' => $this->description,
            'amenities' => $this->amenities,
            'is_available' => $this->is_available,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Relationships
            'location' => new CampingLocationResource($this->whenLoaded('location')),
            
            // Computed fields
            'availability_status' => $this->when(isset($this->check_dates), function () {
                return $this->isAvailableForDates($this->check_dates['check_in'], $this->check_dates['check_out'])
                    ? 'available'
                    : 'unavailable';
            }),
        ];
    }
}
