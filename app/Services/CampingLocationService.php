<?php

namespace App\Services;

use App\Models\CampingLocation;
use App\Models\CampingPlot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CampingLocationService
{
    /**
     * Get available camping locations with optional filtering
     */
    public function getAvailableLocations(array $filters = []): Collection
    {
        return CampingLocation::query()
            ->active()
            ->with(['campingPlots' => function ($query) {
                $query->available()->orderBy('price_per_night');
            }])
            ->when(isset($filters['search']), function ($query) use ($filters) {
                $query->where('name', 'like', "%{$filters['search']}%")
                      ->orWhere('description', 'like', "%{$filters['search']}%");
            })
            ->ordered()
            ->get();
    }

    /**
     * Get location with its available plots
     */
    public function getLocationWithPlots(CampingLocation $location): CampingLocation
    {
        return $location->load([
            'campingPlots' => function ($query) {
                $query->available()
                      ->orderBy('price_per_night')
                      ->withCount(['bookings as active_bookings_count' => function ($q) {
                          $q->whereIn('status', ['pending', 'confirmed', 'checked_in']);
                      }]);
            }
        ]);
    }

    /**
     * Get available plots for specific dates
     */
    public function getAvailablePlots(
        CampingLocation $location,
        string $checkInDate,
        string $checkOutDate,
        int $guests = 1
    ): Collection {
        return $location->campingPlots()
            ->available()
            ->where('max_capacity', '>=', $guests)
            ->whereDoesntHave('bookings', function ($query) use ($checkInDate, $checkOutDate) {
                $query->where('status', '!=', 'cancelled')
                      ->where(function ($q) use ($checkInDate, $checkOutDate) {
                          $q->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                            ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                            ->orWhere(function ($subQuery) use ($checkInDate, $checkOutDate) {
                                $subQuery->where('check_in_date', '<=', $checkInDate)
                                         ->where('check_out_date', '>=', $checkOutDate);
                            });
                      });
            })
            ->orderBy('price_per_night')
            ->get();
    }

    /**
     * Get location statistics
     */
    public function getLocationStatistics(CampingLocation $location): array
    {
        $totalPlots = $location->campingPlots()->count();
        $availablePlots = $location->campingPlots()->available()->count();
        $bookedPlots = $location->campingPlots()
            ->whereHas('bookings', function ($query) {
                $query->whereIn('status', ['confirmed', 'checked_in'])
                      ->where('check_in_date', '<=', now())
                      ->where('check_out_date', '>=', now());
            })
            ->count();

        return [
            'total_plots' => $totalPlots,
            'available_plots' => $availablePlots,
            'booked_plots' => $bookedPlots,
            'occupancy_rate' => $totalPlots > 0 ? round(($bookedPlots / $totalPlots) * 100, 2) : 0
        ];
    }
}
