<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'payment_gateway' => $this->payment_gateway,
            'transaction_id' => $this->transaction_id,
            'amount' => $this->amount,
            'formatted_amount' => $this->formatted_amount,
            'response_data' => $this->response_data,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
