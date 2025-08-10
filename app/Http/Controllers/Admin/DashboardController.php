<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use App\Models\PlotBooking;
use App\Models\CampingLocation;
use App\Models\User;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct(
        private readonly AnalyticsService $analyticsService
    ) {}

    /**
     * Get main dashboard data
     */
    public function index(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month'); // week, month, year
        
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'overview' => $this->getOverviewStats(),
                    'revenue' => $this->analyticsService->getRevenueStats($period),
                    'bookings' => $this->analyticsService->getBookingStats($period),
                    'locations' => $this->getLocationStats(),
                    'recent_bookings' => $this->getRecentBookings(10),
                    'top_locations' => $this->getTopLocations(4),
                    'payment_verification_needed' => $this->getPaymentVerificationNeeded(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get revenue chart data
     */
    public function revenueChart(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month');
        
        try {
            return response()->json([
                'success' => true,
                'data' => $this->analyticsService->getRevenueChart($period)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get booking chart data
     */
    public function bookingChart(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month');
        
        try {
            return response()->json([
                'success' => true,
                'data' => $this->analyticsService->getBookingChart($period)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get location performance data
     */
    public function locationChart(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month');
        
        try {
            $startDate = match ($period) {
                'week' => Carbon::now()->subWeek(),
                'year' => Carbon::now()->subYear(),
                default => Carbon::now()->subMonth(),
            };

            $locationData = CampingLocation::with(['campingPlots.plotBookings' => function ($query) use ($startDate) {
                $query->where('created_at', '>=', $startDate)
                      ->where('payment_status', 'paid');
            }])->get()->map(function ($location) {
                $totalBookings = $location->campingPlots->sum(function ($plot) {
                    return $plot->plotBookings->count();
                });
                
                $totalRevenue = $location->campingPlots->sum(function ($plot) {
                    return $plot->plotBookings->sum('total_amount');
                });

                return [
                    'name' => $location->name,
                    'bookings' => $totalBookings,
                    'revenue' => $totalRevenue,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $locationData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get overview statistics
     */
    private function getOverviewStats(): array
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        return [
            'total_bookings' => PlotBooking::count(),
            'total_revenue' => PaymentLog::where('status', 'paid')->sum('amount'),
            'total_users' => User::count(),
            'total_locations' => CampingLocation::count(),
            'active_bookings' => PlotBooking::whereIn('status', ['confirmed', 'checked_in'])->count(),
            'bookings_today' => PlotBooking::whereDate('created_at', $today)->count(),
            'revenue_this_month' => PaymentLog::where('status', 'paid')
                ->where('created_at', '>=', $thisMonth)
                ->sum('amount'),
            'revenue_last_month' => PaymentLog::where('status', 'paid')
                ->where('created_at', '>=', $lastMonth)
                ->where('created_at', '<', $thisMonth)
                ->sum('amount'),
            'new_users_this_month' => User::where('created_at', '>=', $thisMonth)->count(),
            'occupancy_rate' => $this->calculateOccupancyRate(),
        ];
    }

    /**
     * Get location statistics
     */
    private function getLocationStats(): array
    {
        return CampingLocation::withCount([
            'campingPlots',
            'campingPlots as total_bookings' => function ($query) {
                $query->join('plot_bookings', 'camping_plots.id', '=', 'plot_bookings.camping_plot_id');
            }
        ])->get()->map(function ($location) {
            return [
                'id' => $location->id,
                'name' => $location->name,
                'total_plots' => $location->camping_plots_count,
                'total_bookings' => $location->total_bookings ?? 0,
                'is_active' => $location->is_active,
            ];
        })->toArray();
    }

    /**
     * Get recent bookings
     */
    private function getRecentBookings(int $limit = 10): array
    {
        return PlotBooking::with(['user', 'campingPlot.location'])
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'booking_code' => $booking->booking_code,
                    'user_name' => $booking->user->name,
                    'location_name' => $booking->campingPlot->location->name,
                    'plot_number' => $booking->campingPlot->plot_number,
                    'total_amount' => $booking->total_amount,
                    'status' => $booking->status,
                    'payment_status' => $booking->payment_status,
                    'created_at' => $booking->created_at->format('Y-m-d H:i:s'),
                ];
            })->toArray();
    }

    /**
     * Get top performing locations
     */
    private function getTopLocations(int $limit = 5): array
    {
        return CampingLocation::withSum(['campingPlots.plotBookings as revenue' => function ($query) {
            $query->where('payment_status', 'paid');
        }], 'total_amount')
        ->withCount(['campingPlots.plotBookings as total_bookings'])
        ->orderByDesc('revenue')
        ->limit($limit)
        ->get()
        ->map(function ($location) {
            return [
                'id' => $location->id,
                'name' => $location->name,
                'total_bookings' => $location->total_bookings ?? 0,
                'revenue' => $location->revenue ?? 0,
            ];
        })->toArray();
    }

    /**
     * Get payments that need verification
     */
    private function getPaymentVerificationNeeded(): array
    {
        return PaymentLog::with(['plotBooking.user', 'plotBooking.campingPlot.location'])
            ->where('status', 'pending_verification')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'booking_code' => $payment->plotBooking->booking_code,
                    'user_name' => $payment->plotBooking->user->name,
                    'amount' => $payment->amount,
                    'payment_method' => $payment->payment_method,
                    'created_at' => $payment->created_at->format('Y-m-d H:i:s'),
                ];
            })->toArray();
    }

    /**
     * Calculate overall occupancy rate
     */
    private function calculateOccupancyRate(): float
    {
        $totalPlots = CampingLocation::withCount('campingPlots')->get()->sum('camping_plots_count');
        
        if ($totalPlots === 0) {
            return 0;
        }

        $occupiedPlots = PlotBooking::whereIn('status', ['confirmed', 'checked_in'])
            ->whereDate('check_in_date', '<=', Carbon::today())
            ->whereDate('check_out_date', '>=', Carbon::today())
            ->count();

        return round(($occupiedPlots / $totalPlots) * 100, 2);
    }
}
