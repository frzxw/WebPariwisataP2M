<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampingLocationResource;
use App\Http\Resources\PlotBookingResource;
use App\Models\CampingLocation;
use App\Models\PlotBooking;
use App\Models\EquipmentRental;
use App\Services\PlotBookingService;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CampingLocationController extends Controller
{
    public function __construct(
        private readonly PlotBookingService $plotBookingService,
        private readonly AnalyticsService $analyticsService
    ) {}

    /**
     * Get all camping locations for admin
     */
    public function index(Request $request): JsonResponse
    {
        $locations = CampingLocation::withCount(['campingPlots', 'plotBookings'])
            ->with(['campingPlots' => function ($query) {
                $query->selectRaw('camping_location_id, COUNT(*) as total_plots, 
                                   SUM(CASE WHEN is_available = true THEN 1 ELSE 0 END) as available_plots,
                                   MIN(price_per_night) as min_price,
                                   MAX(price_per_night) as max_price')
                      ->groupBy('camping_location_id');
            }])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                $query->where('is_active', $status === 'active');
            })
            ->orderBy('name')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => CampingLocationResource::collection($locations),
            'meta' => [
                'total' => $locations->total(),
                'per_page' => $locations->perPage(),
                'current_page' => $locations->currentPage(),
                'last_page' => $locations->lastPage(),
            ]
        ]);
    }

    /**
     * Get camping location statistics
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_locations' => CampingLocation::count(),
            'active_locations' => CampingLocation::where('is_active', true)->count(),
            'total_plots' => CampingLocation::withSum('campingPlots', 'id')->sum('camping_plots_sum_id'),
            'occupied_plots_today' => PlotBooking::whereDate('check_in_date', '<=', now())
                ->whereDate('check_out_date', '>=', now())
                ->where('status', '!=', 'cancelled')
                ->count(),
            'revenue_this_month' => PlotBooking::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Create new camping location
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'featured_image' => 'nullable|url',
            'facilities' => 'nullable|array',
        ]);

        $location = CampingLocation::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Lokasi camping berhasil dibuat',
            'data' => new CampingLocationResource($location)
        ], 201);
    }

    /**
     * Get specific camping location with detailed info
     */
    public function show(CampingLocation $location): JsonResponse
    {
        $location->load(['campingPlots.plotBookings' => function ($query) {
            $query->where('status', '!=', 'cancelled')
                  ->whereBetween('check_in_date', [now()->subMonth(), now()->addMonth()]);
        }]);

        return response()->json([
            'success' => true,
            'data' => new CampingLocationResource($location)
        ]);
    }

    /**
     * Update camping location
     */
    public function update(Request $request, CampingLocation $location): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'location' => 'sometimes|string|max:255',
            'address' => 'sometimes|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'featured_image' => 'nullable|url',
            'facilities' => 'nullable|array',
            'is_active' => 'sometimes|boolean',
        ]);

        $location->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Lokasi camping berhasil diperbarui',
            'data' => new CampingLocationResource($location)
        ]);
    }

    /**
     * Delete camping location
     */
    public function destroy(CampingLocation $location): JsonResponse
    {
        // Check if location has active bookings
        $activeBookings = $location->plotBookings()
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->count();

        if ($activeBookings > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus lokasi yang memiliki booking aktif'
            ], 422);
        }

        $location->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lokasi camping berhasil dihapus'
        ]);
    }

    /**
     * Get bookings for a specific location
     */
    public function bookings(Request $request, CampingLocation $location): JsonResponse
    {
        $bookings = $location->plotBookings()
            ->with(['user', 'campingPlot', 'bookingAddons.equipmentRental'])
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->payment_status, function ($query, $status) {
                $query->where('payment_status', $status);
            })
            ->when($request->date_from, function ($query, $date) {
                $query->where('check_in_date', '>=', $date);
            })
            ->when($request->date_to, function ($query, $date) {
                $query->where('check_out_date', '<=', $date);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => PlotBookingResource::collection($bookings),
            'meta' => [
                'total' => $bookings->total(),
                'per_page' => $bookings->perPage(),
                'current_page' => $bookings->currentPage(),
                'last_page' => $bookings->lastPage(),
            ]
        ]);
    }

    /**
     * Get location analytics
     */
    public function analytics(CampingLocation $location): JsonResponse
    {
        $analytics = $this->analyticsService->getLocationAnalytics($location->id);

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }
}
