<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function createUser(array $data): User
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'customer',
        ];

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $userData['image'] = $this->uploadImage($data['image']);
        }

        return User::create($userData);
    }

    public function updateUser(User $user, array $data): User
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ];

        if (isset($data['password']) && !empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        if (isset($data['role'])) {
            $userData['role'] = $data['role'];
        }

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Delete old image
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $userData['image'] = $this->uploadImage($data['image']);
        }

        $user->update($userData);
        return $user;
    }

    private function uploadImage(UploadedFile $file): string
    {
        return $file->store('users', 'public');
    }
}
