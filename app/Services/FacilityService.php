<?php

namespace App\Services;

use App\Models\Facility;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FacilityService
{
    public function createFacility(array $data): Facility
    {
        $facilityData = [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'capacity' => $data['capacity'],
            'category_id' => $data['category_id'],
            'features' => $data['features'] ?? [],
            'is_available' => $data['is_available'] ?? true,
        ];

        if (isset($data['images']) && is_array($data['images'])) {
            $facilityData['images'] = $this->uploadImages($data['images']);
        }

        return Facility::create($facilityData);
    }

    public function updateFacility(Facility $facility, array $data): Facility
    {
        $facilityData = [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'capacity' => $data['capacity'],
            'category_id' => $data['category_id'],
            'features' => $data['features'] ?? [],
            'is_available' => $data['is_available'] ?? true,
        ];

        if (isset($data['images']) && is_array($data['images'])) {
            // Delete old images
            if ($facility->images) {
                foreach ($facility->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            $facilityData['images'] = $this->uploadImages($data['images']);
        }

        $facility->update($facilityData);
        return $facility;
    }

    public function deleteFacility(Facility $facility): bool
    {
        // Delete associated images
        if ($facility->images) {
            foreach ($facility->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        return $facility->delete();
    }

    public function checkAvailability(Facility $facility, string $checkIn, string $checkOut): bool
    {
        $bookingService = new BookingService();
        return $bookingService->isAvailable($facility, $checkIn, $checkOut);
    }

    private function uploadImages(array $images): array
    {
        $uploadedImages = [];
        
        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $uploadedImages[] = $image->store('facilities', 'public');
            }
        }

        return $uploadedImages;
    }
}
