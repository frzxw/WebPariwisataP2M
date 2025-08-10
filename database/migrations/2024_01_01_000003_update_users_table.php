<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user')->after('password');
            $table->string('phone')->nullable()->after('email');
            $table->string('profile_picture')->nullable()->after('phone');
            $table->date('birth_date')->nullable()->after('profile_picture');
            $table->enum('gender', ['male', 'female'])->nullable()->after('birth_date');
            $table->text('address')->nullable()->after('gender');
            $table->boolean('is_active')->default(true)->after('address');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'phone', 'profile_picture', 'birth_date', 
                'gender', 'address', 'is_active'
            ]);
            $table->dropSoftDeletes();
        });
    }
};
