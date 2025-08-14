<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'plot_booking_id',
        'booking_id', // Legacy support
        'amount',
        'payment_method',
        'payment_reference',
        'transaction_id',
        'status',
        'payment_proof',
        'notes',
        'paid_at',
        'verified_at',
        'verified_by',
        'payment_gateway', // Legacy support
        'response_data', // Legacy support
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
        'response_data' => 'json',
    ];

    /**
     * Get the plot booking that owns this payment log
     */
    public function plotBooking(): BelongsTo
    {
        return $this->belongsTo(PlotBooking::class);
    }

    /**
     * Get the legacy booking (for backward compatibility)
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the admin who verified this payment
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Check if payment is successful
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Mark payment as paid
     */
    public function markAsPaid(): void
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    /**
     * Mark payment as failed
     */
    public function markAsFailed(string $reason = null): void
    {
        $this->update([
            'status' => 'failed',
            'notes' => $reason,
        ]);
    }

    /**
     * Verify payment by admin
     */
    public function verify(int $adminId): void
    {
        $this->update([
            'status' => 'paid',
            'verified_at' => now(),
            'verified_by' => $adminId,
            'paid_at' => $this->paid_at ?? now(),
        ]);
    }

    // Scopes
    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}
