<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'booking_code' => $this->booking_code,
            'user' => new UserResource($this->whenLoaded('user')),
            'facility' => new FacilityResource($this->whenLoaded('facility')),
            'check_in' => $this->check_in->format('Y-m-d H:i'),
            'check_out' => $this->check_out->format('Y-m-d H:i'),
            'duration' => $this->duration,
            'guests' => $this->guests,
            'subtotal' => $this->subtotal,
            'tax_amount' => $this->tax_amount,
            'total_amount' => $this->total_amount,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'booking_status' => $this->booking_status,
            'status_badge' => $this->status_badge,
            'special_requests' => $this->special_requests,
            'cancellation_reason' => $this->cancellation_reason,
            'cancelled_at' => $this->cancelled_at?->format('Y-m-d H:i:s'),
            'payment_proof' => $this->payment_proof,
            'can_be_cancelled' => $this->canBeCancelled(),
            'addons' => AddonResource::collection($this->whenLoaded('addons')),
            'payment_logs' => PaymentLogResource::collection($this->whenLoaded('paymentLogs')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
