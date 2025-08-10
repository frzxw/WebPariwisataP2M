<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id || $user->isAdmin();
    }

    public function cancel(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id && $booking->canBeCancelled();
    }

    public function pay(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id && $booking->payment_status === 'pending';
    }

    public function uploadProof(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id && 
               in_array($booking->payment_status, ['pending']) &&
               in_array($booking->payment_method, ['transfer']);
    }

    public function update(User $user, Booking $booking): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->isAdmin();
    }
}
