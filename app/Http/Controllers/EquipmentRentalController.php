<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentRentalResource;
use App\Models\EquipmentRental;
use App\Services\EquipmentRentalService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EquipmentRentalController extends Controller
{
    public function __construct(
        private readonly EquipmentRentalService $equipmentRentalService
    ) {}

    /**
     * Display available equipment for rental
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $equipment = $this->equipmentRentalService->getAvailableEquipment($request->all());
        
        return EquipmentRentalResource::collection($equipment);
    }

    /**
     * Display the specified equipment
     */
    public function show(EquipmentRental $equipmentRental): EquipmentRentalResource
    {
        return new EquipmentRentalResource($equipmentRental);
    }

    /**
     * Get equipment by category
     */
    public function byCategory(Request $request, string $category): AnonymousResourceCollection
    {
        $equipment = $this->equipmentRentalService->getEquipmentByCategory($category, $request->all());
        
        return EquipmentRentalResource::collection($equipment);
    }

    /**
     * Check equipment stock availability
     */
    public function checkStock(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment_rentals,id',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $isAvailable = $this->equipmentRentalService->checkStockAvailability(
            $request->equipment_id,
            $request->quantity,
            $request->start_date,
            $request->end_date
        );

        return response()->json([
            'success' => true,
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Equipment tersedia' : 'Stok tidak mencukupi untuk tanggal yang dipilih'
        ]);
    }
}
