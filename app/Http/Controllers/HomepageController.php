<?php

namespace App\Http\Controllers;

use App\Models\CampingLocation;
use App\Models\PlotBooking;
use App\Models\EquipmentRental;
use App\Models\Review;
use App\Http\Resources\CampingLocationResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HomepageController extends Controller
{
    /**
     * Get homepage data including featured locations and statistics
     */
    public function index(): JsonResponse
    {
        // Get featured camping locations (active ones with high ratings)
        $featuredLocations = CampingLocation::where('is_active', true)
            ->orderBy('rating', 'desc')
            ->limit(4)
            ->get();

        // Get recent reviews (with fallback for empty review model)
        $recentReviews = collect(); // Empty collection for now
        if (class_exists('\App\Models\Review')) {
            $recentReviews = Review::with(['user', 'plotBooking.campingPlot.location'])
                ->where('is_approved', true)
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();
        }

        // Get some statistics for homepage
        $statistics = [
            'total_locations' => CampingLocation::where('is_active', true)->count(),
            'total_plots' => CampingLocation::where('is_active', true)
                ->withCount('campingPlots')
                ->get()
                ->sum('camping_plots_count'),
            'happy_customers' => PlotBooking::where('status', 'completed')->distinct('user_id')->count(),
            'total_bookings' => PlotBooking::whereNotIn('status', ['cancelled'])->count(),
        ];

        // Get popular equipment
        $popularEquipment = EquipmentRental::withCount('bookingAddons')
            ->where('is_available', true)
            ->orderBy('booking_addons_count', 'desc')
            ->limit(4)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'featured_locations' => CampingLocationResource::collection($featuredLocations),
                'statistics' => $statistics,
                'recent_reviews' => $recentReviews->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'user_name' => $review->user->name,
                        'location_name' => $review->plotBooking->campingPlot->location->name,
                        'created_at' => $review->created_at->format('d M Y'),
                    ];
                }),
                'popular_equipment' => $popularEquipment->map(function ($equipment) {
                    return [
                        'id' => $equipment->id,
                        'name' => $equipment->name,
                        'category' => $equipment->category,
                        'price_per_day' => $equipment->price_per_day,
                        'formatted_price' => 'Rp ' . number_format($equipment->price_per_day, 0, ',', '.'),
                        'rental_count' => $equipment->booking_addons_count,
                        'image_url' => $equipment->image_url,
                    ];
                }),
                'hero_content' => [
                    'title' => 'Nyampay Camping Ground',
                    'subtitle' => 'Experience the best camping adventure in beautiful natural settings',
                    'description' => 'Discover amazing camping locations with modern facilities and breathtaking views',
                    'quote' => 'Adventure awaits in every corner of nature',
                    'cta_text' => 'Book Your Adventure',
                    'cta_url' => '/booking',
                ],
            ]
        ]);
    }

    /**
     * Get location carousels data for homepage
     */
    public function getLocationCarousels(): JsonResponse
    {
        $locations = CampingLocation::where('is_active', true)
            ->with(['campingPlots' => function ($query) {
                $query->where('is_available', true)
                      ->selectRaw('camping_location_id, MIN(price_per_night) as min_price, MAX(price_per_night) as max_price')
                      ->groupBy('camping_location_id');
            }])
            ->get();

        $carouselData = $locations->map(function ($location) {
            return [
                'id' => $location->id,
                'name' => $location->name,
                'description' => $location->description,
                'images' => [
                    'https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-4.0.3&auto=format&fit=crop&w=869&q=80',
                    'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?ixlib=rb-4.0.3&auto=format&fit=crop&w=870&q=80',
                    'https://images.unsplash.com/photo-1533873984035-25970ab07461?ixlib=rb-4.0.3&auto=format&fit=crop&w=869&q=80',
                ],
                'location' => $location->location,
                'min_price' => $location->campingPlots->min('min_price') ?? 0,
                'max_price' => $location->campingPlots->max('max_price') ?? 0,
                'rating' => $location->rating,
                'total_reviews' => $location->total_reviews,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $carouselData
        ]);
    }

        // Get active categories
        $categories = Category::active()
            ->withCount('facilities')
            ->orderBy('name')
            ->get();

        // Get testimonials/reviews
        $testimonials = \App\Models\Review::with(['user', 'facility'])
            ->approved()
            ->orderBy('rating', 'desc')
            ->limit(6)
            ->get();

        return view('homepage', compact('featuredFacilities', 'categories', 'testimonials'));
    }

    public function about()
    {
        return view('about');
    }
}
