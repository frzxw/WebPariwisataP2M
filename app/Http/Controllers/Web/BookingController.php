<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingStoreRequest;
use App\Models\CampingLocation;
use App\Models\CampingPlot;
use App\Models\EquipmentRental;
use App\Models\Booking;
use App\Models\BookingAddon;
use App\Models\PaymentLog;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    private $bookingService;

    public function __construct(BookingService $bookingService) 
    {
        $this->bookingService = $bookingService;
        $this->middleware('auth')->only(['store', 'confirmation', 'payment', 'processPayment']);
    }

    /**
     * Store a new booking from web form
     */
    public function store(BookingStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            // Get camping plot and location
            $campingPlot = CampingPlot::with('campingLocation')->findOrFail($request->camping_plot_id);
            $campingLocation = $campingPlot->campingLocation;

            // Calculate total days
            $checkIn = new \DateTime($request->check_in);
            $checkOut = new \DateTime($request->check_out);
            $totalDays = $checkIn->diff($checkOut)->days;

            // Calculate base cost (kavling price × days)
            $baseCost = $campingPlot->price_per_night * $totalDays;

            // Calculate equipment costs
            $equipmentCosts = 0;
            $equipmentData = [];
            
            if ($request->has('equipment_rentals') && is_array($request->equipment_rentals)) {
                foreach ($request->equipment_rentals as $equipmentItem) {
                    if (isset($equipmentItem['id']) && isset($equipmentItem['quantity']) && $equipmentItem['quantity'] > 0) {
                        $equipment = EquipmentRental::findOrFail($equipmentItem['id']);
                        $equipmentCost = $equipment->price_per_day * $equipmentItem['quantity'];
                        $equipmentCosts += $equipmentCost;
                        $equipmentData[] = [
                            'equipment_rental_id' => $equipmentItem['id'],
                            'quantity' => $equipmentItem['quantity'],
                            'price_per_day' => $equipment->price_per_day,
                            'total_price' => $equipmentCost,
                        ];
                    }
                }
            }

            $subtotal = $baseCost + $equipmentCosts;
            $taxAmount = $subtotal * 0.11; // 11% tax
            $totalAmount = $subtotal + $taxAmount;

            // Generate unique booking code
            $bookingCode = 'BK' . date('Ymd') . strtoupper(Str::random(6));

            // Create booking
            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'user_id' => Auth::id(),
                'facility_id' => $campingLocation->id,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'guests' => $request->participants,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'booking_status' => 'pending',
                'special_requests' => $request->special_requests,
            ]);

            // Store additional booking details in JSON for tracking
            $booking->update([
                'payment_proof' => json_encode([
                    'camping_plot_id' => $campingPlot->id,
                    'camping_plot_name' => $campingPlot->name,
                    'camping_location_name' => $campingLocation->name,
                    'contact_name' => $request->name,
                    'contact_email' => $request->email,
                    'contact_phone' => $request->phone,
                    'base_cost' => $baseCost,
                    'equipment_cost' => $equipmentCosts,
                    'total_days' => $totalDays,
                ])
            ]);

            // Add equipment rentals as booking addons
            foreach ($equipmentData as $equipmentItem) {
                BookingAddon::create([
                    'booking_id' => $booking->id,
                    'addon_type' => 'equipment',
                    'addon_id' => $equipmentItem['equipment_rental_id'],
                    'quantity' => $equipmentItem['quantity'],
                    'price_per_unit' => $equipmentItem['price_per_day'],
                    'total_price' => $equipmentItem['total_price'],
                ]);
            }

            // Create initial payment log
            PaymentLog::create([
                'plot_booking_id' => $booking->id,
                'payment_method' => $request->payment_method,
                'amount' => $totalAmount,
                'status' => 'pending',
            ]);

            DB::commit();

            // Redirect to confirmation page
            return redirect()
                ->route('web.booking.confirmation', $booking->booking_code)
                ->with('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran untuk konfirmasi.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->withErrors(['booking' => 'Terjadi kesalahan saat membuat booking: ' . $e->getMessage()]);
        }
    }

    /**
     * Show booking confirmation page
     */
    public function confirmation($bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)
            ->where('user_id', Auth::id())
            ->with(['user', 'facility'])
            ->firstOrFail();

        // Get booking details from JSON
        $bookingDetails = json_decode($booking->payment_proof, true);
        
        // Get equipment rentals
        $equipmentRentals = BookingAddon::where('booking_id', $booking->id)
            ->where('addon_type', 'equipment')
            ->with(['equipment'])
            ->get();

        // Get camping plot info
        $campingPlot = null;
        if (isset($bookingDetails['camping_plot_id'])) {
            $campingPlot = CampingPlot::find($bookingDetails['camping_plot_id']);
        }

        return view('booking.confirmation', compact('booking', 'bookingDetails', 'equipmentRentals', 'campingPlot'));
    }

    /**
     * Show payment page
     */
    public function payment($bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)
            ->where('user_id', Auth::id())
            ->where('payment_status', 'pending')
            ->with(['user', 'facility'])
            ->firstOrFail();

        $paymentLog = PaymentLog::where('plot_booking_id', $booking->id)
            ->latest()
            ->first();

        return view('booking.payment', compact('booking', 'paymentLog'));
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request, $bookingCode)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $booking = Booking::where('booking_code', $bookingCode)
                ->where('user_id', Auth::id())
                ->where('payment_status', 'pending')
                ->firstOrFail();

            // Upload payment proof
            $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

            // Update payment log
            $paymentLog = PaymentLog::where('plot_booking_id', $booking->id)
                ->latest()
                ->first();

            $paymentLog->update([
                'status' => 'pending_verification',
                'proof_of_payment' => $paymentProofPath,
                'processed_at' => now(),
            ]);

            // Update booking status
            $booking->update([
                'payment_status' => 'pending',
                'booking_status' => 'pending',
            ]);

            DB::commit();

            return redirect()
                ->route('web.transaction')
                ->with('success', 'Bukti pembayaran berhasil diunggah. Pesanan Anda sedang diverifikasi.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withErrors(['payment' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()]);
        }
    }

    /**
     * Check availability via AJAX
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:camping_locations,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guest_count' => 'required|integer|min:1',
        ]);

        try {
            $facility = CampingLocation::findOrFail($request->facility_id);
            
            // Check if facility can accommodate guest count
            if ($request->guest_count > $facility->max_capacity) {
                return response()->json([
                    'available' => false,
                    'message' => "Kapasitas maksimal untuk lokasi ini adalah {$facility->max_capacity} orang."
                ]);
            }

            // Check for conflicting bookings
            $conflictingBookings = Booking::where('facility_id', $request->facility_id)
                ->where('payment_status', '!=', 'cancelled')
                ->where(function ($query) use ($request) {
                    $query->whereBetween('check_in_date', [$request->check_in, $request->check_out])
                        ->orWhereBetween('check_out_date', [$request->check_in, $request->check_out])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('check_in_date', '<=', $request->check_in)
                                ->where('check_out_date', '>=', $request->check_out);
                        });
                })
                ->exists();

            if ($conflictingBookings) {
                return response()->json([
                    'available' => false,
                    'message' => 'Lokasi tidak tersedia pada tanggal yang dipilih.'
                ]);
            }

            // Calculate pricing
            $checkIn = new \DateTime($request->check_in);
            $checkOut = new \DateTime($request->check_out);
            $days = $checkIn->diff($checkOut)->days;
            
            $basePrice = $facility->price_per_day * $days;
            $totalPrice = $basePrice;

            return response()->json([
                'available' => true,
                'message' => 'Lokasi tersedia!',
                'pricing' => [
                    'days' => $days,
                    'price_per_day' => $facility->price_per_day,
                    'base_price' => $basePrice,
                    'total_price' => $totalPrice,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'available' => false,
                'message' => 'Terjadi kesalahan saat mengecek ketersediaan.'
            ], 500);
        }
    }

    /**
     * Get equipment rental details
     */
    public function getEquipmentDetails(Request $request)
    {
        $equipmentIds = $request->input('equipment_ids', []);
        
        if (empty($equipmentIds)) {
            return response()->json(['equipment' => []]);
        }

        $equipment = EquipmentRental::whereIn('id', $equipmentIds)
            ->where('is_available', true)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price_per_day' => $item->price_per_day,
                    'stock' => $item->stock,
                    'image' => $item->image_url,
                ];
            });

        return response()->json(['equipment' => $equipment]);
    }
}
