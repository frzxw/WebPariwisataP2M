<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|array',
            'is_available' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Facility name is required',
            'description.required' => 'Description is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be at least 0',
            'capacity.required' => 'Capacity is required',
            'capacity.integer' => 'Capacity must be an integer',
            'capacity.min' => 'Capacity must be at least 1',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Selected category does not exist',
            'images.*.image' => 'Each file must be an image',
            'images.*.mimes' => 'Images must be jpeg, png, jpg, or gif format',
            'images.*.max' => 'Each image must not exceed 2MB',
        ];
    }
}
