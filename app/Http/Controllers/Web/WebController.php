<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CampingLocation;
use App\Models\Facility;
use App\Models\EquipmentRental;
use App\Models\Booking;
use App\Models\Review;
use App\Services\CampingLocationService;
use App\Services\EquipmentRentalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebController extends Controller
{
    private $campingLocationService;
    private $equipmentRentalService;

    public function __construct(
        CampingLocationService $campingLocationService,
        EquipmentRentalService $equipmentRentalService
    ) {
        $this->campingLocationService = $campingLocationService;
        $this->equipmentRentalService = $equipmentRentalService;
    }

    /**
     * Homepage with dynamic data
     */
    public function homepage()
    {
        $featuredLocations = CampingLocation::where('is_active', true)
            ->take(6)
            ->get();

        $reviews = Review::with('user')
            ->where('rating', '>=', 4)
            ->latest()
            ->take(6)
            ->get();

        $totalBookings = Booking::count();
        $totalCustomers = \App\Models\User::where('role', 'customer')->count();

        return view('homepage', compact(
            'featuredLocations',
            'reviews',
            'totalBookings',
            'totalCustomers'
        ));
    }

    /**
     * About page
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Booking page with dynamic data
     */
    public function booking(Request $request)
    {
        // Get available camping locations with their plots
        $campingLocations = CampingLocation::with(['campingPlots'])
            ->where('is_active', true)
            ->get();

        // Debug the data structure
        \Log::info('Camping locations count: ' . $campingLocations->count());
        \Log::info('Camping locations structure: ' . json_encode($campingLocations->toArray()));
        $first = $campingLocations->first();
        \Log::info('First location class: ' . get_class($first));
        if(is_object($first) && method_exists($first, 'toArray')) {
            \Log::info('First location data: ' . json_encode($first->toArray()));
        }

        // Get equipment rentals grouped by category
        $equipmentRentals = EquipmentRental::where('is_available', true)
            ->get()
            ->groupBy('category');

        // Get unique categories for equipment
        $categories = EquipmentRental::where('is_available', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        // Get selected location if specified
        $selectedLocation = null;
        if ($request->has('location_id')) {
            $selectedLocation = CampingLocation::with(['campingPlots'])
                ->find($request->location_id);
        }

        return view('booking', compact(
            'campingLocations',
            'equipmentRentals',
            'categories',
            'selectedLocation'
        ));
    }

    /**
     * Transaction history page
     */
    public function transaction()
    {
        if (!Auth::check()) {
            return redirect()->route('web.login')
                ->with('message', 'Silakan login terlebih dahulu untuk melihat transaksi.');
        }
        
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['facility', 'addons.equipment', 'paymentLogs'])
            ->latest()
            ->paginate(10);

        return view('transaction', compact('bookings'));
    }

    /**
     * Account page
     */
    public function account()
    {
        if (!Auth::check()) {
            return redirect()->route('web.login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Auth::user();
        $recentBookings = Booking::where('user_id', Auth::id())
            ->with(['facility', 'addons.equipment'])
            ->latest()
            ->take(5)
            ->get();

        $totalBookings = Booking::where('user_id', Auth::id())->count();
        $totalSpent = Booking::where('user_id', Auth::id())
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        return view('account.index', compact('user', 'recentBookings', 'totalBookings', 'totalSpent'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('web.login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update basic info
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Update password if provided
        if ($request->filled('current_password') || $request->filled('password')) {
            if (!$request->filled('current_password')) {
                return back()->withErrors(['current_password' => 'Password saat ini harus diisi']);
            }

            if (!\Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak benar']);
            }

            if (!$request->filled('password')) {
                return back()->withErrors(['password' => 'Password baru harus diisi']);
            }

            $user->password = \Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
