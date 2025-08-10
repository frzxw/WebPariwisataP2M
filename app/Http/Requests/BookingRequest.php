<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'facility_id' => 'required|exists:facilities,id',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:50',
            'payment_method' => 'required|in:cash,transfer,credit_card,e_wallet',
            'special_requests' => 'nullable|string|max:500',
            'addons' => 'nullable|array',
            'addons.*.id' => 'required_with:addons|exists:addons,id',
            'addons.*.quantity' => 'required_with:addons|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'facility_id.required' => 'Facility is required',
            'facility_id.exists' => 'Selected facility does not exist',
            'check_in.required' => 'Check-in date is required',
            'check_in.after' => 'Check-in date must be in the future',
            'check_out.required' => 'Check-out date is required',
            'check_out.after' => 'Check-out date must be after check-in date',
            'guests.required' => 'Number of guests is required',
            'guests.min' => 'At least 1 guest is required',
            'guests.max' => 'Maximum 50 guests allowed',
            'payment_method.required' => 'Payment method is required',
            'payment_method.in' => 'Invalid payment method selected',
            'special_requests.max' => 'Special requests cannot exceed 500 characters',
            'addons.*.id.exists' => 'Selected addon does not exist',
            'addons.*.quantity.min' => 'Addon quantity must be at least 1',
        ];
    }
}
