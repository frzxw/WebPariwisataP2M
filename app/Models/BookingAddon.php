<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'addon_type',
        'addon_id',
        'quantity',
        'price_per_unit',
        'total_price',
    ];

    protected $casts = [
        'price_per_unit' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the booking that owns the addon
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the equipment rental when addon_type is equipment
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(EquipmentRental::class, 'addon_id');
    }

    /**
     * Get formatted total price
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * Calculate total price
     */
    public function calculateTotal(): void
    {
        $this->total_price = $this->quantity * $this->price_per_day * $this->days;
    }

    /**
     * Boot method to auto-calculate total
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calculateTotal();
        });
    }
}
