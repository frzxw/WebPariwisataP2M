<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampingLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'latitude',
        'longitude',
        'images',
        'features',
        'contact_info',
        'operating_hours',
        'price_per_night',
        'is_active',
        'sort_order',
        'rating',
        'total_reviews',
    ];

    protected $casts = [
        'images' => 'array',
        'features' => 'array',
        'contact_info' => 'array',
        'operating_hours' => 'array',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get the camping plots for this location
     */
    public function campingPlots(): HasMany
    {
        return $this->hasMany(CampingPlot::class, 'location_id');
    }

    /**
     * Get available camping plots for this location
     */
    public function availablePlots(): HasMany
    {
        return $this->campingPlots()->where('is_available', true);
    }

    /**
     * Get reviews for this camping location
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'camping_location_id');
    }

    /**
     * Get primary image
     */
    public function getPrimaryImageAttribute(): ?string
    {
        return $this->images ? $this->images[0] ?? null : null;
    }

    /**
     * Get Google Maps embed URL
     */
    public function getMapEmbedUrlAttribute(): string
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1000!2d{$this->longitude}!3d{$this->latitude}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z!5e0!3m2!1sen!2sid";
        }
        return '';
    }

    /**
     * Scope for active locations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
