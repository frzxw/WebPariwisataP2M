<?php

namespace App\Http\Controllers;

use App\Http\Resources\FacilityResource;
use App\Models\Facility;
use App\Services\SearchService;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function __construct(private SearchService $searchService) {}

    public function index(Request $request)
    {
        $facilities = $this->searchService->searchFacilities($request->all());
        return FacilityResource::collection($facilities);
    }

    public function show(Facility $facility)
    {
        return new FacilityResource(
            $facility->load(['category', 'facilityImages', 'reviews.user'])
        );
    }

    public function checkAvailability(Request $request, Facility $facility)
    {
        $request->validate([
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $bookingService = new \App\Services\BookingService();
        
        try {
            $isAvailable = $bookingService->isAvailable(
                $facility,
                $request->check_in,
                $request->check_out
            );

            return response()->json([
                'success' => true,
                'available' => $isAvailable
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function featured()
    {
        $facilities = Facility::with(['category'])
            ->available()
            ->orderBy('rating', 'desc')
            ->orderBy('total_bookings', 'desc')
            ->limit(6)
            ->get();

        return FacilityResource::collection($facilities);
    }
}
