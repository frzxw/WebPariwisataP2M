<?php

namespace App\Services;

use App\Models\EquipmentRental;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EquipmentRentalService
{
    /**
     * Get all equipment rentals with filtering
     */
    public function getAllEquipment(array $filters = []): LengthAwarePaginator
    {
        return EquipmentRental::query()
            ->when(isset($filters['category']), function ($query) use ($filters) {
                $query->where('category', $filters['category']);
            })
            ->when(isset($filters['search']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            })
            ->when(isset($filters['available_only']) && $filters['available_only'], function ($query) {
                $query->where('stock_quantity', '>', 0)
                      ->where('is_available', true);
            })
            ->when(isset($filters['min_price']), function ($query) use ($filters) {
                $query->where('price_per_day', '>=', $filters['min_price']);
            })
            ->when(isset($filters['max_price']), function ($query) use ($filters) {
                $query->where('price_per_day', '<=', $filters['max_price']);
            })
            ->orderBy('category', 'asc')
            ->orderBy('name', 'asc')
            ->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get equipment by category
     */
    public function getEquipmentByCategory(): Collection
    {
        return EquipmentRental::where('is_available', true)
            ->where('stock_quantity', '>', 0)
            ->get()
            ->groupBy('category');
    }

    /**
     * Get equipment details with stock information
     */
    public function getEquipmentDetails(int $id): EquipmentRental
    {
        $equipment = EquipmentRental::findOrFail($id);
        
        // Add calculated availability information
        $equipment->available_stock = $equipment->getAvailableStock();
        $equipment->rental_history_count = $equipment->bookingAddons()->count();
        
        return $equipment;
    }

    /**
     * Check stock availability for multiple equipment items
     */
    public function checkStockAvailability(array $equipmentList): array
    {
        $results = [];
        
        foreach ($equipmentList as $item) {
            $equipment = EquipmentRental::find($item['equipment_id']);
            $requestedQuantity = $item['quantity'];
            
            if (!$equipment) {
                $results[] = [
                    'equipment_id' => $item['equipment_id'],
                    'available' => false,
                    'error' => 'Equipment tidak ditemukan'
                ];
                continue;
            }

            $isAvailable = $equipment->isInStock($requestedQuantity);
            $availableStock = $equipment->getAvailableStock();
            
            $results[] = [
                'equipment_id' => $equipment->id,
                'name' => $equipment->name,
                'requested_quantity' => $requestedQuantity,
                'available_stock' => $availableStock,
                'available' => $isAvailable,
                'price_per_day' => $equipment->price_per_day,
                'formatted_price' => $equipment->formatted_price,
                'error' => !$isAvailable ? "Hanya tersedia {$availableStock} unit" : null
            ];
        }
        
        return $results;
    }

    /**
     * Calculate total cost for equipment rental
     */
    public function calculateRentalCost(array $equipmentList, int $days): array
    {
        $totalCost = 0;
        $breakdown = [];
        
        foreach ($equipmentList as $item) {
            $equipment = EquipmentRental::findOrFail($item['equipment_id']);
            $quantity = $item['quantity'];
            $pricePerDay = $equipment->price_per_day;
            $itemTotal = $quantity * $pricePerDay * $days;
            
            $breakdown[] = [
                'equipment_id' => $equipment->id,
                'name' => $equipment->name,
                'quantity' => $quantity,
                'price_per_day' => $pricePerDay,
                'days' => $days,
                'subtotal' => $itemTotal,
                'formatted_subtotal' => 'Rp ' . number_format($itemTotal, 0, ',', '.')
            ];
            
            $totalCost += $itemTotal;
        }
        
        return [
            'breakdown' => $breakdown,
            'total_cost' => $totalCost,
            'formatted_total' => 'Rp ' . number_format($totalCost, 0, ',', '.'),
            'days' => $days
        ];
    }

    /**
     * Get popular equipment based on rental frequency
     */
    public function getPopularEquipment(int $limit = 10): Collection
    {
        return EquipmentRental::withCount('bookingAddons')
            ->where('is_available', true)
            ->where('stock_quantity', '>', 0)
            ->orderBy('booking_addons_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get equipment recommendations based on category
     */
    public function getRecommendations(string $category, int $limit = 5): Collection
    {
        return EquipmentRental::where('category', $category)
            ->where('is_available', true)
            ->where('stock_quantity', '>', 0)
            ->withCount('bookingAddons')
            ->orderBy('booking_addons_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get equipment categories with counts
     */
    public function getCategories(): array
    {
        $categories = EquipmentRental::where('is_available', true)
            ->selectRaw('category, COUNT(*) as count, AVG(price_per_day) as avg_price')
            ->groupBy('category')
            ->orderBy('category')
            ->get();
        
        return $categories->map(function ($category) {
            return [
                'name' => $category->category,
                'count' => $category->count,
                'avg_price' => round($category->avg_price),
                'formatted_avg_price' => 'Rp ' . number_format(round($category->avg_price), 0, ',', '.')
            ];
        })->toArray();
    }

    /**
     * Update equipment stock after booking
     */
    public function updateStock(int $equipmentId, int $quantity, string $operation = 'decrease'): void
    {
        $equipment = EquipmentRental::findOrFail($equipmentId);
        
        if ($operation === 'decrease') {
            if ($equipment->stock_quantity < $quantity) {
                throw new \Exception("Insufficient stock for {$equipment->name}");
            }
            $equipment->decrement('stock_quantity', $quantity);
        } else {
            $equipment->increment('stock_quantity', $quantity);
        }
    }

    /**
     * Get equipment rental statistics
     */
    public function getEquipmentStatistics(): array
    {
        $totalEquipment = EquipmentRental::count();
        $availableEquipment = EquipmentRental::where('is_available', true)
            ->where('stock_quantity', '>', 0)
            ->count();
        
        $mostRented = EquipmentRental::withCount('bookingAddons')
            ->orderBy('booking_addons_count', 'desc')
            ->first();
        
        $totalRevenue = EquipmentRental::join('booking_addons', 'equipment_rentals.id', '=', 'booking_addons.equipment_rental_id')
            ->sum('booking_addons.total_price');
        
        return [
            'total_equipment' => $totalEquipment,
            'available_equipment' => $availableEquipment,
            'out_of_stock' => $totalEquipment - $availableEquipment,
            'most_rented' => $mostRented ? [
                'name' => $mostRented->name,
                'rental_count' => $mostRented->booking_addons_count
            ] : null,
            'total_revenue' => $totalRevenue,
            'formatted_revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.')
        ];
    }
}
