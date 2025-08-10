<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'facility_id',
        'booking_id',
        'rating',
        'comment',
        'images',
        'is_approved',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'is_approved' => 'boolean',
            'rating' => 'integer',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    // Accessors
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y');
    }
}
