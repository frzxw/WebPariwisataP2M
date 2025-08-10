<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'facility_id' => 'required|exists:facilities,id',
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'facility_id.required' => 'Facility is required',
            'facility_id.exists' => 'Selected facility does not exist',
            'booking_id.required' => 'Booking is required',
            'booking_id.exists' => 'Selected booking does not exist',
            'rating.required' => 'Rating is required',
            'rating.integer' => 'Rating must be a number',
            'rating.min' => 'Rating must be at least 1',
            'rating.max' => 'Rating cannot exceed 5',
            'comment.required' => 'Comment is required',
            'comment.max' => 'Comment cannot exceed 1000 characters',
            'images.max' => 'Maximum 5 images allowed',
            'images.*.image' => 'Each file must be an image',
            'images.*.mimes' => 'Images must be jpeg, png, or jpg format',
            'images.*.max' => 'Each image must not exceed 2MB',
        ];
    }
}
