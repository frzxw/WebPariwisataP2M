<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camping_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('address');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('images')->nullable();
            $table->json('features')->nullable(); // Array of location features
            $table->json('contact_info')->nullable(); // Phone, email, etc.
            $table->json('operating_hours')->nullable(); // Operating schedule
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->decimal('rating', 3, 2)->default(0); // Average rating
            $table->integer('total_reviews')->default(0); // Total number of reviews
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['is_active', 'sort_order']);
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('camping_locations');
    }
};
