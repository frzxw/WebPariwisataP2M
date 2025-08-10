<?php

namespace App\Http\Controllers;

use App\Http\Resources\CampingLocationResource;
use App\Models\CampingLocation;
use App\Services\CampingLocationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CampingLocationController extends Controller
{
    public function __construct(
        private readonly CampingLocationService $campingLocationService
    ) {}

    /**
     * Display a listing of camping locations
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $locations = $this->campingLocationService->getAvailableLocations($request->all());
        
        return CampingLocationResource::collection($locations);
    }

    /**
     * Display the specified camping location with available plots
     */
    public function show(CampingLocation $campingLocation): CampingLocationResource
    {
        $location = $this->campingLocationService->getLocationWithPlots($campingLocation);
        
        return new CampingLocationResource($location);
    }

    /**
     * Get available plots for a specific location and date range
     */
    public function availablePlots(Request $request, CampingLocation $campingLocation): JsonResponse
    {
        $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'integer|min:1|max:20'
        ]);

        $availablePlots = $this->campingLocationService->getAvailablePlots(
            $campingLocation,
            $request->check_in_date,
            $request->check_out_date,
            $request->integer('guests', 1)
        );

        return response()->json([
            'success' => true,
            'data' => [
                'location' => new CampingLocationResource($campingLocation),
                'available_plots' => $availablePlots,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
            ]
        ]);
    }
}
