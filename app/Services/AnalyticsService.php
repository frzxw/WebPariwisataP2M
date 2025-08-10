<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public function getOverviewStats(string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);
        
        return [
            'total_bookings' => Booking::whereBetween('created_at', $dateRange)->count(),
            'total_revenue' => Booking::paid()->whereBetween('created_at', $dateRange)->sum('total_amount'),
            'total_customers' => User::customers()->whereBetween('created_at', $dateRange)->count(),
            'total_facilities' => Facility::available()->count(),
            'pending_bookings' => Booking::pending()->whereBetween('created_at', $dateRange)->count(),
            'cancelled_bookings' => Booking::where('booking_status', 'cancelled')
                ->whereBetween('created_at', $dateRange)->count(),
        ];
    }

    public function getRevenueStats(string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);
        
        $revenue = Booking::paid()
            ->whereBetween('created_at', $dateRange)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $revenue->pluck('date'),
            'data' => $revenue->pluck('total'),
            'total' => $revenue->sum('total')
        ];
    }

    public function getBookingStats(string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);
        
        $bookings = Booking::whereBetween('created_at', $dateRange)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $bookings->pluck('date'),
            'data' => $bookings->pluck('total'),
            'total' => $bookings->sum('total')
        ];
    }

    public function getFacilityStats(string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);
        
        return [
            'most_booked' => Facility::with('category')
                ->whereHas('bookings', function($query) use ($dateRange) {
                    $query->whereBetween('created_at', $dateRange);
                })
                ->withCount(['bookings' => function($query) use ($dateRange) {
                    $query->whereBetween('created_at', $dateRange);
                }])
                ->orderBy('bookings_count', 'desc')
                ->limit(5)
                ->get(),
            
            'by_category' => Facility::join('categories', 'facilities.category_id', '=', 'categories.id')
                ->whereHas('bookings', function($query) use ($dateRange) {
                    $query->whereBetween('created_at', $dateRange);
                })
                ->select('categories.name', DB::raw('COUNT(DISTINCT facilities.id) as count'))
                ->groupBy('categories.name')
                ->get()
        ];
    }

    public function getRecentBookings(int $limit = 5): array
    {
        return Booking::with(['user', 'facility'])
            ->latest()
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getTopFacilities(int $limit = 5): array
    {
        return Facility::with('category')
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    private function getDateRange(string $period): array
    {
        $now = Carbon::now();
        
        return match($period) {
            'week' => [$now->startOfWeek(), $now->endOfWeek()],
            'month' => [$now->startOfMonth(), $now->endOfMonth()],
            'year' => [$now->startOfYear(), $now->endOfYear()],
            default => [$now->startOfMonth(), $now->endOfMonth()]
        };
    }
}
