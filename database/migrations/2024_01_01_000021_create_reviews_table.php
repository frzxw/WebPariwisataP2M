<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('camping_location_id')->constrained()->onDelete('cascade');
            $table->foreignId('plot_booking_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->json('images')->nullable(); // Review images
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            
            $table->index(['camping_location_id', 'is_approved']);
            $table->index(['user_id', 'created_at']);
            $table->index(['rating', 'is_approved']);
            $table->unique(['user_id', 'plot_booking_id']); // One review per booking per user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
