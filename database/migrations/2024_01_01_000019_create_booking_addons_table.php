<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plot_booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipment_rental_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price_per_day', 10, 2); // Price per day for this equipment
            $table->integer('days'); // Number of rental days
            $table->decimal('total_price', 10, 2); // quantity * price_per_day * days
            $table->timestamps();
            
            $table->unique(['plot_booking_id', 'equipment_rental_id']);
            $table->index('plot_booking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_addons');
    }
};
