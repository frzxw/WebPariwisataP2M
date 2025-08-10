<?php

namespace App\Services;

use App\Models\Facility;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchService
{
    public function searchFacilities(array $filters): LengthAwarePaginator
    {
        $query = Facility::with(['category', 'reviews'])
            ->available();

        // Search by query
        if (!empty($filters['query'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['query'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['query'] . '%');
            });
        }

        // Filter by category
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Filter by price range
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // Filter by capacity
        if (!empty($filters['capacity'])) {
            $query->where('capacity', '>=', $filters['capacity']);
        }

        // Check availability for dates
        if (!empty($filters['check_in']) && !empty($filters['check_out'])) {
            $query->whereDoesntHave('bookings', function ($q) use ($filters) {
                $q->whereIn('booking_status', ['confirmed', 'checked_in'])
                  ->where(function ($subQ) use ($filters) {
                      $subQ->whereBetween('check_in', [$filters['check_in'], $filters['check_out']])
                           ->orWhereBetween('check_out', [$filters['check_in'], $filters['check_out']])
                           ->orWhere(function ($dateQ) use ($filters) {
                               $dateQ->where('check_in', '<=', $filters['check_in'])
                                     ->where('check_out', '>=', $filters['check_out']);
                           });
                  });
            });
        }

        // Filter by features
        if (!empty($filters['features'])) {
            foreach ($filters['features'] as $feature) {
                $query->whereJsonContains('features', $feature);
            }
        }

        // Sorting
        $sortBy = $filters['sort_by'] ?? 'latest';
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        return $query->paginate(12);
    }

    public function getSuggestions(string $query): array
    {
        $facilities = Facility::where('name', 'like', '%' . $query . '%')
            ->available()
            ->limit(5)
            ->pluck('name');

        $categories = \App\Models\Category::where('name', 'like', '%' . $query . '%')
            ->active()
            ->limit(3)
            ->pluck('name');

        return [
            'facilities' => $facilities->toArray(),
            'categories' => $categories->toArray(),
        ];
    }
}
