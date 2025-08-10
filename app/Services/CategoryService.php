<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function createCategory(array $data): Category
    {
        $categoryData = [
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ];

        if (isset($data['icon']) && $data['icon'] instanceof UploadedFile) {
            $categoryData['icon'] = $this->uploadIcon($data['icon']);
        }

        return Category::create($categoryData);
    }

    public function updateCategory(Category $category, array $data): Category
    {
        $categoryData = [
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ];

        if (isset($data['icon']) && $data['icon'] instanceof UploadedFile) {
            // Delete old icon
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
            $categoryData['icon'] = $this->uploadIcon($data['icon']);
        }

        $category->update($categoryData);
        return $category;
    }

    private function uploadIcon(UploadedFile $file): string
    {
        return $file->store('categories', 'public');
    }
}
