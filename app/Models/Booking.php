<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_code',
        'user_id',
        'facility_id',
        'check_in',
        'check_out',
        'guests',
        'subtotal',
        'tax_amount',
        'total_amount',
        'payment_method',
        'payment_status',
        'booking_status',
        'special_requests',
        'cancellation_reason',
        'cancelled_at',
        'payment_proof',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'datetime',
            'check_out' => 'datetime',
            'cancelled_at' => 'datetime',
            'payment_proof' => 'array',
            'subtotal' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    // Boot method for auto-generating booking code
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = 'TRX-' . strtoupper(uniqid());
            }
        });
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

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'booking_addons')
            ->withPivot('quantity', 'unit_price', 'total_price')
            ->withTimestamps();
    }

    public function paymentLogs()
    {
        return $this->hasMany(PaymentLog::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // Scopes
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('booking_status', ['confirmed', 'checked_in']);
    }

    // Accessors
    public function getDurationAttribute()
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'refunded' => 'bg-blue-100 text-blue-800',
        ];

        return $badges[$this->payment_status] ?? 'bg-gray-100 text-gray-800';
    }

    // Methods
    public function calculateTotal()
    {
        $subtotal = $this->facility->price * $this->duration;
        $addonTotal = $this->addons->sum('pivot.total_price');
        $taxAmount = ($subtotal + $addonTotal) * 0.1; // 10% tax
        
        $this->update([
            'subtotal' => $subtotal + $addonTotal,
            'tax_amount' => $taxAmount,
            'total_amount' => $subtotal + $addonTotal + $taxAmount,
        ]);
    }

    public function canBeCancelled(): bool
    {
        return $this->payment_status === 'pending' && 
               $this->booking_status === 'confirmed' &&
               $this->check_in->isFuture();
    }
}
