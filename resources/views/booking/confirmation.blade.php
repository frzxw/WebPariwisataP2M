<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Booking</title>

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
            max-width: 900px;
            margin: 0 auto;
        }

        .confirmation-card {
            background: white;
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .success-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 2rem;
        }

        .success-title {
            font-size: 2rem;
            color: #3A5A40;
            margin-bottom: 0.5rem;
        }

        .booking-code {
            font-size: 1.2rem;
            color: #666;
            font-weight: 600;
            background: #f8f9fa;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            display: inline-block;
        }

        .detail-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.3rem;
            color: #3A5A40;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .detail-item {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
        }

        .detail-label {
            font-size: 0.9rem;
            color: #666;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-size: 1rem;
            color: #333;
            font-weight: 600;
        }

        .equipment-list {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
        }

        .equipment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .equipment-item:last-child {
            border-bottom: none;
        }

        .equipment-name {
            font-weight: 500;
        }

        .equipment-details {
            font-size: 0.9rem;
            color: #666;
        }

        .equipment-price {
            font-weight: 600;
            color: #3A5A40;
        }

        .pricing-summary {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .price-row.total {
            border-top: 2px solid #3A5A40;
            padding-top: 1rem;
            margin-top: 1rem;
            font-size: 1.2rem;
            font-weight: 600;
            color: #3A5A40;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-primary {
            background: #3A5A40;
            color: white;
        }

        .btn-primary:hover {
            background: #2d4530;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
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

            .confirmation-card {
                padding: 2rem 1.5rem;
            }

            .success-title {
                font-size: 1.5rem;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
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
            <div class="confirmation-card">
                <!-- Success Header -->
                <div class="success-header">
                    <div class="success-icon">✓</div>
                    <h1 class="success-title">Booking Berhasil Dibuat!</h1>
                    <div class="booking-code">Kode Booking: {{ $booking->booking_code }}</div>
                </div>

                <!-- Info Alert -->
                <div class="alert alert-info">
                    <strong>Langkah Selanjutnya:</strong> Silakan lakukan pembayaran untuk mengkonfirmasi booking Anda. 
                    Pesanan akan otomatis dibatalkan jika pembayaran tidak dilakukan dalam 24 jam.
                </div>

                <!-- Booking Details -->
                <div class="detail-section">
                    <h2 class="section-title">Detail Booking</h2>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Camping Ground</div>
                            <div class="detail-value">{{ $booking->facility->name }}</div>
                        </div>
                        
                        @if($campingPlot)
                        <div class="detail-item">
                            <div class="detail-label">Kavling</div>
                            <div class="detail-value">{{ $campingPlot->name }}</div>
                        </div>
                        @endif

                        <div class="detail-item">
                            <div class="detail-label">Tanggal Check-in</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->format('d F Y, H:i') }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Tanggal Check-out</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($booking->check_out)->format('d F Y, H:i') }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Lama Menginap</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} malam</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Jumlah Peserta</div>
                            <div class="detail-value">{{ $booking->guests }} orang</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Status Booking</div>
                            <div class="detail-value">
                                <span class="status-badge status-pending">{{ ucfirst($booking->booking_status) }}</span>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Status Pembayaran</div>
                            <div class="detail-value">
                                <span class="status-badge status-pending">Menunggu Pembayaran</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                @if(isset($bookingDetails['contact_name']))
                <div class="detail-section">
                    <h2 class="section-title">Informasi Kontak</h2>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Nama</div>
                            <div class="detail-value">{{ $bookingDetails['contact_name'] }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">{{ $bookingDetails['contact_email'] }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Nomor Telepon</div>
                            <div class="detail-value">{{ $bookingDetails['contact_phone'] }}</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Equipment Rentals -->
                @if($equipmentRentals->count() > 0)
                <div class="detail-section">
                    <h2 class="section-title">Add-Ons / Perlengkapan</h2>
                    <div class="equipment-list">
                        @foreach($equipmentRentals as $rental)
                        <div class="equipment-item">
                            <div>
                                <div class="equipment-name">{{ $rental->equipment->name ?? 'Equipment' }}</div>
                                <div class="equipment-details">Quantity: {{ $rental->quantity }} × Rp {{ number_format($rental->price_per_unit, 0, ',', '.') }}</div>
                            </div>
                            <div class="equipment-price">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Pricing Summary -->
                <div class="detail-section">
                    <h2 class="section-title">Ringkasan Harga</h2>
                    <div class="pricing-summary">
                        @if(isset($bookingDetails['base_cost']))
                        <div class="price-row">
                            <span>Biaya Kavling ({{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} malam)</span>
                            <span>Rp {{ number_format($bookingDetails['base_cost'], 0, ',', '.') }}</span>
                        </div>
                        @endif

                        @if(isset($bookingDetails['equipment_cost']) && $bookingDetails['equipment_cost'] > 0)
                        <div class="price-row">
                            <span>Biaya Add-Ons</span>
                            <span>Rp {{ number_format($bookingDetails['equipment_cost'], 0, ',', '.') }}</span>
                        </div>
                        @endif

                        <div class="price-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="price-row">
                            <span>Pajak (11%)</span>
                            <span>Rp {{ number_format($booking->tax_amount, 0, ',', '.') }}</span>
                        </div>

                        <div class="price-row total">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Special Requests -->
                @if($booking->special_requests)
                <div class="detail-section">
                    <h2 class="section-title">Permintaan Khusus</h2>
                    <div class="detail-item">
                        <div class="detail-value">{{ $booking->special_requests }}</div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('web.booking.payment', $booking->booking_code) }}" class="btn btn-primary">
                        Lakukan Pembayaran
                    </a>
                    <a href="{{ route('web.transaction') }}" class="btn btn-secondary">
                        Lihat Semua Transaksi
                    </a>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
