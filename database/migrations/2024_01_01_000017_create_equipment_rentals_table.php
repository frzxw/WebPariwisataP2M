<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_rentals', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Tenda", "Sleeping Bag", "Paket Kemah 1"
            $table->text('description');
            $table->decimal('price_per_day', 10, 2);
            $table->string('category'); // tent, cooking, bag, package, etc.
            $table->integer('stock_quantity')->default(0);
            $table->string('image')->nullable();
            $table->json('specifications')->nullable(); // Equipment specifications
            $table->boolean('is_available')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['category', 'is_available']);
            $table->index(['is_available', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_rentals');
    }
};
