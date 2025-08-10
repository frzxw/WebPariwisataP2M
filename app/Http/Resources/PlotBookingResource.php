<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlotBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'booking_code' => $this->booking_code,
            'camping_plot_id' => $this->camping_plot_id,
            'user_id' => $this->user_id,
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'check_in_name' => $this->check_in_name,
            'check_out_name' => $this->check_out_name,
            'guests_count' => $this->guests_count,
            'plot_price' => $this->plot_price,
            'addons_total' => $this->addons_total,
            'total_amount' => $this->total_amount,
            'formatted_plot_price' => 'Rp ' . number_format($this->plot_price, 0, ',', '.'),
            'formatted_addons_total' => 'Rp ' . number_format($this->addons_total, 0, ',', '.'),
            'formatted_total_amount' => 'Rp ' . number_format($this->total_amount, 0, ',', '.'),
            'payment_status' => $this->payment_status,
            'status' => $this->status,
            'special_requests' => $this->special_requests,
            'confirmed_at' => $this->confirmed_at,
            'cancelled_at' => $this->cancelled_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Computed fields
            'duration_nights' => $this->getDurationInNights(),
            'can_be_cancelled' => $this->canBeCancelled(),
            'is_past_booking' => $this->check_out_date < now()->toDateString(),
            'is_upcoming' => $this->check_in_date > now()->toDateString(),
            'is_current' => $this->check_in_date <= now()->toDateString() && $this->check_out_date >= now()->toDateString(),
            
            // Relationships
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ];
            }),
            'camping_plot' => new CampingPlotResource($this->whenLoaded('campingPlot')),
            'location' => $this->whenLoaded('campingPlot.location', function () {
                return new CampingLocationResource($this->campingPlot->location);
            }),
            'equipment_addons' => BookingAddonResource::collection($this->whenLoaded('bookingAddons')),
            'payment_logs' => $this->whenLoaded('paymentLogs', function () {
                return $this->paymentLogs->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'amount' => $log->amount,
                        'formatted_amount' => 'Rp ' . number_format($log->amount, 0, ',', '.'),
                        'payment_method' => $log->payment_method,
                        'status' => $log->status,
                        'transaction_id' => $log->transaction_id,
                        'paid_at' => $log->paid_at,
                        'created_at' => $log->created_at,
                    ];
                });
            }),
            'reviews' => $this->whenLoaded('reviews', function () {
                return $this->reviews->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'created_at' => $review->created_at,
                    ];
                });
            }),
        ];
    }
}
