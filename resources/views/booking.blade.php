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

        .kavling-title {
            font-size: 1.5rem;
            color: #3A5A40;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .kavling-description {
            color: #666;
            line-height: 1.6;
            font-size: 0.9rem;
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
            border-top: 2px solid #2d5016;
            padding-top: 1rem;
            margin-top: 1rem;
            font-weight: bold;
            font-size: 1.1rem;
            color: #2d5016;
        }

        .item-name {
            color: #666;
        }

        .item-price {
            font-weight: 600;
            color: #333;
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
            <div class="booking-form">
                <!-- Kavling Selection -->
                <div class="form-card kavling-section">
                    <div class="carousel-container">
                        <div class="carousel">
                            <div class="carousel-slide active" style="background-image: url('https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-4.0.3&auto=format&fit=crop&w=869&q=80')"></div>
                            <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?ixlib=rb-4.0.3&auto=format&fit=crop&w=870&q=80')"></div>
                            <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1533873984035-25970ab07461?ixlib=rb-4.0.3&auto=format&fit=crop&w=869&q=80')"></div>
                        </div>
                        <button class="carousel-nav carousel-prev" onclick="prevSlide()">‹</button>
                        <button class="carousel-nav carousel-next" onclick="nextSlide()">›</button>
                    </div>

                    <h2 class="kavling-title">Kavling A</h2>
                    <p class="kavling-description">
                        Kavling A berlokasi di sebelah barat daya dari pintu masuk camping, dari kavling A ini Anda
                        hanya perlu berjalan sekitar 2 menit kurang lebih.
                    </p>
                </div>

                <!-- Add Ons Section -->
                <div class="form-card">
                    <h3 style="margin-bottom: 1.5rem; color: #3A5A40;">Add Ons (Opsional)</h3>
                    <p style="margin-bottom: 2rem; color: #666; font-size: 0.9rem;">Add On hanya bisa disewa ketika kavling sudah dipilih</p>

                    <div class="addon-item">
                        <div class="addon-info">
                            <div class="addon-icon" style="background-image: url('https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80')"></div>
                            <div class="addon-details">
                                <h4>Paket Kemah 1</h4>
                                <p>Tenda</p>
                                <p>all camping stuffed eceran camping deal</p>
                            </div>
                        </div>
                        <div class="addon-controls">
                            <div class="quantity-control">
                                <button class="qty-btn" onclick="changeQuantity('paket1', -1)">−</button>
                                <span class="qty-display" id="paket1-qty">0</span>
                                <button class="qty-btn" onclick="changeQuantity('paket1', 1)">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="addon-item">
                        <div class="addon-info">
                            <div class="addon-icon" style="background-image: url('https://images.unsplash.com/photo-1487730116645-74489c95b41b?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80')"></div>
                            <div class="addon-details">
                                <h4>Alat Masak</h4>
                                <p>1 komplet</p>
                            </div>
                        </div>
                        <div class="addon-controls">
                            <div class="quantity-control">
                                <button class="qty-btn" onclick="changeQuantity('cooking', -1)">−</button>
                                <span class="qty-display" id="cooking-qty">0</span>
                                <button class="qty-btn" onclick="changeQuantity('cooking', 1)">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="addon-item">
                        <div class="addon-info">
                            <div class="addon-icon" style="background-image: url('https://images.unsplash.com/photo-1533873984035-25970ab07461?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80')"></div>
                            <div class="addon-details">
                                <h4>Tenda</h4>
                                <p>Tenda bergaris semi vintage</p>
                            </div>
                        </div>
                        <div class="addon-controls">
                            <div class="quantity-control">
                                <button class="qty-btn" onclick="changeQuantity('tent', -1)">−</button>
                                <span class="qty-display" id="tent-qty">0</span>
                                <button class="qty-btn" onclick="changeQuantity('tent', 1)">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="addon-item">
                        <div class="addon-info">
                            <div class="addon-icon" style="background-image: url('https://images.unsplash.com/photo-1571863533956-01c88e79957e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80')"></div>
                            <div class="addon-details">
                                <h4>Tas</h4>
                                <p>tas bergaris semi vintage</p>
                            </div>
                        </div>
                        <div class="addon-controls">
                            <div class="quantity-control">
                                <button class="qty-btn" onclick="changeQuantity('bag', -1)">−</button>
                                <span class="qty-display" id="bag-qty">0</span>
                                <button class="qty-btn" onclick="changeQuantity('bag', 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="order-summary">
                <!-- Booking Form Fields -->
                <div class="form-group">
                    <label class="form-label">Nama pemesan (check in)</label>
                    <input type="text" class="form-input" value="Yattaqi" id="checkinName">
                </div>

                <div class="form-group">
                    <label class="form-label">Nama pemesan (check out)</label>
                    <input type="text" class="form-input" value="Yattaqi" id="checkoutName">
                </div>

                <div class="form-group">
                    <label class="form-label">Lama Sewa</label>
                    <div class="form-row">
                        <div>
                            <label class="form-label" style="font-size: 0.9rem; color: #666;">Dimulai</label>
                            <input type="datetime-local" class="form-input" id="startDate">
                        </div>
                        <div>
                            <label class="form-label" style="font-size: 0.9rem; color: #666;">Berakhir</label>
                            <input type="datetime-local" class="form-input" id="endDate">
                        </div>
                    </div>
                </div>

                <!-- Detail Pesanan Section -->
                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                    <h3 class="summary-title">Detail Pesanan</h3>

                    <div class="summary-row">
                        <span class="item-name">Kavling A</span>
                        <span class="item-price">1.000.000,00</span>
                    </div>

                    <div id="addon-summary">
                        <!-- Add-on items will be dynamically added here -->
                    </div>

                    <div class="summary-row total">
                        <span class="item-name">Total</span>
                        <span class="item-price">Rp. <span id="total-price">1.000.000,00</span></span>
                    </div>

                    <button class="continue-btn" onclick="proceedToTransaction()">Lanjutkan Transaksi</button>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script>
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

        // Quantity management
        const quantities = {
            paket1: 0,
            cooking: 0,
            tent: 0,
            bag: 0
        };

        const prices = {
            kavling: 1000000,
            paket1: 75000,
            cooking: 25000,
            tent: 50000,
            bag: 30000
        };

        function changeQuantity(item, delta) {
            quantities[item] = Math.max(0, quantities[item] + delta);
            document.getElementById(item + '-qty').textContent = quantities[item];
            updateSummary();
        }

        function updateSummary() {
            const addonSummary = document.getElementById('addon-summary');
            addonSummary.innerHTML = '';

            let total = prices.kavling;

            // Add addon items to summary
            Object.keys(quantities).forEach(item => {
                if (quantities[item] > 0) {
                    const row = document.createElement('div');
                    row.className = 'summary-row';

                    let itemName = '';
                    switch(item) {
                        case 'paket1': itemName = 'Paket Kemah 1'; break;
                        case 'cooking': itemName = 'Alat Masak'; break;
                        case 'tent': itemName = 'Tenda A'; break;
                        case 'bag': itemName = 'Tas'; break;
                    }

                    const itemTotal = prices[item] * quantities[item];
                    total += itemTotal;

                    row.innerHTML = `
                        <span class="item-name">${itemName} x${quantities[item]}</span>
                        <span class="item-price">${itemTotal.toLocaleString('id-ID')},00</span>
                    `;
                    addonSummary.appendChild(row);
                }
            });

            document.getElementById('total-price').textContent = total.toLocaleString('id-ID') + ',00';
        }

        function proceedToTransaction() {
            // Collect form data
            const bookingData = {
                checkinName: document.getElementById('checkinName').value,
                checkoutName: document.getElementById('checkoutName').value,
                startDate: document.getElementById('startDate').value,
                endDate: document.getElementById('endDate').value,
                quantities: quantities,
                total: document.getElementById('total-price').textContent
            };

            // Store in localStorage for transaction page
            localStorage.setItem('bookingData', JSON.stringify(bookingData));

            // Redirect to transaction page
            window.location.href = '/transaction';
        }

        // Set default dates
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const tomorrow = new Date(now);
            tomorrow.setDate(tomorrow.getDate() + 1);

            const formatDate = (date) => {
                return date.toISOString().slice(0, 16);
            };

            document.getElementById('startDate').value = formatDate(now);
            document.getElementById('endDate').value = formatDate(tomorrow);
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
