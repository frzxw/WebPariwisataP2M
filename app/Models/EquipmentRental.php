<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentRental extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_per_day',
        'category',
        'stock_quantity',
        'image',
        'specifications',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'specifications' => 'array',
        'is_available' => 'boolean',
    ];

    /**
     * Get the booking addons for this equipment
     */
    public function bookingAddons(): HasMany
    {
        return $this->hasMany(BookingAddon::class);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_per_day, 0, ',', '.');
    }

    /**
     * Check if equipment is in stock
     */
    public function isInStock($quantity = 1): bool
    {
        return $this->is_available && $this->stock_quantity >= $quantity;
    }

    /**
     * Scope for available equipment
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)
                    ->where('stock_quantity', '>', 0);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope ordered
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
