<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plot_booking_id')->constrained()->onDelete('cascade');
            $table->string('payment_method');
            $table->string('transaction_id')->nullable();
            $table->string('external_id')->nullable(); // Payment gateway transaction ID
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'pending_verification', 'paid', 'failed', 'cancelled', 'refunded', 'pending_refund']);
            $table->json('gateway_response')->nullable();
            $table->string('proof_of_payment')->nullable(); // For manual payment proof
            $table->text('notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            $table->index(['plot_booking_id', 'status']);
            $table->index(['transaction_id']);
            $table->index(['external_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
    }
};
