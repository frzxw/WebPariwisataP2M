<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage</title>

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
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 40%, rgba(48, 72, 53, 0.8) 80%, #304835 100%),
                        url('{{ asset('images/background.png') }}') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 600px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .hero-btn {
            background: #A3B18A;
            color: #3A5A40;
            padding: 2rem 4rem;
            font-size: 1.5rem;
            border-radius: 30px;
            margin-top: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            font-weight: 600;
            display: inline-block;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .hero-quote {
            position: absolute;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
            font-style: italic;
            font-size: 1.1rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .section {
            padding: 4rem 0;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #3A5A40;
        }

        /* Carousel Styles */
        .carousel-container {
            position: relative;
            margin-bottom: 2rem;
            border-radius: 15px;
            overflow: hidden;
        }

        .carousel {
            position: relative;
            height: 300px;
            display: flex;
            gap: 10px;
            overflow: hidden;
        }

        .carousel-slide {
            position: relative;
            flex: 1;
            width: calc(50% - 5px);
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 1;
            transition: transform 0.5s ease-in-out, opacity 0.5s ease;
            border-radius: 10px;
            transform: translateX(0);
        }

        .carousel-slide:not(.active):not(.active-second) {
            display: none;
        }

        .carousel-slide.slide-out-left {
            transform: translateX(-100%);
            opacity: 0;
        }

        .carousel-slide.slide-out-right {
            transform: translateX(100%);
            opacity: 0;
        }

        .carousel-slide.slide-in-right {
            transform: translateX(100%);
            opacity: 1;
        }

        .carousel-slide.slide-in-left {
            transform: translateX(-100%);
            opacity: 1;
        }

        .carousel-slide.slide-in-right.active,
        .carousel-slide.slide-in-right.active-second,
        .carousel-slide.slide-in-left.active,
        .carousel-slide.slide-in-left.active-second {
            transform: translateX(0);
            opacity: 1;
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #3A5A40;
            transition: all 0.3s ease;
            z-index: 10;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .carousel-nav:hover {
            background: white;
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .carousel-nav:active {
            transform: translateY(-50%) scale(0.95);
            transition: all 0.1s ease;
        }

        .carousel-nav.clicked {
            animation: navClick 0.3s ease;
        }

        @keyframes navClick {
            0% { transform: translateY(-50%) scale(1); }
            50% { transform: translateY(-50%) scale(0.9); background: #3A5A40; color: white; }
            100% { transform: translateY(-50%) scale(1.05); }
        }

        .carousel-prev {
            left: 20px;
        }

        .carousel-next {
            right: 20px;
        }

        .section-content {
            text-align: center;
            margin-bottom: 2rem;
            margin-top: 2rem;
        }

        .section-description {
            max-width: 800px;
            margin: 0 auto;
            color: #666;
            line-height: 1.8;
        }

        /* Location Map Section */
        .location-section {
            background: #f8f9fa;
            padding: 4rem 0;
        }

        .location-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        @media (max-width: 1024px) {
            .location-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .location-grid {
                grid-template-columns: 1fr;
            }
        }

        .location-item {
            text-align: center;
            transition: transform 0.3s;
        }

        .location-item:hover {
            transform: translateY(-5px);
        }

        .location-icon {
            width: 100%;
            height: 200px;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .location-icon iframe {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 15px;
        }

        .location-item h3 {
            color: #3A5A40;
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
            font-weight: 600;
        }

        .location-item p {
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* Footer */
        .footer {
            background: #3A5A40;
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            color: #3A5A40;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: #3A5A40;
        }

        .footer-bottom {
            border-top: 1px solid #444;
            padding-top: 1rem;
            text-align: center;
            color: #ccc;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-links {
                margin-left: auto;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .carousel-nav {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .carousel-nav:hover {
                transform: translateY(-50%) scale(1.05);
            }

            @keyframes navClick {
                0% { transform: translateY(-50%) scale(1); }
                50% { transform: translateY(-50%) scale(0.85); background: #3A5A40; color: white; }
                100% { transform: translateY(-50%) scale(1); }
            }

            .carousel-prev {
                left: 10px;
            }

            .carousel-next {
                right: 10px;
            }

            .hero-quote {
                font-size: 1rem;
                padding: 0 1rem;
            }
        }
    </style>
</head>
<body>
    @include('partials.header')

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Selamat Datang</h1>
            <a href="{{ url('/booking') }}" class="btn hero-btn">Mulai Reservasi</a>
        </div>
        <div class="hero-quote">
        </div>
    </section>

    <!-- Main Content -->
    <main>
        <!-- Brand Section -->
        <section style="background: #304835; padding: 7rem 0;">
            <div class="container">
                <div style="text-align: center; color: white;">
                    <p style="font-style: italic; font-size: 1.5rem; opacity: 0.9; font-weight: 200; letter-spacing: 0.5px;">"The Wonders of Nature. Yours to Discover, Ours to Protect."</p>
                </div>
            </div>
        </section>

        <!-- Camping Locations -->
        <section class="section">
            <div class="container">
                <h2 class="section-title">Djamudju Coffee & Camp</h2>
                <div class="carousel-container">
                    <div class="carousel" data-carousel="carousel1">
                        <div class="carousel-slide active" style="background-image: url('https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-4.0.3&auto=format&fit=crop&w=869&q=80')"></div>
                        <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?ixlib=rb-4.0.3&auto=format&fit=crop&w=870&q=80')"></div>
                        <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1533873984035-25970ab07461?ixlib=rb-4.0.3&auto=format&fit=crop&w=869&q=80')"></div>
                        <button class="carousel-nav carousel-prev" onclick="prevSlide('carousel1')">‹</button>
                        <button class="carousel-nav carousel-next" onclick="nextSlide('carousel1')">›</button>
                    </div>
                    <div class="section-content">
                        <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus est amet ratione quod. Sed natus facilis necessitatibus in possimus quae eos ad omnis sint accusamus. Assumenda ad illum et iusto fuga error fuga quis sequi. Autem.</p>
                    </div>
                </div>

                <h2 class="section-title">Kampung Stamplat Girang</h2>
                <div class="carousel-container">
                    <div class="carousel" data-carousel="carousel2">
                        <div class="carousel-slide active" style="background-image: url('https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=870&q=80')"></div>
                        <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1487730116645-74489c95b41b?ixlib=rb-4.0.3&auto=format&fit=crop&w=870&q=80')"></div>
                        <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1533873984035-25970ab07461?ixlib=rb-4.0.3&auto=format&fit=crop&w=869&q=80')"></div>
                        <button class="carousel-nav carousel-prev" onclick="prevSlide('carousel2')">‹</button>
                        <button class="carousel-nav carousel-next" onclick="nextSlide('carousel2')">›</button>
                    </div>
                    <div class="section-content">
                        <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus est amet ratione quod. Sed natus facilis necessitatibus in possimus quae eos ad omnis sint accusamus. Assumenda ad illum et iusto fuga error fuga quis sequi. Autem.</p>
                    </div>
                </div>

                <h2 class="section-title">Camping Ground Ngampay</h2>
                <div class="carousel-container">
                    <div class="carousel" data-carousel="carousel3">
                        <div class="carousel-slide active" style="background-image: url('https://images.unsplash.com/photo-1537905569824-f89f14cceb68?ixlib=rb-4.0.3&auto=format&fit=crop&w=870&q=80')"></div>
                        <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1571902943202-507ec2618e8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=875&q=80')"></div>
                        <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1537905569824-f89f14cceb68?ixlib=rb-4.0.3&auto=format&fit=crop&w=870&q=80')"></div>
                        <button class="carousel-nav carousel-prev" onclick="prevSlide('carousel3')">‹</button>
                        <button class="carousel-nav carousel-next" onclick="nextSlide('carousel3')">›</button>
                    </div>
                    <div class="section-content">
                        <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus est amet ratione quod. Sed natus facilis necessitatibus in possimus quae eos ad omnis sint accusamus. Assumenda ad illum et iusto fuga error fuga quis sequi. Autem.</p>
                    </div>
                </div>

                <h2 class="section-title">Coffee Forest Camp</h2>
                <div class="carousel-container">
                    <div class="carousel" data-carousel="carousel4">
                        <div class="carousel-slide active" style="background-image: url('https://images.unsplash.com/photo-1533873984035-25970ab07461?ixlib=rb-4.0.3&auto=format&fit=crop&w=869&q=80')"></div>
                        <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1571863533956-01c88e79957e?ixlib=rb-4.0.3&auto=format&fit=crop&w=870&q=80')"></div>
                        <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1533873984035-25970ab07461?ixlib=rb-4.0.3&auto=format&fit=crop&w=869&q=80')"></div>
                        <button class="carousel-nav carousel-prev" onclick="prevSlide('carousel4')">‹</button>
                        <button class="carousel-nav carousel-next" onclick="nextSlide('carousel4')">›</button>
                    </div>
                    <div class="section-content">
                        <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus est amet ratione quod. Sed natus facilis necessitatibus in possimus quae eos ad omnis sint accusamus. Assumenda ad illum et iusto fuga error fuga quis sequi. Autem.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Location Section -->
        <section class="location-section">
            <div class="container">
                <h2 class="section-title">Lokasi Kami</h2>
                <div class="location-grid">
                    <div class="location-item">
                        <div class="location-icon">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798!2d107.6191!3d-6.9175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTUnMDMuMCJTIDEwN8KwMzcnMDguOCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <h3>Camping Ground Ngampay</h3>
                        <p>Lokasi strategis dengan akses mudah dan pemandangan alam yang indah</p>
                    </div>

                    <div class="location-item">
                        <div class="location-icon">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798!2d107.6191!3d-6.9175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTUnMDMuMCJTIDEwN8KwMzcnMDguOCJF!5e0!3m2!1sen!2sid!4v1234567890124!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <h3>Kampung Stamplat Girang</h3>
                        <p>Experience camping di desa wisata dengan budaya lokal yang kental</p>
                    </div>

                    <div class="location-item">
                        <div class="location-icon">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798!2d107.6191!3d-6.9175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTUnMDMuMCJTIDEwN8KwMzcnMDguOCJF!5e0!3m2!1sen!2sid!4v1234567890125!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <h3>Djamudju Coffee Camp</h3>
                        <p>Kombinasi camping dan coffee experience dengan cita rasa lokal</p>
                    </div>

                    <div class="location-item">
                        <div class="location-icon">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798!2d107.6191!3d-6.9175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTUnMDMuMCJTIDEwN8KwMzcnMDguOCJF!5e0!3m2!1sen!2sid!4v1234567890126!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <h3>Fresh Forest</h3>
                        <p>Camping di tengah hutan dengan suasana alami dan udara segar</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

    <script>
        // Carousel functionality - updated to match booking.blade.php style
        let currentSlides = {
            'carousel1': 0,
            'carousel2': 0,
            'carousel3': 0,
            'carousel4': 0
        };

        function showSlide(carouselId, index, direction = 'next') {
            const carousel = document.querySelector(`[data-carousel="${carouselId}"]`);
            if (!carousel) return;

            const slides = carousel.querySelectorAll('.carousel-slide');

            // Calculate new slides to show
            const newSlide1 = slides[index];
            const newSlide2Index = (index + 1) % slides.length;
            const newSlide2 = slides[newSlide2Index];

            // Remove all animation classes from all slides first
            slides.forEach(slide => {
                slide.classList.remove('active', 'active-second', 'slide-out-left', 'slide-out-right', 'slide-in-left', 'slide-in-right');
            });

            // Set up new slides for animation
            if (direction === 'next') {
                // Position new slides off-screen to the right
                newSlide1.classList.add('slide-in-right');
                newSlide2.classList.add('slide-in-right');
            } else {
                // Position new slides off-screen to the left
                newSlide1.classList.add('slide-in-left');
                newSlide2.classList.add('slide-in-left');
            }

            // Make new slides visible and add active classes
            newSlide1.classList.add('active');
            newSlide2.classList.add('active-second');

            // Force reflow
            carousel.offsetHeight;

            // Trigger the animation by removing positioning classes
            setTimeout(() => {
                newSlide1.classList.remove('slide-in-right', 'slide-in-left');
                newSlide2.classList.remove('slide-in-right', 'slide-in-left');
            }, 10);
        }

        function nextSlide(carouselId) {
            const carousel = document.querySelector(`[data-carousel="${carouselId}"]`);
            if (!carousel) return;

            // Add click animation to button
            const nextBtn = carousel.querySelector('.carousel-next');
            if (nextBtn) {
                nextBtn.classList.add('clicked');
                setTimeout(() => nextBtn.classList.remove('clicked'), 300);
            }

            const slides = carousel.querySelectorAll('.carousel-slide');
            currentSlides[carouselId] = (currentSlides[carouselId] + 1) % slides.length;
            showSlide(carouselId, currentSlides[carouselId], 'next');
        }

        function prevSlide(carouselId) {
            const carousel = document.querySelector(`[data-carousel="${carouselId}"]`);
            if (!carousel) return;

            // Add click animation to button
            const prevBtn = carousel.querySelector('.carousel-prev');
            if (prevBtn) {
                prevBtn.classList.add('clicked');
                setTimeout(() => prevBtn.classList.remove('clicked'), 300);
            }

            const slides = carousel.querySelectorAll('.carousel-slide');
            currentSlides[carouselId] = (currentSlides[carouselId] - 1 + slides.length) % slides.length;
            showSlide(carouselId, currentSlides[carouselId], 'prev');
        }

        // Remove auto-advance carousels - commented out
        /*
        setInterval(() => {
            nextSlide('carousel1');
        }, 4000);

        setInterval(() => {
            nextSlide('carousel2');
        }, 4200);

        setInterval(() => {
            nextSlide('carousel3');
        }, 4400);

        setInterval(() => {
            nextSlide('carousel4');
        }, 4600);
        */

        // Initialize all carousels to show first two images
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize without animation for the first load
            ['carousel1', 'carousel2', 'carousel3', 'carousel4'].forEach(carouselId => {
                const carousel = document.querySelector(`[data-carousel="${carouselId}"]`);
                if (carousel) {
                    const slides = carousel.querySelectorAll('.carousel-slide');
                    slides.forEach(slide => slide.classList.remove('active', 'active-second'));
                    slides[0].classList.add('active');
                    slides[1].classList.add('active-second');
                }
            });
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
