<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlotBookingRequest;
use App\Http\Resources\PlotBookingResource;
use App\Models\PlotBooking;
use App\Services\PlotBookingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PlotBookingController extends Controller
{
    public function __construct(
        private readonly PlotBookingService $plotBookingService
    ) {}

    /**
     * Display user's bookings
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $bookings = $this->plotBookingService->getUserBookings(
            $request->user(),
            $request->all()
        );

        return PlotBookingResource::collection($bookings);
    }

    /**
     * Store a new plot booking
     */
    public function store(PlotBookingRequest $request): JsonResponse
    {
        try {
            $booking = $this->plotBookingService->createBooking(
                $request->user(),
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dibuat',
                'data' => new PlotBookingResource($booking)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat booking: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Display the specified booking
     */
    public function show(PlotBooking $plotBooking): PlotBookingResource
    {
        $this->authorize('view', $plotBooking);

        $booking = $this->plotBookingService->getBookingDetails($plotBooking);

        return new PlotBookingResource($booking);
    }

    /**
     * Cancel a booking
     */
    public function cancel(PlotBooking $plotBooking): JsonResponse
    {
        $this->authorize('cancel', $plotBooking);

        try {
            $this->plotBookingService->cancelBooking($plotBooking);

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dibatalkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan booking: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Check plot availability
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'camping_plot_id' => 'required|exists:camping_plots,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $isAvailable = $this->plotBookingService->checkPlotAvailability(
            $request->camping_plot_id,
            $request->check_in_date,
            $request->check_out_date
        );

        return response()->json([
            'success' => true,
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Plot tersedia' : 'Plot tidak tersedia untuk tanggal yang dipilih'
        ]);
    }
}
