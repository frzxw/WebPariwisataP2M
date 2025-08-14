<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Akun Saya - Web Pariwisata</title>

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
            border-radius: 8px;
            margin-bottom: 1rem;
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

        /* Account Cards */
        .account-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .account-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.5rem;
            color: #3A5A40;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .profile-info {
            display: grid;
            gap: 1rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-label {
            font-weight: 500;
            color: #666;
        }

        .info-value {
            font-weight: 600;
            color: #333;
        }

        /* Recent Bookings */
        .booking-item {
            padding: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .booking-title {
            font-weight: 600;
            color: #3A5A40;
        }

        .booking-status {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
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

        .booking-details {
            color: #666;
            font-size: 0.9rem;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #3A5A40;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #2d4032;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-secondary:hover {
            background: #545b62;
        }

        /* No Auth Message */
        .no-auth-message {
            text-align: center;
            background: white;
            border-radius: 15px;
            padding: 3rem 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .no-auth-message h2 {
            color: #3A5A40;
            margin-bottom: 1rem;
        }

        .no-auth-message p {
            color: #666;
            margin-bottom: 2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .account-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .container {
                padding: 0 1rem;
            }

            .booking-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    @include('partials.header')

    <main class="main-content">
        <div class="container">
            <h1 class="page-title">Akun Saya</h1>

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
                    <p>Anda perlu login untuk melihat informasi akun.</p>
                    <a href="{{ route('web.login') }}" class="btn">Login Sekarang</a>
                </div>
            @else
                <div class="account-grid">
                    <!-- Profile Information -->
                    <div class="account-card">
                        <h2 class="card-title">Informasi Profil</h2>
                        <div class="profile-info">
                            <div class="info-row">
                                <span class="info-label">Nama Lengkap:</span>
                                <span class="info-value">{{ $user->name }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email:</span>
                                <span class="info-value">{{ $user->email }}</span>
                            </div>
                            @if($user->phone)
                                <div class="info-row">
                                    <span class="info-label">Nomor Telepon:</span>
                                    <span class="info-value">{{ $user->phone }}</span>
                                </div>
                            @endif
                            <div class="info-row">
                                <span class="info-label">Bergabung Sejak:</span>
                                <span class="info-value">{{ $user->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        
                        <div style="margin-top: 2rem; text-align: center;">
                            <button class="btn btn-secondary" onclick="alert('Fitur edit profil akan segera tersedia!')">
                                Edit Profil
                            </button>
                        </div>
                    </div>

                    <!-- Account Actions -->
                    <div class="account-card">
                        <h2 class="card-title">Menu Akun</h2>
                        <div style="display: grid; gap: 1rem;">
                            <a href="{{ route('web.booking') }}" class="btn">
                                Buat Reservasi Baru
                            </a>
                            <a href="{{ route('web.transaction') }}" class="btn btn-secondary">
                                Lihat Riwayat Transaksi
                            </a>
                            <form method="POST" action="{{ route('web.logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn btn-secondary" style="width: 100%;">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @if(isset($recentBookings) && $recentBookings->count() > 0)
                    <div class="account-card">
                        <h2 class="card-title">Reservasi Terbaru</h2>
                        @foreach($recentBookings as $booking)
                            <div class="booking-item">
                                <div class="booking-header">
                                    <span class="booking-title">{{ $booking->booking_code }}</span>
                                    <span class="booking-status status-{{ $booking->status }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <div class="booking-details">
                                    <strong>{{ $booking->campingLocation->name }}</strong><br>
                                    {{ $booking->check_in_date }} s/d {{ $booking->check_out_date }}<br>
                                    {{ $booking->participants_count }} peserta - 
                                    Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                        
                        <div style="text-align: center; margin-top: 1rem;">
                            <a href="{{ route('web.transaction') }}" class="btn btn-secondary">
                                Lihat Semua Transaksi
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
