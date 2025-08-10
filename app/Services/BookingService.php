<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function createBooking(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $facility = Facility::findOrFail($data['facility_id']);
            
            // Check availability
            if (!$this->isAvailable($facility, $data['check_in'], $data['check_out'])) {
                throw new \Exception('Facility is not available for selected dates');
            }

            // Create booking
            $booking = Booking::create([
                'user_id' => $data['user_id'],
                'facility_id' => $data['facility_id'],
                'check_in' => Carbon::parse($data['check_in']),
                'check_out' => Carbon::parse($data['check_out']),
                'guests' => $data['guests'],
                'payment_method' => $data['payment_method'],
                'special_requests' => $data['special_requests'] ?? null,
            ]);

            // Add addons if provided
            if (!empty($data['addons'])) {
                $this->attachAddons($booking, $data['addons']);
            }

            // Calculate totals
            $booking->calculateTotal();

            // Update facility booking count
            $facility->incrementBookingCount();

            return $booking;
        });
    }

    public function isAvailable(Facility $facility, string $checkIn, string $checkOut): bool
    {
        $checkIn = Carbon::parse($checkIn);
        $checkOut = Carbon::parse($checkOut);

        $conflictingBookings = Booking::where('facility_id', $facility->id)
            ->whereIn('booking_status', ['confirmed', 'checked_in'])
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<=', $checkIn)
                          ->where('check_out', '>=', $checkOut);
                    });
            })
            ->exists();

        return !$conflictingBookings;
    }

    public function cancelBooking(Booking $booking, string $reason): Booking
    {
        if (!$booking->canBeCancelled()) {
            throw new \Exception('This booking cannot be cancelled');
        }

        $booking->update([
            'booking_status' => 'cancelled',
            'payment_status' => 'cancelled',
            'cancellation_reason' => $reason,
            'cancelled_at' => now(),
        ]);

        return $booking;
    }

    private function attachAddons(Booking $booking, array $addons): void
    {
        foreach ($addons as $addonData) {
            $addon = \App\Models\Addon::findOrFail($addonData['id']);
            $quantity = $addonData['quantity'];
            $totalPrice = $addon->price * $quantity;

            $booking->addons()->attach($addon->id, [
                'quantity' => $quantity,
                'unit_price' => $addon->price,
                'total_price' => $totalPrice,
            ]);
        }
    }
}
