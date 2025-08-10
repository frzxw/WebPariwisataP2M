<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlotBookingResource;
use App\Models\PlotBooking;
use App\Models\PaymentLog;
use App\Services\PlotBookingService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PlotBookingController extends Controller
{
    public function __construct(
        private readonly PlotBookingService $plotBookingService,
        private readonly PaymentService $paymentService
    ) {}

    /**
     * Get all plot bookings for admin management
     */
    public function index(Request $request): JsonResponse
    {
        $bookings = PlotBooking::with(['user', 'campingPlot.location', 'bookingAddons.equipmentRental', 'paymentLogs'])
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->payment_status, function ($query, $status) {
                $query->where('payment_status', $status);
            })
            ->when($request->location_id, function ($query, $locationId) {
                $query->whereHas('campingPlot.location', function ($q) use ($locationId) {
                    $q->where('id', $locationId);
                });
            })
            ->when($request->date_from, function ($query, $date) {
                $query->where('check_in_date', '>=', $date);
            })
            ->when($request->date_to, function ($query, $date) {
                $query->where('check_out_date', '<=', $date);
            })
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('booking_code', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($userQuery) use ($search) {
                          $userQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);

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
     * Get booking details
     */
    public function show(PlotBooking $booking): JsonResponse
    {
        $booking = $this->plotBookingService->getBookingDetails($booking);

        return response()->json([
            'success' => true,
            'data' => new PlotBookingResource($booking)
        ]);
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, PlotBooking $booking): JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,checked_in,checked_out,completed,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $this->plotBookingService->updateBookingStatus($booking, $request->status);

            if ($request->notes) {
                $booking->update(['admin_notes' => $request->notes]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Status booking berhasil diperbarui',
                'data' => new PlotBookingResource($booking->fresh())
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, PlotBooking $booking): JsonResponse
    {
        $request->validate([
            'payment_status' => 'required|string|in:pending,pending_verification,paid,failed,refunded',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $booking->update([
                'payment_status' => $request->payment_status,
                'admin_notes' => $request->notes
            ]);

            // If marking as paid, also confirm the booking
            if ($request->payment_status === 'paid' && $booking->status === 'pending') {
                $booking->update([
                    'status' => 'confirmed',
                    'confirmed_at' => now()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Status pembayaran berhasil diperbarui',
                'data' => new PlotBookingResource($booking->fresh())
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Verify payment proof
     */
    public function verifyPayment(Request $request, PaymentLog $paymentLog): JsonResponse
    {
        $request->validate([
            'approved' => 'required|boolean',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $this->paymentService->verifyPaymentProof(
                $paymentLog, 
                $request->approved, 
                $request->notes
            );

            return response()->json([
                'success' => true,
                'message' => $request->approved ? 'Pembayaran berhasil diverifikasi' : 'Pembayaran ditolak',
                'data' => [
                    'payment_id' => $paymentLog->id,
                    'status' => $paymentLog->fresh()->status,
                    'booking_status' => $paymentLog->plotBooking->fresh()->status,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Cancel booking (admin action)
     */
    public function cancel(Request $request, PlotBooking $booking): JsonResponse
    {
        $request->validate([
            'reason' => 'required|string|max:500',
            'refund_eligible' => 'sometimes|boolean',
        ]);

        try {
            $this->plotBookingService->cancelBooking($booking);
            
            $booking->update([
                'cancellation_reason' => $request->reason,
                'cancelled_by_admin' => true,
            ]);

            // Process refund if eligible and payment was made
            if ($request->refund_eligible && $booking->payment_status === 'paid') {
                $this->paymentService->processRefund($booking, [
                    'refund_reason' => 'Admin cancellation: ' . $request->reason
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dibatalkan',
                'data' => new PlotBookingResource($booking->fresh())
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Get booking statistics for admin
     */
    public function statistics(): JsonResponse
    {
        $stats = $this->plotBookingService->getBookingStatistics();

        // Add more detailed admin statistics
        $detailedStats = [
            'payment_verification_needed' => PaymentLog::where('status', 'pending_verification')->count(),
            'refund_requests' => PaymentLog::where('status', 'pending_refund')->count(),
            'revenue_this_month' => PaymentLog::where('status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
            'bookings_by_status' => PlotBooking::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),
            'average_booking_value' => PlotBooking::where('payment_status', 'paid')->avg('total_amount'),
        ];

        return response()->json([
            'success' => true,
            'data' => array_merge($stats, $detailedStats)
        ]);
    }

    /**
     * Export bookings data
     */
    public function export(Request $request): JsonResponse
    {
        $request->validate([
            'format' => 'required|string|in:csv,excel,pdf',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'status' => 'nullable|string',
        ]);

        // This would typically generate and return a file download
        // For now, we'll return the data that would be exported

        $bookings = PlotBooking::with(['user', 'campingPlot.location', 'bookingAddons.equipmentRental'])
            ->when($request->date_from, function ($query, $date) {
                $query->where('created_at', '>=', $date);
            })
            ->when($request->date_to, function ($query, $date) {
                $query->where('created_at', '<=', $date);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $exportData = $bookings->map(function ($booking) {
            return [
                'booking_code' => $booking->booking_code,
                'user_name' => $booking->user->name,
                'user_email' => $booking->user->email,
                'location' => $booking->campingPlot->location->name,
                'plot' => $booking->campingPlot->plot_number,
                'check_in_date' => $booking->check_in_date,
                'check_out_date' => $booking->check_out_date,
                'guests_count' => $booking->guests_count,
                'total_amount' => $booking->total_amount,
                'payment_status' => $booking->payment_status,
                'status' => $booking->status,
                'created_at' => $booking->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Export data prepared',
            'data' => $exportData,
            'count' => $exportData->count(),
        ]);
    }
}
