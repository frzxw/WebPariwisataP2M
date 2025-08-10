<?php

namespace App\Services;

use App\Models\User;
use App\Models\PlotBooking;
use App\Models\CampingPlot;
use App\Models\EquipmentRental;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlotBookingService
{
    public function __construct(
        private readonly NotificationService $notificationService,
        private readonly PaymentService $paymentService
    ) {}

    /**
     * Get user's bookings with filtering and pagination
     */
    public function getUserBookings(User $user, array $filters = []): LengthAwarePaginator
    {
        return $user->plotBookings()
            ->with(['campingPlot.location', 'bookingAddons.equipmentRental'])
            ->when(isset($filters['status']), function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })
            ->when(isset($filters['from_date']), function ($query) use ($filters) {
                $query->where('check_in_date', '>=', $filters['from_date']);
            })
            ->when(isset($filters['to_date']), function ($query) use ($filters) {
                $query->where('check_out_date', '<=', $filters['to_date']);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Create a new plot booking
     */
    public function createBooking(User $user, array $data): PlotBooking
    {
        return DB::transaction(function () use ($user, $data) {
            // Validate plot availability
            if (!$this->checkPlotAvailability($data['camping_plot_id'], $data['check_in_date'], $data['check_out_date'])) {
                throw new \Exception('Plot tidak tersedia untuk tanggal yang dipilih');
            }

            $plot = CampingPlot::findOrFail($data['camping_plot_id']);
            
            // Validate guest capacity
            if ($data['guests_count'] > $plot->max_capacity) {
                throw new \Exception("Plot hanya dapat menampung maksimal {$plot->max_capacity} tamu");
            }

            // Calculate duration and pricing
            $checkIn = Carbon::parse($data['check_in_date']);
            $checkOut = Carbon::parse($data['check_out_date']);
            $nights = $checkIn->diffInDays($checkOut);
            
            if ($nights < 1) {
                throw new \Exception('Minimal booking adalah 1 malam');
            }

            $plotPrice = $plot->price_per_night * $nights;
            $addonsTotal = 0;

            // Create the booking
            $booking = PlotBooking::create([
                'user_id' => $user->id,
                'camping_plot_id' => $plot->id,
                'check_in_date' => $data['check_in_date'],
                'check_out_date' => $data['check_out_date'],
                'check_in_name' => $data['check_in_name'],
                'check_out_name' => $data['check_out_name'],
                'guests_count' => $data['guests_count'],
                'plot_price' => $plotPrice,
                'addons_total' => 0, // Will be calculated below
                'total_amount' => $plotPrice, // Will be updated below
                'special_requests' => $data['special_requests'] ?? null,
            ]);

            // Add equipment rentals if provided
            if (!empty($data['equipment_rentals'])) {
                $addonsTotal = $this->addEquipmentRentals($booking, $data['equipment_rentals'], $nights);
                
                $booking->update([
                    'addons_total' => $addonsTotal,
                    'total_amount' => $plotPrice + $addonsTotal,
                ]);
            }

            // Send confirmation notification
            $this->notificationService->sendBookingConfirmation($booking);

            return $booking->fresh(['campingPlot.location', 'bookingAddons.equipmentRental']);
        });
    }

    /**
     * Add equipment rentals to booking
     */
    private function addEquipmentRentals(PlotBooking $booking, array $equipmentRentals, int $nights): float
    {
        $total = 0;

        foreach ($equipmentRentals as $rental) {
            $equipment = EquipmentRental::findOrFail($rental['equipment_id']);
            
            // Check stock availability
            if (!$equipment->isInStock($rental['quantity'])) {
                throw new \Exception("Equipment '{$equipment->name}' tidak tersedia dalam jumlah yang diminta");
            }

            $pricePerDay = $equipment->price_per_day;
            $totalPrice = $rental['quantity'] * $pricePerDay * $nights;

            $booking->bookingAddons()->create([
                'equipment_rental_id' => $equipment->id,
                'quantity' => $rental['quantity'],
                'price_per_day' => $pricePerDay,
                'days' => $nights,
                'total_price' => $totalPrice,
            ]);

            $total += $totalPrice;
        }

        return $total;
    }

    /**
     * Get booking details with related data
     */
    public function getBookingDetails(PlotBooking $booking): PlotBooking
    {
        return $booking->load([
            'user',
            'campingPlot.location',
            'bookingAddons.equipmentRental',
            'paymentLogs' => function ($query) {
                $query->latest();
            },
            'reviews'
        ]);
    }

    /**
     * Cancel a booking
     */
    public function cancelBooking(PlotBooking $booking): void
    {
        if (!$booking->canBeCancelled()) {
            throw new \Exception('Booking tidak dapat dibatalkan');
        }

        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            // Process refund if payment was made
            if ($booking->payment_status === 'paid') {
                $this->paymentService->processRefund($booking);
            }

            // Send cancellation notification
            $this->notificationService->sendBookingCancellation($booking);
        });
    }

    /**
     * Check if a plot is available for given dates
     */
    public function checkPlotAvailability(int $plotId, string $checkInDate, string $checkOutDate): bool
    {
        $plot = CampingPlot::find($plotId);
        
        if (!$plot || !$plot->is_available) {
            return false;
        }

        return $plot->isAvailableForDates($checkInDate, $checkOutDate);
    }

    /**
     * Update booking status
     */
    public function updateBookingStatus(PlotBooking $booking, string $status): void
    {
        $validStatuses = ['pending', 'confirmed', 'checked_in', 'checked_out', 'completed', 'cancelled'];
        
        if (!in_array($status, $validStatuses)) {
            throw new \Exception('Status booking tidak valid');
        }

        $booking->update(['status' => $status]);

        // Handle status-specific actions
        match ($status) {
            'confirmed' => $booking->update(['confirmed_at' => now()]),
            'cancelled' => $booking->update(['cancelled_at' => now()]),
            'completed' => $this->notificationService->sendReviewRequest($booking),
            default => null
        };
    }

    /**
     * Get booking statistics for dashboard
     */
    public function getBookingStatistics(): array
    {
        $today = now()->toDateString();
        $thisMonth = now()->format('Y-m');

        return [
            'total_bookings' => PlotBooking::count(),
            'active_bookings' => PlotBooking::whereNotIn('status', ['cancelled', 'completed'])->count(),
            'todays_checkins' => PlotBooking::where('check_in_date', $today)->count(),
            'todays_checkouts' => PlotBooking::where('check_out_date', $today)->count(),
            'monthly_revenue' => PlotBooking::where('created_at', 'like', "$thisMonth%")
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
        ];
    }
}
