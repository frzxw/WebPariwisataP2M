<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CampingLocation;
use App\Models\CampingPlot;
use App\Models\EquipmentRental;
use App\Models\PlotBooking;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+62812345678',
                'is_active' => true,
            ]
        );

        // Create Sample Users
        $users = User::factory(10)->create();

        // Create Camping Locations
        $locations = [
            [
                'name' => 'Camping Ground Nyampay',
                'slug' => 'camping-ground-nyampay',
                'description' => 'Lokasi strategis dengan akses mudah dan pemandangan alam yang indah. Dilengkapi dengan fasilitas lengkap untuk pengalaman camping yang nyaman.',
                'address' => 'Nyampay Adventure Park, Bandung, Jawa Barat',
                'latitude' => -6.9175,
                'longitude' => 107.6191,
                'features' => json_encode(['WiFi', 'Toilet Bersih', 'Parkir Luas', 'Warung', 'Mushola', 'Security 24 Jam']),
                'contact_info' => json_encode(['phone' => '+6281234567890', 'email' => 'info@nyampay.com']),
                'operating_hours' => json_encode(['check_in' => '14:00', 'check_out' => '12:00']),
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Kampung Stamplat Girang',
                'slug' => 'kampung-stamplat-girang',
                'description' => 'Experience camping di desa wisata dengan budaya lokal yang kental. Nikmati suasana pedesaan yang asri dan tradisi yang masih terjaga.',
                'address' => 'Stamplat Girang, Bandung, Jawa Barat',
                'latitude' => -6.9000,
                'longitude' => 107.6000,
                'features' => json_encode(['Budaya Lokal', 'Toilet Tradisional', 'Warung Desa', 'Sawah', 'Tracking']),
                'contact_info' => json_encode(['phone' => '+6281234567891']),
                'operating_hours' => json_encode(['check_in' => '15:00', 'check_out' => '11:00']),
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Djamudju Coffee Camp',
                'slug' => 'djamudju-coffee-camp',
                'description' => 'Kombinasi camping dan coffee experience dengan cita rasa lokal. Nikmati kopi berkualitas sambil menikmati alam.',
                'address' => 'Djamudju Coffee, Bandung, Jawa Barat',
                'latitude' => -6.8500,
                'longitude' => 107.5500,
                'features' => json_encode(['Coffee Shop', 'Roastery', 'Workshop Kopi', 'Garden', 'Toilet']),
                'contact_info' => json_encode(['phone' => '+6281234567892', 'email' => 'hello@djamudju.com']),
                'operating_hours' => json_encode(['check_in' => '14:00', 'check_out' => '12:00']),
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Coffee Forest Camp',
                'slug' => 'coffee-forest-camp',
                'description' => 'Perkemahan di tengah hutan kopi dengan suasana alami yang menenangkan. Dikelilingi perkebunan kopi organic dan pepohonan rindang.',
                'address' => 'Coffee Forest, Bandung, Jawa Barat',
                'latitude' => -6.8800,
                'longitude' => 107.5800,
                'features' => json_encode(['Hutan Kopi', 'Organic Farm', 'Trekking Path', 'Bird Watching', 'Natural Spring', 'Eco Toilet']),
                'contact_info' => json_encode(['phone' => '+6281234567893', 'email' => 'info@coffeeforest.com']),
                'operating_hours' => json_encode(['check_in' => '13:00', 'check_out' => '11:00']),
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($locations as $locationData) {
            CampingLocation::create($locationData);
        }

        // Create Camping Plots
        $nyampayLocation = CampingLocation::where('slug', 'camping-ground-nyampay')->first();
        $stamplatLocation = CampingLocation::where('slug', 'kampung-stamplat-girang')->first();
        $djamudju = CampingLocation::where('slug', 'djamudju-coffee-camp')->first();
        $coffeeForest = CampingLocation::where('slug', 'coffee-forest-camp')->first();

        $plots = [
            // Nyampay plots
            [
                'location_id' => $nyampayLocation->id,
                'name' => 'Kavling A',
                'slug' => 'kavling-a-nyampay',
                'description' => 'Kavling A berlokasi di sebelah barat daya dari pintu masuk camping, dari kavling A ini Anda hanya perlu berjalan sekitar 2 menit kurang lebih. Dilengkapi dengan akses listrik dan air bersih.',
                'price_per_night' => 1000000,
                'max_capacity' => 6,
                'plot_number' => 'A001',
                'size_sqm' => 100.00,
                'amenities' => json_encode(['Akses Listrik', 'Air Bersih', 'Tempat Parkir', 'Akses Toilet', 'WiFi']),
                'location_description' => 'Sebelah barat daya dari pintu masuk, 2 menit berjalan kaki',
                'is_available' => true,
            ],
            [
                'location_id' => $nyampayLocation->id,
                'name' => 'Kavling B',
                'slug' => 'kavling-b-nyampay',
                'description' => 'Kavling B terletak di area tengah dengan pemandangan terbaik. Cocok untuk keluarga besar dengan fasilitas yang lengkap.',
                'price_per_night' => 1200000,
                'max_capacity' => 8,
                'plot_number' => 'B001',
                'size_sqm' => 120.00,
                'amenities' => json_encode(['Akses Listrik', 'Air Bersih', 'Tempat Parkir', 'Akses Toilet', 'WiFi', 'BBQ Area']),
                'location_description' => 'Area tengah dengan pemandangan pegunungan',
                'is_available' => true,
            ],
            [
                'location_id' => $nyampayLocation->id,
                'name' => 'Kavling C',
                'slug' => 'kavling-c-nyampay',
                'description' => 'Kavling premium dengan lokasi terbaik dan fasilitas VIP. Dilengkapi dengan gazebo pribadi.',
                'price_per_night' => 1500000,
                'max_capacity' => 10,
                'plot_number' => 'C001',
                'size_sqm' => 150.00,
                'amenities' => json_encode(['Akses Listrik', 'Air Bersih', 'Tempat Parkir', 'Toilet Pribadi', 'WiFi', 'BBQ Area', 'Gazebo']),
                'location_description' => 'Lokasi premium dengan view terbaik',
                'is_available' => true,
            ],
            // Stamplat plots
            [
                'location_id' => $stamplatLocation->id,
                'name' => 'Kavling Desa A',
                'slug' => 'kavling-desa-a-stamplat',
                'description' => 'Kavling dengan nuansa pedesaan tradisional. Dekat dengan sawah dan area budaya lokal.',
                'price_per_night' => 800000,
                'max_capacity' => 6,
                'plot_number' => 'D001',
                'size_sqm' => 80.00,
                'amenities' => json_encode(['Air Sumur', 'Toilet Tradisional', 'Tempat Parkir', 'Akses Sawah']),
                'location_description' => 'Dekat dengan area persawahan',
                'is_available' => true,
            ],
            // Djamudju plots
            [
                'location_id' => $djamudju->id,
                'name' => 'Coffee Camp Plot',
                'slug' => 'coffee-camp-plot-djamudju',
                'description' => 'Plot camping dengan akses langsung ke coffee shop. Nikmati aroma kopi setiap pagi.',
                'price_per_night' => 900000,
                'max_capacity' => 4,
                'plot_number' => 'CF001',
                'size_sqm' => 90.00,
                'amenities' => json_encode(['Akses Listrik', 'Air Bersih', 'WiFi', 'Coffee Shop Access', 'Toilet']),
                'location_description' => 'Sebelah coffee shop dengan aroma kopi alami',
                'is_available' => true,
            ],
            // Coffee Forest plots
            [
                'location_id' => $coffeeForest->id,
                'name' => 'Forest Canopy',
                'slug' => 'forest-canopy-coffee-forest',
                'description' => 'Plot premium di bawah kanopi hutan kopi dengan pemandangan kebun kopi organic. Udara sejuk dan suara alam yang menenangkan.',
                'price_per_night' => 1100000,
                'max_capacity' => 6,
                'plot_number' => 'FC001',
                'size_sqm' => 110.00,
                'amenities' => json_encode(['Natural Spring Access', 'Eco Toilet', 'Trekking Path', 'Bird Watching Spot', 'Coffee Plantation View']),
                'location_description' => 'Di bawah kanopi hutan dengan view perkebunan kopi',
                'is_available' => true,
            ],
            [
                'location_id' => $coffeeForest->id,
                'name' => 'Organic Farm View',
                'slug' => 'organic-farm-view-coffee-forest',
                'description' => 'Plot dengan pemandangan langsung ke farm organic. Ideal untuk yang ingin merasakan pengalaman agro-tourism.',
                'price_per_night' => 950000,
                'max_capacity' => 5,
                'plot_number' => 'FC002',
                'size_sqm' => 95.00,
                'amenities' => json_encode(['Farm View', 'Natural Spring Access', 'Eco Toilet', 'Educational Farm Tour']),
                'location_description' => 'Menghadap langsung ke area farm organic',
                'is_available' => true,
            ],
        ];

        foreach ($plots as $plotData) {
            CampingPlot::create($plotData);
        }

        // Create Equipment Rentals (Add-ons)
        $equipments = [
            [
                'name' => 'Paket Kemah 1',
                'description' => 'Tenda, all camping stuffed eceran camping deal. Paket lengkap untuk camping yang nyaman.',
                'price_per_day' => 75000,
                'category' => 'package',
                'stock_quantity' => 10,
                'specifications' => json_encode(['Tenda 4 orang', 'Sleeping bag 2 pcs', 'Matras 2 pcs', 'Lampu camping']),
                'is_available' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Alat Masak',
                'description' => '1 komplet alat masak untuk kebutuhan camping. Termasuk kompor portable dan peralatan memasak.',
                'price_per_day' => 25000,
                'category' => 'cooking',
                'stock_quantity' => 15,
                'specifications' => json_encode(['Kompor portable', 'Gas kaleng', 'Panci set', 'Peralatan makan']),
                'is_available' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Tenda',
                'description' => 'Tenda bergaris semi vintage untuk 2-4 orang. Berkualitas tinggi dan tahan cuaca.',
                'price_per_day' => 50000,
                'category' => 'tent',
                'stock_quantity' => 20,
                'specifications' => json_encode(['Kapasitas 4 orang', 'Tahan air', 'Mudah dipasang', 'Include ground sheet']),
                'is_available' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Tas',
                'description' => 'Tas bergaris semi vintage untuk carrier camping. Kapasitas besar dan nyaman digunakan.',
                'price_per_day' => 30000,
                'category' => 'bag',
                'stock_quantity' => 25,
                'specifications' => json_encode(['Kapasitas 60L', 'Waterproof', 'Ergonomis', 'Multiple compartment']),
                'is_available' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Sleeping Bag',
                'description' => 'Sleeping bag berkualitas untuk tidur nyaman di alam terbuka.',
                'price_per_day' => 20000,
                'category' => 'sleeping',
                'stock_quantity' => 30,
                'specifications' => json_encode(['Suhu comfort 5°C', 'Waterproof', 'Kompak', 'Mudah dibawa']),
                'is_available' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'BBQ Set',
                'description' => 'Peralatan BBQ lengkap untuk acara bakar-bakaran di camping ground.',
                'price_per_day' => 40000,
                'category' => 'cooking',
                'stock_quantity' => 8,
                'specifications' => json_encode(['Grill portable', 'Arang', 'Pemantik', 'Sendok BBQ']),
                'is_available' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($equipments as $equipmentData) {
            EquipmentRental::create($equipmentData);
        }

        // Create Sample Plot Bookings
        $locations = CampingLocation::all();
        $plots = CampingPlot::all();
        
        foreach ($users->take(8) as $user) {
            $plot = $plots->random();
            $checkInDate = now()->addDays(rand(1, 30));
            $checkOutDate = $checkInDate->copy()->addDays(rand(1, 3));
            $nights = $checkInDate->diffInDays($checkOutDate);
            $totalAmount = $plot->price_per_night * $nights;
            
            PlotBooking::create([
                'booking_code' => 'PB' . date('Ymd') . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'camping_plot_id' => $plot->id,
                'check_in_date' => $checkInDate->format('Y-m-d'),
                'check_out_date' => $checkOutDate->format('Y-m-d'),
                'check_in_name' => $user->name,
                'check_out_name' => $user->name,
                'guests_count' => rand(1, $plot->max_capacity),
                'plot_price' => $totalAmount,
                'addons_total' => 0,
                'total_amount' => $totalAmount,
                'status' => collect(['pending', 'confirmed', 'completed'])->random(),
                'payment_status' => collect(['pending', 'paid'])->random(),
                'payment_method' => collect(['bank_transfer', 'credit_card', 'e_wallet'])->random(),
                'special_requests' => 'Seeded booking for testing',
            ]);
        }

        // Create Sample Reviews for camping locations
        $completedBookings = PlotBooking::where('status', 'completed')->get();
        foreach ($completedBookings as $booking) {
            Review::create([
                'user_id' => $booking->user_id,
                'camping_location_id' => $booking->campingPlot->location_id,
                'plot_booking_id' => $booking->id,
                'rating' => rand(4, 5),
                'comment' => 'Amazing camping experience! The location was beautiful and the facilities were excellent.',
                'is_approved' => true,
                'approved_at' => now(),
            ]);
        }

        // Update camping location ratings
        foreach ($locations as $location) {
            $avgRating = $location->reviews()->where('is_approved', true)->avg('rating') ?: 0;
            $totalReviews = $location->reviews()->where('is_approved', true)->count();
            
            $location->update([
                'rating' => round($avgRating, 2),
                'total_reviews' => $totalReviews,
            ]);
        }
    }
}
