<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create admin user if not exists
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '082345678901',
                'address' => 'Bandung, Jawa Barat',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }

        // Create additional admin user for testing
        if (!User::where('email', 'super.admin@example.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'super.admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Jakarta, DKI Jakarta',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }
    }
}
