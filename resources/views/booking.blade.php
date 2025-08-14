<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Booking</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            line-height: 1.6;
            color: #333;
            background: url('{{ asset('images/background.png') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        /* Main Content */
        .main-content {
            margin-top: 80px;
            padding: 2rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        /* Left Column */
        .booking-form {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .form-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Kavling Section */
        .kavling-section {
            position: relative;
        }

        .carousel-container {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .carousel {
            position: relative;
            height: 250px;
        }

        .carousel-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .carousel-slide.active {
            opacity: 1;
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #2d5016;
            transition: all 0.3s;
            z-index: 10;
        }

        .carousel-nav:hover {
            background: white;
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-prev {
            left: 15px;
        }

        .carousel-next {
            right: 15px;
        }

        /* Location Selection Styles */
        .location-option {
            margin-bottom: 1rem;
        }

        .location-option input[type="radio"] {
            display: none;
        }

        .location-card {
            display: flex;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
        }

        .location-card:hover, 
        .location-option input[type="radio"]:checked + .location-card {
            border-color: #3A5A40;
            box-shadow: 0 4px 12px rgba(58, 90, 64, 0.1);
        }

        .location-image-container {
            width: 120px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            margin-right: 1rem;
        }

        .location-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .location-details h3 {
            font-size: 1.1rem;
            color: #3A5A40;
            margin-bottom: 0.5rem;
        }

        .location-details p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
            margin-bottom: 0.5rem;
        }

        .location-price {
            color: #2d5016;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Kavling Selection Styles */
        .kavling-option {
            margin-bottom: 1rem;
        }

        .kavling-option input[type="radio"] {
            display: none;
        }

        .kavling-card {
            display: flex;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
        }

        .kavling-card:hover,
        .kavling-option input[type="radio"]:checked + .kavling-card {
            border-color: #3A5A40;
            box-shadow: 0 4px 12px rgba(58, 90, 64, 0.1);
        }

        .kavling-image-container {
            width: 120px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .kavling-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .kavling-details {
            flex: 1;
        }

        .kavling-details h3 {
            font-size: 1.1rem;
            color: #3A5A40;
            margin-bottom: 0.5rem;
        }

        .kavling-details p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
            margin-bottom: 0.5rem;
        }

        .kavling-specs {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            color: #666;
        }

        .kavling-price {
            color: #2d5016;
            font-weight: 600;
            font-size: 0.95rem;
            margin-top: auto;
        }

        .amenity-tag {
            display: inline-block;
            background: #f8f9fa;
            color: #666;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            margin-right: 0.25rem;
            margin-bottom: 0.25rem;
        }

        /* Payment Methods Styles */
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .payment-method {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
            text-align: center;
        }

        .payment-method:hover {
            border-color: #3A5A40;
            box-shadow: 0 4px 12px rgba(58, 90, 64, 0.1);
        }

        .payment-method.selected {
            border-color: #3A5A40;
            background: #f8f9fa;
            box-shadow: 0 4px 12px rgba(58, 90, 64, 0.15);
        }

        .payment-icon {
            width: 40px;
            height: 40px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-icon img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .payment-name {
            font-size: 0.85rem;
            font-weight: 500;
            color: #333;
        }

        .payment-method.selected .payment-name {
            color: #3A5A40;
            font-weight: 600;
        }

        /* Payment method animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }

        .payment-method {
            transition: all 0.3s ease;
        }

        .payment-method:focus {
            outline: 2px solid #3A5A40;
            outline-offset: 2px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 1rem;
                padding: 1rem;
            }

            .location-card, .kavling-card {
                flex-direction: column;
            }

            .location-image-container, .kavling-image-container {
                width: 100%;
                height: 120px;
                margin-right: 0;
                margin-bottom: 1rem;
            }

            .kavling-specs {
                flex-direction: column;
                gap: 0.25rem;
            }
        }
            margin-top: 0.5rem;
        }

        .amenity-tag {
            background: #f8f9fa;
            color: #495057;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        .kavling-price {
            color: #2d5016;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #2d5016;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        /* Add-ons Section */
        .addon-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border: 2px solid #f1f3f4;
            border-radius: 10px;
            margin-bottom: 1rem;
            transition: all 0.3s;
        }

        .addon-item:hover {
            border-color: #2d5016;
            background: #f8f9fa;
        }

        .addon-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .addon-icon {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            background-size: cover;
            background-position: center;
        }

        .addon-details h4 {
            font-size: 1rem;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .addon-details p {
            font-size: 0.8rem;
            color: #666;
        }

        .addon-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            border: none;
            background: #f8f9fa;
            color: #333;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: all 0.3s;
        }

        .qty-btn:hover {
            background: #3A5A40;
            color: white;
        }

        .qty-display {
            min-width: 30px;
            text-align: center;
            font-weight: bold;
        }

        /* Right Column - Order Summary */
        .order-summary {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .summary-title {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
        }

        .summary-row:not(.total) {
            border-bottom: 1px solid #f1f3f4;
        }

                .summary-row.total {
            border-top: 2px solid #3A5A40;
            padding-top: 1rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: #3A5A40;
        }

        .order-detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            width: 100%;
        }

        .detail-label {
            font-size: 0.85rem;
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            font-size: 0.95rem;
            color: #333;
            font-weight: 600;
        }

        .item-name {
            color: #666;
        }

        .item-price {
            font-weight: 600;
            color: #333;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .continue-btn {
            width: 100%;
            background: #3A5A40;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .continue-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 1rem;
                padding: 0 1rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .order-summary {
                position: relative;
                top: 0;
            }
        }
    </style>
</head>
<body>
    @include('partials.header')

    <main class="main-content">
        <div class="container">
            <!-- Left Column - Booking Form -->
            <form action="{{ route('web.booking.store') }}" method="POST" id="booking-form" class="booking-form">
                @csrf
                
                <!-- Location Selection -->
                @if($campingLocations->count() > 0)
                <div class="form-card">
                    <h2 style="margin-bottom: 1.5rem; color: #3A5A40;">Pilih Lokasi Camping</h2>
                    
                    @foreach($campingLocations as $index => $location)
                    @php
                        // Calculate minimum kavling price for this location
                        $minKavlingPrice = $location->campingPlots->min('price_per_night') ?? $location->price_per_night;
                    @endphp
                    <div class="location-option" onclick="selectLocation({{ $location->id }})">
                        <input type="radio" name="camping_location_id" value="{{ $location->id }}" 
                               id="location_{{ $location->id }}" {{ $index == 0 ? 'checked' : '' }}
                               data-name="{{ $location->name }}" data-price="{{ $minKavlingPrice }}">
                        <label for="location_{{ $location->id }}" class="location-card">
                            <div class="location-image-container">
                                @if($location->images && is_array(json_decode($location->images, true)))
                                    <img src="{{ asset('storage/' . json_decode($location->images, true)[0]) }}" 
                                         alt="{{ $location->name }}" class="location-image">
                                @else
                                    <img src="https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                         alt="{{ $location->name }}" class="location-image">
                                @endif
                            </div>
                            <div class="location-details">
                                <h3>{{ $location->name }}</h3>
                                <p>{{ Str::limit($location->description, 100) }}</p>
                                <div class="location-price">Mulai dari Rp {{ number_format($minKavlingPrice, 0, ',', '.') }}/malam</div>
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>

                <!-- Kavling Selection -->
                @foreach($campingLocations as $index => $location)
                    @if($location->campingPlots->count() > 0)
                    <div class="form-card kavling-section" id="kavling-section-{{ $location->id }}" 
                         style="{{ $index == 0 ? '' : 'display: none;' }}">
                        <h2 style="margin-bottom: 1.5rem; color: #3A5A40;">Pilih Kavling di {{ $location->name }}</h2>
                        
                        @foreach($location->campingPlots as $plotIndex => $plot)
                        <div class="kavling-option" onclick="selectKavling({{ $plot->id }}, {{ $location->id }})">
                            <input type="radio" name="camping_plot_id" value="{{ $plot->id }}" 
                                   id="plot_{{ $plot->id }}" {{ $index == 0 && $plotIndex == 0 ? 'checked' : '' }}
                                   data-name="{{ $plot->name }}" data-price="{{ $plot->price_per_night }}"
                                   data-location="{{ $location->id }}">
                            <label for="plot_{{ $plot->id }}" class="kavling-card">
                                <div class="kavling-image-container">
                                    @if($plot->images && is_array(json_decode($plot->images, true)))
                                        <img src="{{ asset('storage/' . json_decode($plot->images, true)[0]) }}" 
                                             alt="{{ $plot->name }}" class="kavling-image">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                             alt="{{ $plot->name }}" class="kavling-image">
                                    @endif
                                </div>
                                <div class="kavling-details">
                                    <h3>{{ $plot->name }}</h3>
                                    <p>{{ Str::limit($plot->description, 80) }}</p>
                                    <div class="kavling-specs">
                                        <span>{{ $plot->max_capacity }} orang</span>
                                        <span>{{ $plot->size_sqm }}m²</span>
                                    </div>
                                    @if($plot->amenities)
                                        <div class="amenities" style="margin-top: 0.5rem;">
                                            @foreach(array_slice(json_decode($plot->amenities, true), 0, 3) as $amenity)
                                                <span class="amenity-tag">{{ $amenity }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="kavling-price">Rp {{ number_format($plot->price_per_night, 0, ',', '.') }}/malam</div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @endif
                @endforeach
                @endif

                <!-- Add Ons Section -->
                <div class="form-card">
                    <h3 style="margin-bottom: 1.5rem; color: #3A5A40;">Add Ons (Opsional)</h3>
                    <p style="margin-bottom: 2rem; color: #666; font-size: 0.9rem;">Add On hanya bisa disewa ketika kavling sudah dipilih</p>

                    @if($equipmentRentals->count() > 0)
                        @foreach($equipmentRentals as $categoryName => $equipmentItems)
                            @foreach($equipmentItems as $equipment)
                                <div class="addon-item">
                                    <div class="addon-info">
                                        <div class="addon-icon" style="background-image: url('{{ $equipment->image ? asset('storage/' . $equipment->image) : 'https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80' }}')"></div>
                                        <div class="addon-details">
                                            <h4>{{ $equipment->name }}</h4>
                                            <p>{{ ucfirst($equipment->category) }}</p>
                                            @if($equipment->description)
                                                <p>{{ $equipment->description }}</p>
                                            @endif
                                            <p style="color: #2d5016; font-weight: 500;">Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}/hari</p>
                                        </div>
                                    </div>
                                    <div class="addon-controls">
                                        <div class="quantity-control">
                                            <button type="button" class="qty-btn" onclick="changeQuantity('equipment_{{ $equipment->id }}', -1)">−</button>
                                            <span class="qty-display" id="equipment_{{ $equipment->id }}-qty">0</span>
                                            <button type="button" class="qty-btn" onclick="changeQuantity('equipment_{{ $equipment->id }}', 1)">+</button>
                                            <input type="hidden" name="equipment[{{ $equipment->id }}]" id="equipment_{{ $equipment->id }}-input" value="0">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                </div>

                <!-- Additional Form Fields -->
                <div class="form-card">
                    <h3 style="margin-bottom: 1.5rem; color: #3A5A40;">Informasi Kontak</h3>
                    
                    @auth
                        <div class="form-group">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-input" 
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-input" 
                                       value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="phone">Nomor Telepon</label>
                                <input type="tel" name="phone" id="phone" class="form-input" 
                                       value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                                @error('phone')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info" style="background: linear-gradient(135deg, #f8f9fa 0%, #e3f2e6 100%); color: #3A5A40; padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; border: 2px solid #d4edda; box-shadow: 0 4px 12px rgba(58, 90, 64, 0.1);">
                            <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                                <div style="width: 40px; height: 40px; background: #3A5A40; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; color: white; font-size: 1.2rem;">!</div>
                                <div>
                                    <strong style="font-size: 1.1rem; color: #2d5016;">Silakan login terlebih dahulu</strong>
                                    <p style="margin: 0.25rem 0 0 0; color: #666; font-size: 0.9rem;">untuk melanjutkan proses booking camping ground</p>
                                </div>
                            </div>
                            <div style="display: flex; gap: 0.75rem;">
                                <a href="{{ route('web.login') }}" class="btn" style="background: #3A5A40; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 8px; font-weight: 500; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem;">
                                    Login
                                </a>
                                <a href="{{ route('web.register') }}" class="btn" style="background: transparent; color: #3A5A40; border: 2px solid #3A5A40; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 8px; font-weight: 500; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem;">
                                    Daftar
                                </a>
                            </div>
                        </div>
                    @endauth

                    <div class="form-group">
                        <label class="form-label" for="participants">Jumlah Peserta</label>
                        <input type="number" name="participants" id="participants" class="form-input" 
                               value="{{ old('participants', 1) }}" min="1" max="10" required>
                        @error('participants')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Booking</label>
                        <div class="form-row">
                            <div>
                                <label class="form-label" style="font-size: 0.9rem; color: #666;" for="check_in">Check In</label>
                                <input type="datetime-local" name="check_in" id="check_in" class="form-input" 
                                       value="{{ old('check_in') }}" required>
                                @error('check_in')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" style="font-size: 0.9rem; color: #666;" for="check_out">Check Out</label>
                                <input type="datetime-local" name="check_out" id="check_out" class="form-input" 
                                       value="{{ old('check_out') }}" required>
                                @error('check_out')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Metode Pembayaran</label>
                        <div class="payment-methods">
                            <div class="payment-method selected" onclick="selectPayment(this, 'cash')">
                                <div class="payment-icon">
                                    <img src="{{ asset('images/cash.png') }}" alt="Cash">
                                </div>
                                <div class="payment-name">Cash</div>
                            </div>
                            <div class="payment-method" onclick="selectPayment(this, 'qris')">
                                <div class="payment-icon">
                                    <img src="{{ asset('images/qris_logo.png') }}" alt="QRIS">
                                </div>
                                <div class="payment-name">QRIS</div>
                            </div>
                            <div class="payment-method" onclick="selectPayment(this, 'bank_bni')">
                                <div class="payment-icon">
                                    <img src="{{ asset('images/bni_logo.png') }}" alt="BNI">
                                </div>
                                <div class="payment-name">Bank BNI</div>
                            </div>
                            <div class="payment-method" onclick="selectPayment(this, 'shopeepay')">
                                <div class="payment-icon">
                                    <img src="{{ asset('images/spay_logo.png') }}" alt="ShopeePay">
                                </div>
                                <div class="payment-name">ShopeePay</div>
                            </div>
                        </div>
                        <input type="hidden" name="payment_method" id="payment_method" value="cash" required>
                        @error('payment_method')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="special_requests">Permintaan Khusus (Opsional)</label>
                        <textarea name="special_requests" id="special_requests" class="form-input" 
                                  rows="3" placeholder="Masukkan permintaan khusus jika ada...">{{ old('special_requests') }}</textarea>
                        @error('special_requests')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hidden inputs for form submission -->
                    <input type="hidden" name="camping_plot_id" id="camping_plot_id" value="">
                </div>
            </form>

            <!-- Right Column - Order Summary -->
            <div class="order-summary">
                <!-- Detail Pesanan Section -->
                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                    <h3 class="summary-title">Detail Pesanan</h3>

                    <!-- Camping Ground & Kavling Info -->
                    <div class="summary-row" id="location-summary" style="display: none;">
                        <div class="order-detail-item">
                            <span class="detail-label">Camping Ground:</span>
                            <span class="detail-value" id="selected-camping-ground">-</span>
                        </div>
                    </div>

                    <div class="summary-row" id="kavling-summary" style="display: none;">
                        <div class="order-detail-item">
                            <span class="detail-label">Kavling:</span>
                            <span class="detail-value" id="selected-kavling-name">-</span>
                        </div>
                    </div>

                    <div class="summary-row" id="nights-summary" style="display: none;">
                        <div class="order-detail-item">
                            <span class="detail-label">Lama Menginap:</span>
                            <span class="detail-value" id="selected-nights">- malam</span>
                        </div>
                    </div>

                    <!-- Price Details -->
                    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #f0f0f0;">
                        <div class="summary-row" id="kavling-price-summary" style="display: none;">
                            <span class="item-name" id="kavling-price-label">Kavling (1 malam)</span>
                            <span class="item-price" id="kavling-price-amount">Rp 0</span>
                        </div>

                        <div id="addon-summary">
                            <!-- Add-on items will be dynamically added here -->
                        </div>

                        <div class="summary-row total">
                            <span class="item-name">Total</span>
                            <span class="item-price">Rp. <span id="total-price">0</span></span>
                        </div>
                    </div>

                    @auth
                        <button type="submit" class="continue-btn" form="booking-form">Lanjutkan Transaksi</button>
                    @else
                        <div class="continue-btn" style="background: #ccc; cursor: not-allowed;">
                            Login untuk Melanjutkan
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script>
        // Form validation state
        let validationErrors = {};
        let isValidating = false;

        // Validation rules
        const validationRules = {
            name: {
                required: true,
                minLength: 2,
                pattern: /^[a-zA-Z\s]+$/,
                message: 'Nama harus berisi minimal 2 karakter dan hanya huruf'
            },
            email: {
                required: true,
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: 'Format email tidak valid'
            },
            phone: {
                required: true,
                pattern: /^[\+]?[0-9]{10,15}$/,
                message: 'Nomor telepon harus berisi 10-15 digit'
            },
            participants: {
                required: true,
                min: 1,
                max: 10,
                message: 'Jumlah peserta harus antara 1-10 orang'
            },
            check_in: {
                required: true,
                custom: validateCheckIn,
                message: 'Tanggal check-in tidak valid'
            },
            check_out: {
                required: true,
                custom: validateCheckOut,
                message: 'Tanggal check-out harus setelah check-in'
            },
            camping_plot_id: {
                required: true,
                message: 'Pilih kavling terlebih dahulu'
            },
            payment_method: {
                required: true,
                message: 'Pilih metode pembayaran'
            }
        };

        // Custom validation functions
        function validateCheckIn(value) {
            if (!value) return false;
            const checkInDate = new Date(value);
            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            return checkInDate >= today;
        }

        function validateCheckOut(value) {
            if (!value) return false;
            const checkInValue = document.getElementById('check_in').value;
            if (!checkInValue) return false;
            
            const checkInDate = new Date(checkInValue);
            const checkOutDate = new Date(value);
            return checkOutDate > checkInDate;
        }

        // Validate individual field
        function validateField(fieldName, value, showError = true) {
            const rule = validationRules[fieldName];
            if (!rule) return true;

            let isValid = true;
            let errorMessage = '';

            // Required validation
            if (rule.required && (!value || value.trim() === '')) {
                isValid = false;
                errorMessage = 'Field ini wajib diisi';
            }

            // Pattern validation
            if (isValid && rule.pattern && value && !rule.pattern.test(value)) {
                isValid = false;
                errorMessage = rule.message;
            }

            // Min length validation
            if (isValid && rule.minLength && value && value.length < rule.minLength) {
                isValid = false;
                errorMessage = rule.message;
            }

            // Min/Max validation for numbers
            if (isValid && rule.min !== undefined && value && parseInt(value) < rule.min) {
                isValid = false;
                errorMessage = rule.message;
            }

            if (isValid && rule.max !== undefined && value && parseInt(value) > rule.max) {
                isValid = false;
                errorMessage = rule.message;
            }

            // Custom validation
            if (isValid && rule.custom && value && !rule.custom(value)) {
                isValid = false;
                errorMessage = rule.message;
            }

            // Update validation state
            if (isValid) {
                delete validationErrors[fieldName];
                if (showError) removeFieldError(fieldName);
            } else {
                validationErrors[fieldName] = errorMessage;
                if (showError) showFieldError(fieldName, errorMessage);
            }

            return isValid;
        }

        // Show field error
        function showFieldError(fieldName, message) {
            const field = document.getElementById(fieldName);
            if (!field) return;

            // Remove existing error
            removeFieldError(fieldName);

            // Add error styling
            field.style.borderColor = '#dc3545';
            field.style.backgroundColor = '#fff5f5';

            // Add error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.id = fieldName + '-error';
            errorDiv.textContent = message;

            // Insert error message after field
            field.parentNode.appendChild(errorDiv);
        }

        // Remove field error
        function removeFieldError(fieldName) {
            const field = document.getElementById(fieldName);
            if (!field) return;

            // Remove error styling
            field.style.borderColor = '#e9ecef';
            field.style.backgroundColor = '';

            // Remove error message
            const errorDiv = document.getElementById(fieldName + '-error');
            if (errorDiv) {
                errorDiv.remove();
            }
        }

        // Validate capacity against selected kavling
        function validateCapacity() {
            const participants = parseInt(document.getElementById('participants').value) || 0;
            
            if (selectedKavling && participants > selectedKavling.capacity) {
                showFieldError('participants', `Kavling ${selectedKavling.name} maksimal ${selectedKavling.capacity} orang`);
                return false;
            }
            
            removeFieldError('participants');
            return true;
        }

        // Validate all form fields
        function validateForm() {
            isValidating = true;
            let isFormValid = true;

            // Get form data
            const formData = {
                name: document.getElementById('name')?.value || '',
                email: document.getElementById('email')?.value || '',
                phone: document.getElementById('phone')?.value || '',
                participants: document.getElementById('participants')?.value || '',
                check_in: document.getElementById('check_in')?.value || '',
                check_out: document.getElementById('check_out')?.value || '',
                camping_plot_id: document.getElementById('camping_plot_id')?.value || '',
                payment_method: document.getElementById('payment_method')?.value || ''
            };

            // Validate each field
            Object.keys(formData).forEach(fieldName => {
                if (validationRules[fieldName]) {
                    const fieldValid = validateField(fieldName, formData[fieldName], true);
                    if (!fieldValid) isFormValid = false;
                }
            });

            // Additional capacity validation
            if (!validateCapacity()) {
                isFormValid = false;
            }

            // Check if kavling is selected
            if (!selectedKavling) {
                alert('Silakan pilih kavling terlebih dahulu');
                isFormValid = false;
            }

            // Check date range validity
            if (formData.check_in && formData.check_out) {
                const nights = calculateNights();
                if (nights < 1) {
                    showFieldError('check_out', 'Tanggal check-out harus setelah check-in');
                    isFormValid = false;
                }
            }

            isValidating = false;
            return isFormValid;
        }

        // Add real-time validation event listeners
        function initializeValidation() {
            // Add event listeners for form fields
            Object.keys(validationRules).forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (field) {
                    // Validate on blur
                    field.addEventListener('blur', function() {
                        if (!isValidating) {
                            validateField(fieldName, this.value, true);
                            if (fieldName === 'participants') {
                                validateCapacity();
                            }
                        }
                    });

                    // Clear errors on focus
                    field.addEventListener('focus', function() {
                        if (!isValidating) {
                            removeFieldError(fieldName);
                        }
                    });

                    // Real-time validation for some fields
                    if (['check_in', 'check_out', 'participants'].includes(fieldName)) {
                        field.addEventListener('input', function() {
                            if (!isValidating) {
                                setTimeout(() => {
                                    validateField(fieldName, this.value, true);
                                    if (fieldName === 'participants') {
                                        validateCapacity();
                                    }
                                    updateLocationSummary();
                                }, 300);
                            }
                        });
                    }
                }
            });

            // Form submission validation
            const form = document.getElementById('booking-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    if (validateForm()) {
                        // Show loading state
                        const submitButton = this.querySelector('button[type="submit"]');
                        if (submitButton) {
                            submitButton.disabled = true;
                            submitButton.textContent = 'Memproses...';
                        }
                        
                        // Submit form
                        this.submit();
                    } else {
                        // Scroll to first error
                        const firstError = document.querySelector('.error-message');
                        if (firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                });
            }
        }

        // Carousel functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            slides[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(currentSlide);
        }

        // Auto-advance carousel
        setInterval(nextSlide, 4000);

        // Initialize equipment tracking
        const equipmentData = {};
        @foreach($equipmentRentals as $categoryName => $equipmentItems)
            @foreach($equipmentItems as $equipment)
                equipmentData['equipment_{{ $equipment->id }}'] = {
                    name: '{{ $equipment->name }}',
                    price: {{ $equipment->price_per_day }},
                    id: {{ $equipment->id }},
                    quantity: 0
                };
            @endforeach
        @endforeach

        // Location and kavling tracking
        let selectedLocation = null;
        let selectedKavling = null;

            const locations = {
                @foreach($campingLocations as $location)
                    @php
                        // Calculate minimum kavling price for this location
                        $minKavlingPrice = $location->campingPlots->min('price_per_night') ?? $location->price_per_night;
                    @endphp
                    {{ $location->id }}: {
                        name: '{{ addslashes($location->name) }}',
                        price: {{ $minKavlingPrice }},
                        plots: {
                            @foreach($location->campingPlots as $plot)
                                {{ $plot->id }}: {
                                    name: '{{ addslashes($plot->name) }}',
                                    description: '{{ addslashes($plot->description) }}',
                                    price: {{ $plot->price_per_night }},
                                    capacity: {{ $plot->max_capacity }}
                                },
                            @endforeach
                        }
                    },
                @endforeach
            };

            // Location selection function
            function selectLocation(locationId) {
                selectedLocation = locations[locationId];
                
                // Hide all kavling sections
                document.querySelectorAll('.kavling-section').forEach(section => {
                    section.style.display = 'none';
                });
                
                // Show kavling section for selected location
                const kavlingSection = document.getElementById('kavling-section-' + locationId);
                if (kavlingSection) {
                    kavlingSection.style.display = 'block';
                    
                    // Auto-select first kavling in the location
                    const firstPlot = kavlingSection.querySelector('input[type="radio"]');
                    if (firstPlot) {
                        firstPlot.checked = true;
                        selectKavling(parseInt(firstPlot.value), locationId);
                    }
                }
            }

            // Kavling selection function
            function selectKavling(plotId, locationId) {
                if (locations[locationId] && locations[locationId].plots[plotId]) {
                    selectedKavling = {
                        id: plotId,
                        locationId: locationId,
                        ...locations[locationId].plots[plotId]
                    };
                    
                    updateLocationSummary();
                }
            }

            // Payment method selection function
            function selectPayment(element, method) {
                // Remove selected class from all payment methods
                const paymentMethods = document.querySelectorAll('.payment-method');
                paymentMethods.forEach(function(el) {
                    el.classList.remove('selected');
                });

                // Add selected class to clicked element
                element.classList.add('selected');

                // Update hidden form input for payment method
                const paymentInput = document.getElementById('payment_method');
                if (paymentInput) {
                    paymentInput.value = method;
                }

                // Remove any existing validation error
                removeFieldError('payment_method');

                // Add visual feedback animation
                element.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    element.style.transform = 'scale(1)';
                }, 150);

                // Show payment method confirmation
                showPaymentMethodFeedback(method);

                // Log for debugging
                console.log('Payment method selected:', method);
            }

            // Show feedback for selected payment method
            function showPaymentMethodFeedback(method) {
                const methodNames = {
                    'cash': 'Cash',
                    'qris': 'QRIS',
                    'bank_bni': 'Bank BNI',
                    'shopeepay': 'ShopeePay'
                };

                // Remove existing feedback
                const existingFeedback = document.querySelector('.payment-feedback');
                if (existingFeedback) {
                    existingFeedback.remove();
                }

                // Create new feedback element
                const feedback = document.createElement('div');
                feedback.className = 'payment-feedback';
                feedback.style.cssText = `
                    margin-top: 0.5rem;
                    padding: 0.5rem 1rem;
                    background: #e8f5e8;
                    color: #3A5A40;
                    border-radius: 6px;
                    font-size: 0.9rem;
                    font-weight: 500;
                    border: 1px solid #d4edda;
                    animation: fadeIn 0.3s ease-in;
                `;
                feedback.textContent = `✓ Metode pembayaran dipilih: ${methodNames[method]}`;

                // Insert feedback after payment methods
                const paymentMethodsContainer = document.querySelector('.payment-methods');
                paymentMethodsContainer.parentNode.insertBefore(feedback, paymentMethodsContainer.nextSibling);

                // Auto-remove feedback after 3 seconds
                setTimeout(() => {
                    if (feedback.parentNode) {
                        feedback.style.animation = 'fadeOut 0.3s ease-out';
                        setTimeout(() => feedback.remove(), 300);
                    }
                }, 3000);
            }

            // Initialize default payment method on page load
            function initializePaymentMethod() {
                const defaultPaymentMethod = document.querySelector('.payment-method.selected');
                if (defaultPaymentMethod) {
                    // Get method from onclick attribute
                    const onclickAttr = defaultPaymentMethod.getAttribute('onclick');
                    const methodMatch = onclickAttr.match(/'([^']+)'/);
                    if (methodMatch) {
                        document.getElementById('payment_method').value = methodMatch[1];
                    }
                } else {
                    // If no default selected, select the first one (cash)
                    const firstPaymentMethod = document.querySelector('.payment-method');
                    if (firstPaymentMethod) {
                        selectPayment(firstPaymentMethod, 'cash');
                    }
                }
            }

            // Add hover effects for payment methods
            function addPaymentMethodHoverEffects() {
                const paymentMethods = document.querySelectorAll('.payment-method');
                paymentMethods.forEach(method => {
                    method.addEventListener('mouseenter', function() {
                        if (!this.classList.contains('selected')) {
                            this.style.transform = 'translateY(-2px)';
                            this.style.boxShadow = '0 6px 20px rgba(58, 90, 64, 0.15)';
                        }
                    });

                    method.addEventListener('mouseleave', function() {
                        if (!this.classList.contains('selected')) {
                            this.style.transform = 'translateY(0)';
                            this.style.boxShadow = '';
                        }
                    });
                });
            }

            // Initialize first selections
            @if($campingLocations->count() > 0)
                @php $firstLocation = $campingLocations->first(); @endphp
                @if($firstLocation && is_object($firstLocation) && property_exists($firstLocation, 'id'))
                    selectLocation({{ $firstLocation->id }});
                @endif
            @endif

        function changeQuantity(item, delta) {
            if (equipmentData[item]) {
                equipmentData[item].quantity = Math.max(0, equipmentData[item].quantity + delta);
                document.getElementById(item + '-qty').textContent = equipmentData[item].quantity;
                document.getElementById(item + '-input').value = equipmentData[item].quantity;
                updateSummary();
            }
        }

        function updateLocationSummary() {
            if (selectedKavling) {
                // Show summary sections
                document.getElementById('location-summary').style.display = 'flex';
                document.getElementById('kavling-summary').style.display = 'flex';
                document.getElementById('nights-summary').style.display = 'flex';
                document.getElementById('kavling-price-summary').style.display = 'flex';
                
                // Update camping ground name
                const campingGroundName = selectedLocation ? selectedLocation.name : 'Unknown';
                document.getElementById('selected-camping-ground').textContent = campingGroundName;
                
                // Update kavling name
                document.getElementById('selected-kavling-name').textContent = selectedKavling.name;
                
                // Calculate and update nights
                const nights = calculateNights();
                document.getElementById('selected-nights').textContent = nights + ' malam';
                
                // Update kavling price info
                const totalKavlingPrice = selectedKavling.price * nights;
                document.getElementById('kavling-price-label').textContent = `${selectedKavling.name} (${nights} malam)`;
                document.getElementById('kavling-price-amount').textContent = 'Rp ' + totalKavlingPrice.toLocaleString('id-ID');
                
                // Update hidden form input
                const kavlingInput = document.getElementById('camping_plot_id');
                if (kavlingInput) {
                    kavlingInput.value = selectedKavling.id;
                }
            }
            updateSummary();
        }

        function calculateNights() {
            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');
            
            if (checkInInput && checkOutInput && checkInInput.value && checkOutInput.value) {
                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);
                const diffTime = Math.abs(checkOut - checkIn);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                return Math.max(1, diffDays); // Minimum 1 night
            }
            return 1; // Default to 1 night
        }

        function updateSummary() {
            const addonSummary = document.getElementById('addon-summary');
            addonSummary.innerHTML = '';

            // Calculate kavling total (price per night × number of nights)
            const nights = calculateNights();
            let total = selectedKavling ? (selectedKavling.price * nights) : 0;

            // Add equipment items to summary
            Object.keys(equipmentData).forEach(item => {
                const equipment = equipmentData[item];
                if (equipment.quantity > 0) {
                    const row = document.createElement('div');
                    row.className = 'summary-row';

                    const itemTotal = equipment.price * equipment.quantity;
                    total += itemTotal;

                    row.innerHTML = `
                        <span class="item-name">${equipment.name} x${equipment.quantity}</span>
                        <span class="item-price">Rp ${itemTotal.toLocaleString('id-ID')}</span>
                    `;
                    addonSummary.appendChild(row);
                }
            });

            document.getElementById('total-price').textContent = total.toLocaleString('id-ID');
        }

                // Set default dates and initialize validation
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const tomorrow = new Date(now);
            tomorrow.setDate(tomorrow.getDate() + 1);

            const formatDate = (date) => {
                return date.toISOString().slice(0, 16);
            };

            document.getElementById('check_in').value = formatDate(now);
            document.getElementById('check_out').value = formatDate(tomorrow);

            // Initialize form validation
            initializeValidation();

            // Initialize payment method selection
            initializePaymentMethod();

            // Add payment method hover effects
            addPaymentMethodHoverEffects();

            // Add event listeners to date inputs to update summary when dates change
            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');
            
            if (checkInInput) {
                checkInInput.addEventListener('change', function() {
                    if (selectedKavling) {
                        updateLocationSummary();
                    }
                });
            }
            
            if (checkOutInput) {
                checkOutInput.addEventListener('change', function() {
                    if (selectedKavling) {
                        updateLocationSummary();
                    }
                });
            }

            // Add keyboard support for payment methods
            const paymentMethods = document.querySelectorAll('.payment-method');
            paymentMethods.forEach((method, index) => {
                method.setAttribute('tabindex', '0');
                method.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });
        });

        // Header background on scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>
