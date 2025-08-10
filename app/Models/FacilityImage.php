<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_id',
        'image_path',
        'alt_text',
        'sort_order',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    // Relationships
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    // Scopes
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}
