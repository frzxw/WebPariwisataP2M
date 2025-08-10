<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    private array $allowedMimes = [
        'facility' => ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'],
        'user' => ['image/jpeg', 'image/png', 'image/jpg'],
        'review' => ['image/jpeg', 'image/png', 'image/jpg'],
        'payment_proof' => ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'],
    ];

    private array $maxSizes = [
        'facility' => 2048, // 2MB
        'user' => 1024, // 1MB
        'review' => 2048, // 2MB
        'payment_proof' => 5120, // 5MB
    ];

    public function uploadImage(UploadedFile $file, string $type): array
    {
        $this->validateFile($file, $type);

        $path = $file->store($type, 'public');

        return [
            'success' => true,
            'path' => $path,
            'url' => Storage::url($path),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
    }

    public function deleteImage(string $path): array
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            
            return [
                'success' => true,
                'message' => 'Image deleted successfully'
            ];
        }

        return [
            'success' => false,
            'message' => 'Image not found'
        ];
    }

    private function validateFile(UploadedFile $file, string $type): void
    {
        if (!isset($this->allowedMimes[$type])) {
            throw new \Exception('Invalid file type');
        }

        if (!in_array($file->getMimeType(), $this->allowedMimes[$type])) {
            throw new \Exception('File format not allowed');
        }

        if ($file->getSize() > $this->maxSizes[$type] * 1024) {
            throw new \Exception('File size too large');
        }
    }
}
