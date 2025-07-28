<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami</title>

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
            background-color: #f8f9fa;
        }

        /* Main Content */
        .main-content {
            margin-top: 80px;
            padding: 2rem 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .page-title {
            text-align: center;
            font-size: 2.5rem;
            color: #3A5A40;
            margin: 2rem 0;
            font-weight: 600;
        }

        /* Hero Section */
        .hero-section {
            margin-bottom: 3rem;
        }

        .hero-image {
            width: 100%;
            height: 300px;
            background: url('{{ asset('images/background.png') }}') center/cover;
            position: relative;
            border-radius: 15px;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to right, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.1) 50%, rgba(45,80,22,0.6) 100%);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 2rem;
            border-radius: 15px;
        }

        .plant-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .hero-content {
            padding: 2rem 0;
        }

        .hero-description {
            font-size: 1rem;
            line-height: 1.8;
            color: #666;
            text-align: justify;
        }

        /* Tourism Sections */
        .tourism-section {
            margin-bottom: 4rem;
        }

        .tourism-content {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
            align-items: center;
        }

        .tourism-image {
            width: 100%;
            height: 250px;
            background-size: cover;
            background-position: center;
            border-radius: 15px;
        }

        .tourism-text {
            padding: 0;
        }

        .tourism-title {
            font-size: 1.5rem;
            color: #3A5A40;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .tourism-description {
            font-size: 0.95rem;
            line-height: 1.8;
            color: #666;
            text-align: justify;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .tourism-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .tourism-image {
                height: 200px;
            }

            .page-title {
                font-size: 2rem;
            }

            .hero-content {
                padding: 1.5rem 0;
            }
        }
    </style>
</head>
<body>
    @include('partials.header')

    <main class="main-content">
        <div class="container">
            <h1 class="page-title">Tentang Kami</h1>

            <!-- Hero Section -->
            <div class="hero-section">
                <div class="hero-image">
                </div>
                <div class="hero-content">
                    <p class="hero-description">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet congue felis. Sed risus turpis, convallis in porttitor sed, euismod a tellus. Phasellus laoreet ac diam et tempor. Nam pretium tempus accumsan. Aenean id risus ex. Donec lobortis nisl nec tellus suscipit, quis finibus diam consectetur ut tellus. Phasellus laoreet ac diam et tempor. Nam pretium tempus accumsan. Aenean id risus ex. Donec lobortis nisl nec tellus suscipit, quis finibus diam molestie massa est vel nisl. Nullam luctus ex vel odio cursus, vitae feugiat nisl pretium. Curabitur fermentum justo elit. Mauris fringilla sem ultrices, euismod tellus in, molestie cursus est vel nisl. Nullam luctus ex vel odio cursus, vitae feugiat nisl pretium. Sed fermentum libero. Sed fermentum urna leo, ac pulvinar justo rhoncus in. Quisque vel tempor libero. Sed fermentum urna leo, ac pulvinar justo rhoncus in. Quisque non nibh et risus pretium consequat eu ut turpis. Curabitur volutpat finibus ultricies. Integer nec accumsan mauris, vitae mattis nibh.
                    </p>
                </div>
            </div>

            <!-- Tourism Sections -->
            <div class="tourism-section">
                <div class="tourism-content">
                    <div class="tourism-image" style="background-image: url('https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-4.0.3&auto=format&fit=crop&w=869&q=80')"></div>
                    <div class="tourism-text">
                        <h3 class="tourism-title">Wisata 1</h3>
                        <p class="tourism-description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet congue felis. Sed risus turpis, convallis in porttitor sed, euismod a tellus. Phasellus laoreet ac diam et tempor. Nam pretium tempus accumsan. Aenean id risus ex. Donec lobortis nisl nec tellus suscipit, quis finibus diam consectetur ut tellus. Phasellus laoreet ac diam et tempor. Nam pretium tempus accumsan. Aenean id risus ex. Donec lobortis nisl nec tellus suscipit, quis finibus diam molestie massa est vel nisl. Nullam luctus ex vel odio cursus, vitae feugiat nisl pretium. Curabitur fermentum justo elit. Mauris fringilla sem ultrices, euismod tellus in, molestie cursus nunc. Donec sit amet pellentesque ante. Suspendisse vel tempor libero. Sed fermentum urna leo, ac pulvinar justo rhoncus in. Quisque non nibh et risus pretium consequat eu ut turpis. Curabitur volutpat finibus ultricies. Integer nec accumsan mauris, vitae mattis nibh.
                        </p>
                    </div>
                </div>
            </div>

            <div class="tourism-section">
                <div class="tourism-content">
                    <div class="tourism-image" style="background-image: url('https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?ixlib=rb-4.0.3&auto=format&fit=crop&w=870&q=80')"></div>
                    <div class="tourism-text">
                        <h3 class="tourism-title">Wisata 2</h3>
                        <p class="tourism-description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet congue felis. Sed risus turpis, convallis in porttitor sed, euismod a tellus. Phasellus laoreet ac diam et tempor. Nam pretium tempus accumsan. Aenean id risus ex. Donec lobortis nisl nec tellus suscipit, quis finibus diam consectetur ut tellus. Phasellus laoreet ac diam et tempor. Nam pretium tempus accumsan. Aenean id risus ex. Donec lobortis nisl nec tellus suscipit, quis finibus diam molestie massa est vel nisl. Nullam luctus ex vel odio cursus, vitae feugiat nisl pretium. Curabitur fermentum justo elit. Mauris fringilla sem ultrices, euismod tellus in, molestie cursus nunc. Donec sit amet pellentesque ante. Suspendisse vel tempor libero. Sed fermentum urna leo, ac pulvinar justo rhoncus in. Quisque non nibh et risus pretium consequat eu ut turpis. Curabitur volutpat finibus ultricies. Integer nec accumsan mauris, vitae mattis nibh.
                        </p>
                    </div>
                </div>
            </div>

            <div class="tourism-section">
                <div class="tourism-content">
                    <div class="tourism-image" style="background-image: url('https://images.unsplash.com/photo-1533873984035-25970ab07461?ixlib=rb-4.0.3&auto=format&fit=crop&w=869&q=80')"></div>
                    <div class="tourism-text">
                        <h3 class="tourism-title">Wisata 3</h3>
                        <p class="tourism-description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet congue felis. Sed risus turpis, convallis in porttitor sed, euismod a tellus. Phasellus laoreet ac diam et tempor. Nam pretium tempus accumsan. Aenean id risus ex. Donec lobortis nisl nec tellus suscipit, quis finibus diam consectetur ut tellus. Phasellus laoreet ac diam et tempor. Nam pretium tempus accumsan. Aenean id risus ex. Donec lobortis nisl nec tellus suscipit, quis finibus diam molestie massa est vel nisl. Nullam luctus ex vel odio cursus, vitae feugiat nisl pretium. Curabitur fermentum justo elit. Mauris fringilla sem ultrices, euismod tellus in, molestie cursus nunc. Donec sit amet pellentesque ante. Suspendisse vel tempor libero. Sed fermentum urna leo, ac pulvinar justo rhoncus in. Quisque non nibh et risus pretium consequat eu ut turpis. Curabitur volutpat finibus ultricies. Integer nec accumsan mauris, vitae mattis nibh.
                        </p>
                    </div>
                </div>
            </div>

            <div class="tourism-section">
                <div class="tourism-content">
                    <div class="tourism-image" style="background-image: url('https://images.unsplash.com/photo-1571863533956-01c88e79957e?ixlib=rb-4.0.3&auto=format&fit=crop&w=870&q=80')"></div>
                    <div class="tourism-text">
                        <h3 class="tourism-title">Wisata 4</h3>
                        <p class="tourism-description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet congue felis. Sed risus turpis, convallis in porttitor sed, euismod a tellus. Phasellus laoreet ac diam et tempor. Nam pretium tempus accumsan. Aenean id risus ex. Donec lobortis nisl nec tellus suscipit, quis finibus diam consectetur ut tellus. Phasellus laoreet ac diam et tempor. Nam pretium tempus accumsan. Aenean id risus ex. Donec lobortis nisl nec tellus suscipit, quis finibus diam molestie massa est vel nisl. Nullam luctus ex vel odio cursus, vitae feugiat nisl pretium. Curabitur fermentum justo elit. Mauris fringilla sem ultrices, euismod tellus in, molestie cursus nunc. Donec sit amet pellentesque ante. Suspendisse vel tempor libero. Sed fermentum urna leo, ac pulvinar justo rhoncus in. Quisque non nibh et risus pretium consequat eu ut turpis. Curabitur volutpat finibus ultricies. Integer nec accumsan mauris, vitae mattis nibh.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

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

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
