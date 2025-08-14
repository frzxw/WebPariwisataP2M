<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akun Saya</title>

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
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
        }

        .account-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .profile-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #3A5A40;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem;
            font-weight: bold;
        }

        .profile-name {
            font-size: 1.5rem;
            color: #3A5A40;
            margin-bottom: 0.5rem;
        }

        .profile-email {
            color: #666;
            font-size: 0.9rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-item {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #3A5A40;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #666;
        }

        .menu-list {
            list-style: none;
        }

        .menu-item {
            margin-bottom: 0.5rem;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 1rem;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .menu-link:hover {
            background: #f8f9fa;
            color: #3A5A40;
        }

        .menu-icon {
            margin-right: 1rem;
            font-size: 1.1rem;
        }

        .content-section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.5rem;
            color: #3A5A40;
            margin-bottom: 1.5rem;
        }

        .booking-item {
            border: 2px solid #f1f3f4;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s;
        }

        .booking-item:hover {
            border-color: #3A5A40;
            box-shadow: 0 4px 12px rgba(58, 90, 64, 0.1);
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .booking-info h4 {
            font-size: 1.1rem;
            color: #3A5A40;
            margin-bottom: 0.25rem;
        }

        .booking-code {
            font-size: 0.85rem;
            color: #666;
            font-family: monospace;
            background: #f8f9fa;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
        }

        .booking-status {
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

        .status-confirmed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-label {
            font-size: 0.8rem;
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            font-size: 0.9rem;
            color: #333;
            font-weight: 600;
        }

        .booking-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            font-size: 0.85rem;
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
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #3A5A40;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
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

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 1rem;
                padding: 1rem;
            }

            .main-content {
                padding: 1rem;
            }

            .account-card, .content-section {
                padding: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .booking-header {
                flex-direction: column;
                gap: 1rem;
            }

            .booking-details {
                grid-template-columns: 1fr;
            }

            .booking-actions {
                justify-content: flex-start;
                flex-wrap: wrap;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="main-content">
        <div class="container">
            <!-- Left Sidebar - Account Info -->
            <div class="account-card">
                <!-- Profile Section -->
                <div class="profile-section">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <p class="profile-email">{{ $user->email }}</p>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">{{ $totalBookings }}</div>
                        <div class="stat-label">Total Booking</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                        <div class="stat-label">Total Pengeluaran</div>
                    </div>
                </div>

                <!-- Menu List -->
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="#profile" class="menu-link" onclick="showSection('profile')">
                            <span class="menu-icon">•</span>
                            Profil Saya
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#bookings" class="menu-link" onclick="showSection('bookings')">
                            <span class="menu-icon">•</span>
                            Booking Terbaru
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('web.transaction') }}" class="menu-link">
                            <span class="menu-icon">•</span>
                            Riwayat Transaksi
                        </a>
                    </li>
                    <li class="menu-item">
                        <form action="{{ route('web.logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="menu-link" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                                <span class="menu-icon">→</span>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- Right Content -->
            <div class="content-section">
                <!-- Profile Section -->
                <div id="profile-section">
                    <h2 class="section-title">Informasi Profil</h2>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-error">
                            <ul style="margin: 0; padding-left: 1rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('web.account.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" 
                                       value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="phone">Nomor Telepon</label>
                                <input type="tel" name="phone" id="phone" class="form-control" 
                                       value="{{ old('phone', $user->phone ?? '') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="address">Alamat</label>
                            <textarea name="address" id="address" class="form-control" rows="3">{{ old('address', $user->address ?? '') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="current_password">Password Saat Ini (kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="current_password" id="current_password" class="form-control">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="password">Password Baru</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>

                <!-- Recent Bookings Section -->
                <div id="bookings-section" style="display: none;">
                    <h2 class="section-title">Booking Terbaru</h2>
                    
                    @if($recentBookings->count() > 0)
                        @foreach($recentBookings as $booking)
                            <div class="booking-item">
                                <div class="booking-header">
                                    <div class="booking-info">
                                        <h4>{{ $booking->facility->name ?? 'Camping Ground' }}</h4>
                                        <div class="booking-code">{{ $booking->booking_code }}</div>
                                    </div>
                                    <span class="booking-status status-{{ $booking->payment_status }}">
                                        @if($booking->payment_status === 'pending')
                                            Menunggu Pembayaran
                                        @elseif($booking->payment_status === 'paid')
                                            Lunas
                                        @else
                                            {{ ucfirst($booking->payment_status) }}
                                        @endif
                                    </span>
                                </div>

                                <div class="booking-details">
                                    <div class="detail-item">
                                        <span class="detail-label">Check-in</span>
                                        <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Check-out</span>
                                        <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Peserta</span>
                                        <span class="detail-value">{{ $booking->guests }} orang</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Total</span>
                                        <span class="detail-value">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="booking-actions">
                                    @if($booking->payment_status === 'pending')
                                        <a href="{{ route('web.booking.payment', $booking->booking_code) }}" class="btn btn-primary">
                                            Bayar
                                        </a>
                                    @endif
                                    <a href="{{ route('web.booking.confirmation', $booking->booking_code) }}" class="btn btn-outline">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach

                        <div style="text-align: center; margin-top: 2rem;">
                            <a href="{{ route('web.transaction') }}" class="btn btn-outline">
                                Lihat Semua Transaksi
                            </a>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">-</div>
                            <h3 class="empty-title">Belum Ada Booking</h3>
                            <p>Anda belum memiliki riwayat booking.</p>
                            <div style="margin-top: 1rem;">
                                <a href="{{ route('web.booking') }}" class="btn btn-primary">Mulai Booking</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script>
        function showSection(section) {
            // Hide all sections
            document.getElementById('profile-section').style.display = 'none';
            document.getElementById('bookings-section').style.display = 'none';
            
            // Show selected section
            if (section === 'profile') {
                document.getElementById('profile-section').style.display = 'block';
            } else if (section === 'bookings') {
                document.getElementById('bookings-section').style.display = 'block';
            }
            
            // Update active menu
            document.querySelectorAll('.menu-link').forEach(link => {
                link.style.background = '';
                link.style.color = '';
            });
            event.target.style.background = '#f8f9fa';
            event.target.style.color = '#3A5A40';
        }

        // Show bookings section by default if there's a hash
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash;
            if (hash === '#bookings') {
                showSection('bookings');
            }
        });
    </script>
</body>
</html>
