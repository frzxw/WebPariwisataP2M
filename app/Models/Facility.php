<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Facility extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'capacity',
        'category_id',
        'images',
        'features',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'features' => 'array',
            'is_available' => 'boolean',
            'price' => 'decimal:2',
            'rating' => 'decimal:1',
        ];
    }

    // Boot method for auto-generating slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($facility) {
            if (empty($facility->slug)) {
                $facility->slug = Str::slug($facility->name);
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function facilityImages()
    {
        return $this->hasMany(FacilityImage::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Accessors
    public function getPrimaryImageAttribute()
    {
        $images = $this->images ?? [];
        return !empty($images) ? asset('storage/' . $images[0]) : asset('images/default-facility.jpg');
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Methods
    public function updateRating()
    {
        $avgRating = $this->reviews()
            ->whereNotNull('rating')
            ->avg('rating');
        
        $this->update(['rating' => round($avgRating, 1)]);
    }

    public function incrementBookingCount()
    {
        $this->increment('total_bookings');
    }
}
