<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plot_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('camping_plot_id')->constrained()->onDelete('cascade');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->string('check_in_name'); // Name for check-in
            $table->string('check_out_name'); // Name for check-out
            $table->integer('guests_count');
            $table->decimal('plot_price', 10, 2); // Base plot price
            $table->decimal('addons_total', 10, 2)->default(0); // Total addon costs
            $table->decimal('total_amount', 10, 2); // Final total amount
            $table->enum('status', ['pending', 'confirmed', 'checked_in', 'checked_out', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->text('special_requests')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id', 'status']);
            $table->index(['camping_plot_id', 'check_in_date']);
            $table->index(['check_in_date', 'check_out_date']);
            $table->index('booking_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plot_bookings');
    }
};
