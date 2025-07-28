<!-- Header Styles -->
<style>
    /* Header */
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 1rem 2rem;
        z-index: 1000;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    }

    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
    }

    .logo {
        font-size: 1.5rem;
        font-weight: bold;
        color: #2d5016;
    }

    .logo img {
        height: 40px;
        width: auto;
    }

    .nav-links {
        display: flex;
        list-style: none;
        gap: 2rem;
        margin-left: auto;
        margin-right: 2rem;
    }

    .nav-links a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
        transition: color 0.3s;
    }

    .nav-links a:hover,
    .nav-links a.active {
        color: #2d5016;
    }

    .nav-links a.btn-primary {
        color: white !important;
    }

    .nav-links a.btn-primary:hover {
        color: white !important;
    }

    .auth-links {
        display: flex;
        gap: 1rem;
    }

    .btn {
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
    }

    .btn-outline {
        border: 2px solid #3A5A40;
        color: #3A5A40;
        background: transparent;
    }

    .btn-primary {
        background: #3A5A40;
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .nav-links {
            display: none;
        }
    }
</style>

<!-- Header -->
<header class="header">
    <nav class="nav">
        <div class="logo">
            <img src="{{ asset('images/admin/logo-upi.webp') }}" alt="UPI Logo">
        </div>
        <ul class="nav-links">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About Us</a></li>
            <li><a href="{{ url('/transaction') }}" class="{{ request()->is('transaction') ? 'active' : '' }}">Transaksi</a></li>
            <li><a href="{{ url('/') }}">Akun</a></li>
            <li><a href="{{ url('/booking') }}" class="btn btn-primary reservasi-btn {{ request()->is('booking') ? 'active' : '' }}">Reservasi</a></li>
        </ul>
        <div class="auth-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ url('/admin/login') }}" class="btn btn-outline">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ url('/booking') }}" class="btn btn-primary">Reservasi</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>
</header>

<script>
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
