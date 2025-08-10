<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampingPlot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_per_night',
        'max_capacity',
        'location_id',
        'plot_number',
        'size_sqm',
        'amenities',
        'images',
        'is_available',
        'special_features',
        'location_description',
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
        'is_available' => 'boolean',
        'price_per_night' => 'decimal:2',
    ];

    /**
     * Get the location that owns the camping plot
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(CampingLocation::class, 'location_id');
    }

    /**
     * Get the bookings for the camping plot
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(PlotBooking::class);
    }

    /**
     * Check if the plot is available for the given date range
     */
    public function isAvailableForDates($checkIn, $checkOut): bool
    {
        if (!$this->is_available) {
            return false;
        }

        return !$this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in_date', '<=', $checkIn)
                          ->where('check_out_date', '>=', $checkOut);
                    });
            })
            ->exists();
    }

    /**
     * Get primary image
     */
    public function getPrimaryImageAttribute(): ?string
    {
        return $this->images ? $this->images[0] ?? null : null;
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_per_night, 0, ',', '.');
    }

    /**
     * Scope for available plots
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope for plots by location
     */
    public function scopeByLocation($query, $locationId)
    {
        return $query->where('location_id', $locationId);
    }
}
