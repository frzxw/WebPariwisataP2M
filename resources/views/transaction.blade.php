<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Transaksi</title>

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
        }

        .page-header {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            text-align: center;
        }

        .page-title {
            font-size: 2rem;
            color: #3A5A40;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #666;
            font-size: 1.1rem;
        }

        .transaction-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .transaction-item {
            border: 2px solid #f1f3f4;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s;
        }

        .transaction-item:hover {
            border-color: #3A5A40;
            box-shadow: 0 4px 12px rgba(58, 90, 64, 0.1);
        }

        .transaction-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .booking-info h3 {
            font-size: 1.2rem;
            color: #3A5A40;
            margin-bottom: 0.25rem;
        }

        .booking-code {
            font-size: 0.9rem;
            color: #666;
            font-family: monospace;
            background: #f8f9fa;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
        }

        .status-badges {
            display: flex;
            gap: 0.5rem;
            flex-direction: column;
            align-items: flex-end;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-paid {
            background: #d4edda;
            color: #155724;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
        }

        .status-confirmed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .transaction-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
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

        .transaction-addons {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .addon-title {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .addon-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .addon-item {
            background: white;
            padding: 0.5rem;
            border-radius: 6px;
            font-size: 0.85rem;
            color: #333;
            border: 1px solid #e9ecef;
        }

        .transaction-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #3A5A40;
            color: white;
        }

        .btn-primary:hover {
            background: #2d4530;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-outline {
            background: transparent;
            color: #3A5A40;
            border: 2px solid #3A5A40;
        }

        .btn-outline:hover {
            background: #3A5A40;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .empty-subtitle {
            margin-bottom: 2rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .transaction-card {
                padding: 1.5rem;
            }

            .transaction-header {
                flex-direction: column;
                gap: 1rem;
            }

            .status-badges {
                align-items: flex-start;
                flex-direction: row;
            }

            .transaction-details {
                grid-template-columns: 1fr;
            }

            .transaction-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="main-content">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Riwayat Transaksi</h1>
                <p class="page-subtitle">Kelola dan pantau semua booking Anda</p>
            </div>

            <!-- Success/Info Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('message'))
                <div class="alert alert-info">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Transactions List -->
            <div class="transaction-card">
                @if($bookings->count() > 0)
                    @foreach($bookings as $booking)
                        <div class="transaction-item">
                            <!-- Transaction Header -->
                            <div class="transaction-header">
                                <div class="booking-info">
                                    <h3>{{ $booking->facility->name ?? 'Camping Ground' }}</h3>
                                    <div class="booking-code">{{ $booking->booking_code }}</div>
                                </div>
                                <div class="status-badges">
                                    <span class="status-badge status-{{ $booking->payment_status }}">
                                        @if($booking->payment_status === 'pending')
                                            Menunggu Pembayaran
                                        @elseif($booking->payment_status === 'paid')
                                            Lunas
                                        @else
                                            {{ ucfirst($booking->payment_status) }}
                                        @endif
                                    </span>
                                    <span class="status-badge status-{{ $booking->booking_status }}">
                                        @if($booking->booking_status === 'pending')
                                            Menunggu Konfirmasi
                                        @elseif($booking->booking_status === 'confirmed')
                                            Dikonfirmasi
                                        @else
                                            {{ ucfirst($booking->booking_status) }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Transaction Details -->
                            <div class="transaction-details">
                                <div class="detail-item">
                                    <span class="detail-label">Check-in</span>
                                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Check-out</span>
                                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Durasi</span>
                                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} malam</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Peserta</span>
                                    <span class="detail-value">{{ $booking->guests }} orang</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Total Pembayaran</span>
                                    <span class="detail-value">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Tanggal Booking</span>
                                    <span class="detail-value">{{ $booking->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>

                            <!-- Add-ons -->
                            @if($booking->addons->count() > 0)
                                <div class="transaction-addons">
                                    <div class="addon-title">Add-Ons / Perlengkapan:</div>
                                    <div class="addon-list">
                                        @foreach($booking->addons as $addon)
                                            <div class="addon-item">
                                                {{ $addon->equipment->name ?? 'Equipment' }} ({{ $addon->quantity }}x)
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="transaction-actions">
                                @if($booking->payment_status === 'pending')
                                    <a href="{{ route('web.booking.payment', $booking->booking_code) }}" class="btn btn-primary">
                                        Bayar Sekarang
                                    </a>
                                @endif
                                
                                <a href="{{ route('web.booking.confirmation', $booking->booking_code) }}" class="btn btn-outline">
                                    Lihat Detail
                                </a>

                                @if($booking->booking_status === 'confirmed' && $booking->check_out < now())
                                    <button class="btn btn-secondary" onclick="alert('Fitur review akan segera tersedia')">
                                        Beri Review
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div style="display: flex; justify-content: center; margin-top: 2rem;">
                        {{ $bookings->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <div class="empty-icon">-</div>
                        <h3 class="empty-title">Belum Ada Transaksi</h3>
                        <p class="empty-subtitle">Anda belum memiliki riwayat booking. Mari mulai petualangan camping Anda!</p>
                        <a href="{{ route('web.booking') }}" class="btn btn-primary">Mulai Booking</a>
                    </div>
                @endif
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
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
                                        <span class="info-value">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Check-out</span>
                                        <span class="info-value">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Durasi</span>
                                        <span class="info-value">{{ $booking->duration }} hari</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary Card -->
                            <div class="order-summary-card">
                                <h4>Ringkasan Pesanan</h4>
                                
                                <!-- Location -->
                                <div class="summary-table-header">
                                    <span class="col-category">Lokasi</span>
                                    <span class="col-name bold">{{ $booking->facility->name }}</span>
                                    <span class="col-price">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                                </div>

                                <!-- Equipment Rentals -->
                                @if($booking->addons && $booking->addons->count() > 0)
                                    @foreach($booking->addons as $addon)
                                        <div class="summary-table-row">
                                            <span class="col-category">Peralatan</span>
                                            <span class="col-name">{{ $addon->equipment->name }} x{{ $addon->quantity }}</span>
                                            <span class="col-price">Rp {{ number_format($addon->total_price, 0, ',', '.') }}</span>
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
