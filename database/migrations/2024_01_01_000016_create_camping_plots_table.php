<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camping_plots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('camping_locations')->onDelete('cascade');
            $table->string('name'); // e.g., "Kavling A", "Kavling B"
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price_per_night', 10, 2);
            $table->integer('max_capacity'); // Maximum guests allowed
            $table->string('plot_number')->nullable(); // Plot identifier
            $table->decimal('size_sqm', 8, 2)->nullable(); // Plot size in square meters
            $table->json('amenities')->nullable(); // Array of amenities
            $table->json('images')->nullable(); // Multiple images
            $table->boolean('is_available')->default(true);
            $table->json('special_features')->nullable(); // Special plot features
            $table->text('location_description')->nullable(); // Location within the camping ground
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['location_id', 'is_available']);
            $table->index(['is_available']);
            $table->index('slug');
            $table->unique(['location_id', 'plot_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('camping_plots');
    }
};
