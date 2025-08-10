<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Models\Addon;
use App\Models\Facility;
use Illuminate\Http\Request;

class BookingPageController extends Controller
{
    public function show(Request $request)
    {
        // Get the facility (defaulting to first available if none specified)
        $facilityId = $request->get('facility_id');
        $facility = $facilityId 
            ? Facility::with(['category', 'facilityImages'])->findOrFail($facilityId)
            : Facility::with(['category', 'facilityImages'])->available()->first();

        if (!$facility) {
            return redirect()->route('homepage')->with('error', 'No facilities available');
        }

        // Get available addons
        $addons = Addon::available()->get();

        return view('booking', compact('facility', 'addons'));
    }

    public function getAvailableFacilities()
    {
        $facilities = Facility::with(['category'])
            ->available()
            ->get();

        return response()->json([
            'success' => true,
            'data' => FacilityResource::collection($facilities)
        ]);
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $facility = Facility::findOrFail($request->facility_id);
        $bookingService = new \App\Services\BookingService();
        
        $isAvailable = $bookingService->isAvailable(
            $facility,
            $request->check_in,
            $request->check_out
        );

        return response()->json([
            'success' => true,
            'available' => $isAvailable,
            'facility' => new \App\Http\Resources\FacilityResource($facility)
        ]);
    }
}
