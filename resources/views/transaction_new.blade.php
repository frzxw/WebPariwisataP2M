<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Transaksi - Web Pariwisata</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Vite CSS & JS Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            background-color: #f8f9fa;
        }

        /* Main Content */
        .main-content {
            margin-top: 80px;
            padding: 2rem 0;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .page-title {
            font-size: 2rem;
            color: #333;
            margin: 2rem 0;
            font-weight: 600;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* No Auth Message */
        .no-auth-message, .no-bookings {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            margin-top: 1rem;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #3A5A40;
            color: white;
        }

        .btn-primary:hover {
            background: #2d4532;
        }

        /* Booking Card */
        .booking-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .booking-id h3 {
            color: #3A5A40;
            margin-bottom: 0.5rem;
        }

        .booking-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .booking-date {
            color: #666;
            font-size: 0.9rem;
        }

        /* Order Details Section */
        .order-cards-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .order-details, .order-summary-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
        }

        .order-details h4, .order-summary-card h4 {
            margin-bottom: 1rem;
            color: #3A5A40;
        }

        .order-info {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }

        .info-label {
            color: #666;
            font-weight: 500;
        }

        .info-value {
            font-weight: 600;
            color: #333;
        }

        .summary-table-header, .summary-table-row {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 1rem;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .summary-table-header {
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 0.5rem;
        }

        .summary-table-total {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 1rem;
            align-items: center;
            padding: 0.75rem 0;
            border-top: 2px solid #2d5016;
            margin-top: 1rem;
            padding-top: 1rem;
            font-weight: bold;
            color: #2d5016;
        }

        .col-category {
            color: #666;
            font-weight: 500;
            text-align: left;
        }

        .col-name {
            color: #333;
            font-weight: 500;
            text-align: center;
        }

        .col-price {
            color: #333;
            font-weight: 600;
            text-align: right;
        }

        .col-name.bold {
            font-weight: bold;
        }

        /* Special Requests */
        .special-requests {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .special-requests h5 {
            color: #3A5A40;
            margin-bottom: 0.5rem;
        }

        .special-requests p {
            color: #666;
            font-style: italic;
        }

        /* Payment Method Section */
        .payment-section {
            background: #fff3cd;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .payment-section h4 {
            color: #856404;
            margin-bottom: 1rem;
        }

        .payment-info {
            margin-top: 1rem;
        }

        .payment-info h5 {
            color: #856404;
            margin-bottom: 0.5rem;
        }

        .payment-info p {
            margin-bottom: 0.25rem;
            color: #333;
        }

        /* Pagination */
        .pagination-wrapper {
            margin-top: 2rem;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .order-cards-container {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .booking-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .summary-table-header, .summary-table-row, .summary-table-total {
                grid-template-columns: 1fr;
                text-align: left;
            }

            .col-name, .col-price {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    @include('partials.header')

    <main class="main-content">
        <div class="container">
            <h1 class="page-title">Riwayat Transaksi</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if(!Auth::check())
                <div class="no-auth-message">
                    <h2>Silakan Login</h2>
                    <p>Anda perlu login untuk melihat riwayat transaksi.</p>
                    <a href="{{ route('web.login') }}" class="btn btn-primary">Login Sekarang</a>
                </div>
            @elseif($bookings->count() > 0)
                @foreach($bookings as $booking)
                    <div class="booking-card">
                        <div class="booking-header">
                            <div class="booking-id">
                                <h3>{{ $booking->booking_code }}</h3>
                                <span class="booking-status status-{{ $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                            <div class="booking-date">
                                {{ $booking->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>

                        <div class="order-cards-container">
                            <!-- Booking Information Card -->
                            <div class="order-details">
                                <h4>Informasi Booking</h4>
                                <div class="order-info">
                                    <div class="info-row">
                                        <span class="info-label">Nama Pemesan</span>
                                        <span class="info-value">{{ $booking->name }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Email</span>
                                        <span class="info-value">{{ $booking->email }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Telepon</span>
                                        <span class="info-value">{{ $booking->phone }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Jumlah Peserta</span>
                                        <span class="info-value">{{ $booking->participants_count }} orang</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Check-in</span>
                                        <span class="info-value">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Check-out</span>
                                        <span class="info-value">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Durasi</span>
                                        <span class="info-value">{{ $booking->total_days }} hari</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary Card -->
                            <div class="order-summary-card">
                                <h4>Ringkasan Pesanan</h4>
                                
                                <!-- Location -->
                                <div class="summary-table-header">
                                    <span class="col-category">Lokasi</span>
                                    <span class="col-name bold">{{ $booking->campingLocation->name }}</span>
                                    <span class="col-price">Rp {{ number_format($booking->base_price, 0, ',', '.') }}</span>
                                </div>

                                <!-- Equipment Rentals -->
                                @if($booking->equipmentRentals && $booking->equipmentRentals->count() > 0)
                                    @foreach($booking->equipmentRentals as $equipment)
                                        <div class="summary-table-row">
                                            <span class="col-category">Peralatan</span>
                                            <span class="col-name">{{ $equipment->equipmentRental->name }} x{{ $equipment->quantity }}</span>
                                            <span class="col-price">Rp {{ number_format($equipment->price_per_day * $equipment->quantity * $booking->total_days, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                @endif

                                <!-- Total -->
                                <div class="summary-table-total">
                                    <span class="col-category">Total</span>
                                    <span class="col-name bold">TOTAL PEMBAYARAN</span>
                                    <span class="col-price">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                                </div>

                                @if($booking->special_requests)
                                    <div class="special-requests">
                                        <h5>Permintaan Khusus:</h5>
                                        <p>{{ $booking->special_requests }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($booking->status === 'pending')
                            <div class="payment-section">
                                <h4>Informasi Pembayaran</h4>
                                <p>Silakan lakukan pembayaran untuk mengkonfirmasi booking Anda.</p>
                                <div class="payment-info">
                                    <h5>Transfer ke:</h5>
                                    <p><strong>Bank BNI</strong></p>
                                    <p>No. Rekening: <strong>1406976531</strong></p>
                                    <p>Atas Nama: <strong>Yattaqi Ahmad Faza</strong></p>
                                    <p>Jumlah: <strong>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</strong></p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="no-bookings">
                    <h2>Belum Ada Transaksi</h2>
                    <p>Anda belum memiliki riwayat transaksi. Silakan buat booking pertama Anda!</p>
                    <a href="{{ route('web.booking') }}" class="btn btn-primary">Buat Booking</a>
                </div>
            @endif
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
