<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\PlotBooking;
use App\Models\CampingLocation;
use App\Models\EquipmentRental;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        // Remove auth middleware from constructor since we handle it per method
    }

    public function login()
    {
        return view('admin.admin_login');
    }

    public function dashboard()
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        // Get statistics
        $totalBookings = PlotBooking::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalRevenue = PaymentLog::where('status', 'paid')->sum('amount');
        
        // Get recent bookings with user and plot information
        $recentBookings = PlotBooking::with(['user', 'campingPlot'])
            ->latest()
            ->limit(10)
            ->get();

        // Get monthly revenue data for chart
        $monthlyRevenue = PaymentLog::select(
                DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                DB::raw('SUM(amount) as revenue')
            )
            ->where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'totalBookings',
            'totalUsers', 
            'totalRevenue',
            'recentBookings',
            'monthlyRevenue'
        ));
    }

    public function transactions(Request $request)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $query = PlotBooking::with(['user', 'paymentLogs', 'campingPlot']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('booking_code', 'like', "%{$search}%")
                ->orWhereHas('campingPlot', function($plotQuery) use ($search) {
                    $plotQuery->where('plot_number', 'like', "%{$search}%");
                });
            });
        }

        // Date range filter
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10);
        
        // Calculate totals
        $totalBookings = PlotBooking::count();
        $totalRevenue = PaymentLog::where('status', 'paid')->sum('amount');

        return view('admin.transactions.index', compact(
            'bookings',
            'totalBookings',
            'totalRevenue'
        ));
    }

    public function users(Request $request)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $query = User::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->has('role') && !empty($request->role)) {
            $query->where('role', $request->role);
        }

        // Status filter
        if ($request->has('is_active') && $request->is_active !== '') {
            $query->where('is_active', $request->is_active);
        }

        $users = $query->latest()->paginate(10);
        
        // Calculate totals
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'activeUsers'
        ));
    }

    public function items(Request $request)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $query = EquipmentRental::with(['category']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Category filter
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        // Status filter
        if ($request->has('is_available') && $request->is_available !== '') {
            $query->where('is_available', $request->is_available);
        }

        $items = $query->latest()->paginate(10);
        
        // Get categories for filter dropdown
        $categories = \App\Models\Category::all();
        
        // Calculate totals
        $totalItems = EquipmentRental::count();
        $availableItems = EquipmentRental::where('is_available', true)->count();

        return view('admin.items.index', compact(
            'items',
            'categories',
            'totalItems',
            'availableItems'
        ));
    }

    public function updateBookingStatus(Request $request, $bookingId)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $booking = PlotBooking::findOrFail($bookingId);
        $booking->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status booking berhasil diupdate'
        ]);
    }

    public function toggleUserStatus($userId)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $user = User::findOrFail($userId);
        $user->update(['is_active' => !$user->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status user berhasil diupdate',
            'is_active' => $user->is_active
        ]);
    }
}
