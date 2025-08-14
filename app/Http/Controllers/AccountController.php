<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\PlotBookingResource;
use App\Models\PlotBooking;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }

    /**
     * Get user profile for web view
     */
    public function index()
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('web.login');
        }

        // Get user's booking statistics 
        $totalBookings = $user->bookings()->count();
        $totalSpent = $user->bookings()->where('payment_status', 'paid')->sum('total_amount');
        
        // Get recent bookings with facility relationships
        $recentBookings = $user->bookings()
            ->with(['facility', 'bookingAddons.equipmentRental'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('account.index', compact('user', 'totalBookings', 'totalSpent', 'recentBookings'));
    }

    /**
     * Get user profile information for API
     */
    public function profile(): JsonResponse
    {
        $user = Auth::user();
        
        // Get user's booking statistics
        $bookingStats = [
            'total_bookings' => $user->plotBookings()->count(),
            'completed_bookings' => $user->plotBookings()->where('status', 'completed')->count(),
            'pending_bookings' => $user->plotBookings()->whereIn('status', ['pending', 'confirmed'])->count(),
            'cancelled_bookings' => $user->plotBookings()->where('status', 'cancelled')->count(),
            'total_spent' => $user->plotBookings()
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
        ];

        // Get recent bookings
        $recentBookings = $user->plotBookings()
            ->with(['campingPlot.location', 'bookingAddons.equipmentRental'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? null,
                    'address' => $user->address ?? null,
                    'profile_picture' => $user->profile_picture ?? null,
                    'email_verified_at' => $user->email_verified_at,
                    'created_at' => $user->created_at,
                    'member_since' => $user->created_at->format('F Y'),
                ],
                'statistics' => $bookingStats,
                'recent_bookings' => PlotBookingResource::collection($recentBookings),
            ]
        ]);
    }

    public function update(UserRequest $request)
    {
        try {
            $user = $this->userService->updateUser(auth()->user(), $request->validated());
            
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Get user's booking history for API
     */
    public function bookingHistory(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        $bookings = $user->plotBookings()
            ->with(['campingPlot.location', 'bookingAddons.equipmentRental'])
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->payment_status, function ($query, $status) {
                $query->where('payment_status', $status);
            })
            ->when($request->from_date, function ($query, $date) {
                $query->where('check_in_date', '>=', $date);
            })
            ->when($request->to_date, function ($query, $date) {
                $query->where('check_out_date', '<=', $date);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

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
                    'member_since' => $user->created_at->format('F Y'),
                ],
                'statistics' => $bookingStats,
                'recent_bookings' => PlotBookingResource::collection($recentBookings),
            ]
        ]);
    }

    public function update(UserRequest $request)
    {
        try {
            $user = $this->userService->updateUser(auth()->user(), $request->validated());
            
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $user = auth()->user();
            $userData = [];

            if ($request->hasFile('profile_picture')) {
                $fileUploadService = new \App\Services\FileUploadService();
                $result = $fileUploadService->uploadImage($request->file('profile_picture'), 'user');
                $userData['image'] = $result['path'];
            }

            $user->update($userData);

            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully',
                'image_url' => $user->image_url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
