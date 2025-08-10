<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $bookings = Booking::with(['user', 'facility'])
            ->when($request->search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('payment_status', $status);
            })
            ->when($request->date_range, function ($query, $dateRange) {
                [$start, $end] = explode(' to ', $dateRange);
                $query->whereBetween('created_at', [$start, $end]);
            })
            ->latest()
            ->paginate(10);

        return BookingResource::collection($bookings);
    }

    public function store(BookingRequest $request)
    {
        try {
            $booking = $this->bookingService->createBooking($request->validated());
            
            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully',
                'data' => new BookingResource($booking->load(['user', 'facility']))
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show(Booking $booking)
    {
        return new BookingResource($booking->load(['user', 'facility', 'addons']));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:confirmed,checked_in,checked_out,cancelled'
        ]);

        try {
            $booking->update(['booking_status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Booking status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function updatePaymentStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled,refunded'
        ]);

        try {
            $booking->update(['payment_status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Payment status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
