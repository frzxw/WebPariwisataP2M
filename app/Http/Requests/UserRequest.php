<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;
        
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'phone' => 'nullable|string|max:20',
            'password' => $this->isMethod('POST') ? 'required|string|min:6' : 'nullable|string|min:6',
            'role' => 'required|in:admin,customer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please provide a valid email address',
            'email.unique' => 'This email is already taken',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'role.required' => 'Role is required',
            'role.in' => 'Role must be either admin or customer',
            'image.image' => 'File must be an image',
            'image.mimes' => 'Image must be jpeg, png, or jpg format',
            'image.max' => 'Image size must not exceed 1MB',
        ];
    }
}
