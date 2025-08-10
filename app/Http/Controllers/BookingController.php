<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()
            ->with(['facility', 'addons'])
            ->when($request->status, function ($query, $status) {
                $query->where('payment_status', $status);
            })
            ->latest()
            ->paginate(10);

        return BookingResource::collection($bookings);
    }

    public function store(BookingRequest $request)
    {
        try {
            $bookingData = array_merge($request->validated(), [
                'user_id' => $request->user()->id
            ]);
            
            $booking = $this->bookingService->createBooking($bookingData);
            
            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully',
                'data' => new BookingResource($booking->load(['facility', 'addons']))
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return new BookingResource($booking->load(['facility', 'addons', 'paymentLogs']));
    }

    public function cancel(Request $request, Booking $booking)
    {
        $this->authorize('cancel', $booking);
        
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        try {
            $booking = $this->bookingService->cancelBooking($booking, $request->reason);
            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully',
                'data' => new BookingResource($booking)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
