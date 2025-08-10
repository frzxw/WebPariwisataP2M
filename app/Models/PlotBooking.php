<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlotBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_code',
        'user_id',
        'camping_plot_id',
        'check_in_date',
        'check_out_date',
        'check_in_name',
        'check_out_name',
        'guests_count',
        'plot_price',
        'addons_total',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'special_requests',
        'notes',
        'confirmed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'plot_price' => 'decimal:2',
        'addons_total' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->booking_code) {
                $model->booking_code = static::generateBookingCode();
            }
        });
    }

    /**
     * Generate unique booking code
     */
    public static function generateBookingCode(): string
    {
        do {
            $code = 'CG' . date('Ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (static::where('booking_code', $code)->exists());

        return $code;
    }

    /**
     * Get the user that owns the booking
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the camping plot that was booked
     */
    public function campingPlot(): BelongsTo
    {
        return $this->belongsTo(CampingPlot::class);
    }

    /**
     * Get the booking addons
     */
    public function bookingAddons(): HasMany
    {
        return $this->hasMany(BookingAddon::class, 'plot_booking_id');
    }

    /**
     * Get the payment logs
     */
    public function paymentLogs(): HasMany
    {
        return $this->hasMany(PaymentLog::class, 'plot_booking_id');
    }

    /**
     * Get the reviews for this booking
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'plot_booking_id');
    }

    /**
     * Calculate duration in nights
     */
    public function getDurationInNightsAttribute(): int
    {
        return $this->check_in_date->diffInDays($this->check_out_date);
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Check if booking can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) &&
               $this->check_in_date->isFuture();
    }

    /**
     * Check if booking can be reviewed
     */
    public function canBeReviewed(): bool
    {
        return $this->status === 'completed' && 
               !$this->reviews()->exists();
    }

    /**
     * Scope for active bookings
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['cancelled']);
    }

    /**
     * Scope for user bookings
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for upcoming bookings
     */
    public function scopeUpcoming($query)
    {
        return $query->where('check_in_date', '>', now());
    }
}
