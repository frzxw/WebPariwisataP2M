<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampingLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'featured_image' => $this->featured_image,
            'rating' => $this->rating,
            'total_reviews' => $this->total_reviews,
            'facilities' => $this->facilities,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Conditionally loaded relationships
            'plots' => CampingPlotResource::collection($this->whenLoaded('campingPlots')),
            'plot_count' => $this->when(isset($this->plots_count), $this->plots_count),
            'available_plots' => $this->when(isset($this->available_plots), $this->available_plots),
            'min_price' => $this->when(isset($this->min_price), $this->min_price),
            'max_price' => $this->when(isset($this->max_price), $this->max_price),
            'formatted_min_price' => $this->when(isset($this->min_price), 'Rp ' . number_format($this->min_price, 0, ',', '.')),
            'formatted_max_price' => $this->when(isset($this->max_price), 'Rp ' . number_format($this->max_price, 0, ',', '.')),
        ];
    }
}
