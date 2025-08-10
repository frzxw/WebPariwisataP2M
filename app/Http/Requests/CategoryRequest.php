<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;
        
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $categoryId,
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required',
            'name.unique' => 'This category name already exists',
            'icon.image' => 'Icon must be an image file',
            'icon.mimes' => 'Icon must be jpeg, png, jpg, gif, or svg format',
            'icon.max' => 'Icon size must not exceed 1MB',
        ];
    }
}
