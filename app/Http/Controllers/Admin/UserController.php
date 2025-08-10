<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\PlotBooking;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * Get all users for admin management
     */
    public function index(Request $request): JsonResponse
    {
        $users = User::with(['plotBookings' => function ($query) {
                $query->latest()->limit(5);
            }])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->when($request->is_active !== null, function ($query) use ($request) {
                $query->where('is_active', $request->boolean('is_active'));
            })
            ->when($request->email_verified !== null, function ($query) use ($request) {
                if ($request->boolean('email_verified')) {
                    $query->whereNotNull('email_verified_at');
                } else {
                    $query->whereNull('email_verified_at');
                }
            })
            ->orderBy($request->sort_by ?? 'created_at', $request->sort_order ?? 'desc')
            ->paginate($request->per_page ?? 20);

        return response()->json([
            'success' => true,
            'data' => UserResource::collection($users),
            'meta' => [
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
            ]
        ]);
    }

    /**
     * Get user details with booking history
     */
    public function show(User $user): JsonResponse
    {
        $user->load([
            'plotBookings.campingPlot.location',
            'plotBookings.bookingAddons.equipmentRental',
            'plotBookings.paymentLogs'
        ]);

        // Calculate user statistics
        $userStats = [
            'total_bookings' => $user->plotBookings->count(),
            'completed_bookings' => $user->plotBookings->where('status', 'completed')->count(),
            'cancelled_bookings' => $user->plotBookings->where('status', 'cancelled')->count(),
            'total_spent' => $user->plotBookings->where('payment_status', 'paid')->sum('total_amount'),
            'last_booking_date' => $user->plotBookings->max('created_at'),
            'favorite_locations' => $user->plotBookings
                ->groupBy('campingPlot.location.name')
                ->map->count()
                ->sortDesc()
                ->take(3)
                ->keys()
                ->values(),
        ];

        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
            'statistics' => $userStats
        ]);
    }

    /**
     * Create new user (admin action)
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'sometimes|string|in:admin,user',
            'is_active' => 'sometimes|boolean',
            'email_verified_at' => 'sometimes|boolean',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'user',
                'is_active' => $request->is_active ?? true,
                'email_verified_at' => $request->email_verified_at ? now() : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dibuat',
                'data' => new UserResource($user)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat user: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update user information
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'sometimes|string|max:20|unique:users,phone,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|string|in:admin,user',
            'is_active' => 'sometimes|boolean',
            'email_verified_at' => 'sometimes|boolean',
        ]);

        try {
            $updateData = $request->only(['name', 'email', 'phone', 'role', 'is_active']);

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            if ($request->has('email_verified_at')) {
                $updateData['email_verified_at'] = $request->email_verified_at ? now() : null;
            }

            $user->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui',
                'data' => new UserResource($user->fresh())
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui user: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user): JsonResponse
    {
        try {
            $user->update(['is_active' => !$user->is_active]);

            $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

            return response()->json([
                'success' => true,
                'message' => "User berhasil {$status}",
                'data' => new UserResource($user)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status user: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Delete user (soft delete)
     */
    public function destroy(User $user): JsonResponse
    {
        // Check if user has active bookings
        $activeBookings = $user->plotBookings()
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->count();

        if ($activeBookings > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus user yang memiliki booking aktif'
            ], 422);
        }

        try {
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus user: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Get user statistics for admin dashboard
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'users_with_bookings' => User::has('plotBookings')->count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
