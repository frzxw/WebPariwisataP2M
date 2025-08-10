<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'plot_booking_id',
        'equipment_rental_id', 
        'quantity',
        'price_per_day',
        'days',
        'total_price',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the plot booking that owns the addon
     */
    public function plotBooking(): BelongsTo
    {
        return $this->belongsTo(PlotBooking::class);
    }

    /**
     * Get the equipment rental
     */
    public function equipmentRental(): BelongsTo
    {
        return $this->belongsTo(EquipmentRental::class);
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
