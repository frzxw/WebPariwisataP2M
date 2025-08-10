<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacilityRequest;
use App\Http\Resources\FacilityResource;
use App\Models\Facility;
use App\Services\FacilityService;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function __construct(private FacilityService $facilityService) {}

    public function index(Request $request)
    {
        $facilities = Facility::with(['category'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('is_available', $status === 'available');
            })
            ->latest()
            ->paginate(12);

        return FacilityResource::collection($facilities);
    }

    public function store(FacilityRequest $request)
    {
        try {
            $facility = $this->facilityService->createFacility($request->validated());
            return new FacilityResource($facility);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show(Facility $facility)
    {
        return new FacilityResource($facility->load(['category', 'facilityImages', 'reviews.user']));
    }

    public function update(FacilityRequest $request, Facility $facility)
    {
        try {
            $facility = $this->facilityService->updateFacility($facility, $request->validated());
            return new FacilityResource($facility);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy(Facility $facility)
    {
        try {
            $this->facilityService->deleteFacility($facility);
            return response()->json([
                'success' => true,
                'message' => 'Facility deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function checkAvailability(Request $request, Facility $facility)
    {
        $request->validate([
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        try {
            $isAvailable = $this->facilityService->checkAvailability(
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
}
