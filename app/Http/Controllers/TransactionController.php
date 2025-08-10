<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function show(Request $request)
    {
        // Get booking by ID or latest booking for user
        $bookingId = $request->get('booking_id');
        
        if ($bookingId) {
            $booking = Booking::with(['user', 'facility', 'addons', 'paymentLogs'])
                ->findOrFail($bookingId);
        } else {
            // Get latest booking from session or user
            $booking = null;
            if (auth()->check()) {
                $booking = auth()->user()->bookings()
                    ->with(['facility', 'addons', 'paymentLogs'])
                    ->latest()
                    ->first();
            }
        }

        return view('transaction', compact('booking'));
    }

    public function userTransactions(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $bookings = auth()->user()->bookings()
            ->with(['facility'])
            ->when($request->status, function ($query, $status) {
                $query->where('payment_status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('account.transactions', compact('bookings'));
    }

    public function details(Booking $booking)
    {
        $this->authorize('view', $booking);
        
        return response()->json([
            'success' => true,
            'data' => new BookingResource($booking->load(['facility', 'addons', 'paymentLogs']))
        ]);
    }
}
