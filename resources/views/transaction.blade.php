<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaksi - {{ config('app.name', 'Laravel') }}</title>

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

        /* Order Details Section */
        .order-cards-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .order-details {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .order-summary-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .order-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
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

        .summary-header {
            margin-bottom: 1rem;
        }

        .summary-label {
            color: #666;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .order-summary {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
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
        }

        /* 3-Column Table Layout for Order Summary */
        .summary-table-header,
        .summary-table-row,
        .summary-table-total {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1rem;
            padding: 0.75rem 0;
            align-items: center;
        }

        .summary-table-header {
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 0.5rem;
        }

        .summary-table-row {
            border-bottom: 1px solid #f1f3f4;
        }

        .summary-table-total {
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

        .addon-label {
            color: #666;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .col-name.bold {
            font-weight: bold;
        }

        /* Payment Method Section */
        .payment-section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .payment-method {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-method:hover {
            border-color: #2d5016;
            background: #f0f8f0;
        }

        .payment-method.selected {
            border-color: #2d5016;
            background: #f0f8f0;
        }

        .payment-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            overflow: hidden;
        }

        .payment-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .payment-name {
            font-weight: 600;
            color: #333;
        }

        /* Upload Section */
        .upload-section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .upload-area {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            background: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-area:hover {
            border-color: #2d5016;
            background: #f0f8f0;
        }

        .upload-button {
            background: #3A5A40;
            color: white;
            padding: 0.5rem 1.5rem;
            border: none;
            border-radius: 25px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            font-size: 1rem;
        }

        .upload-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .account-info {
            background: #e8f5e8;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #2d5016;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .order-cards-container {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .order-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .payment-methods {
                grid-template-columns: repeat(2, 1fr);
            }

            .container {
                padding: 0 1rem;
            }
        }
    </style>
</head>
<body>
    @include('partials.header')

    <main class="main-content">
        <div class="container">
            <h1 class="page-title">Detail Pesanan</h1>

            <!-- Order Details Section - Split into two cards -->
            <div class="order-cards-container">
                <!-- Booking Information Card -->
                <div class="order-details">
                    <div class="order-info">
                        <div class="info-row">
                            <span class="info-label">Nama Pemesan (Check in)</span>
                            <span class="info-value">Yattaqi</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Nama Pemesan (Check Out)</span>
                            <span class="info-value">Yattaqi</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Mulai Sewa</span>
                            <span class="info-value">16 Juli 2025, 13:00</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Akhir Sewa</span>
                            <span class="info-value">16 Juli 2025, 13:00</span>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Card -->
                <div class="order-summary-card">
                    <!-- Table Header -->
                    <div class="summary-table-header">
                        <span class="col-category">Jenis Kavling</span>
                        <span class="col-name bold">Kavling A</span>
                        <span class="col-price">1.000.000,00</span>
                    </div>

                    <!-- Add Ons Items -->
                    <div class="summary-table-row">
                        <span class="col-category">Add Ons</span>
                        <span class="col-name bold">Tenda A x1</span>
                        <span class="col-price">50.000,00</span>
                    </div>
                    <div class="summary-table-row">
                        <span class="col-category"></span>
                        <span class="col-name bold">Senter x1</span>
                        <span class="col-price">20.000,00</span>
                    </div>
                    <div class="summary-table-row">
                        <span class="col-category"></span>
                        <span class="col-name bold">Jaket x1</span>
                        <span class="col-price">50.000,00</span>
                    </div>

                    <!-- Total Row -->
                    <div class="summary-table-total">
                        <span class="col-category"></span>
                        <span class="col-name">Total</span>
                        <span class="col-price">1.120.000,00</span>
                    </div>
                </div>
            </div>

            <!-- Payment Method Section -->
            <div class="payment-section">
                <h2 class="section-title">Metode Pembayaran : Cash</h2>

                <div class="account-info">
                    <strong>Pembayaran Cash:</strong><br>
                    Silakan bayar langsung di lokasi camping
                </div>

                <div class="payment-methods">
                    <div class="payment-method selected" onclick="selectPayment(this)">
                        <div class="payment-icon">
                            <img src="{{ asset('images/cash.png') }}" alt="Cash">
                        </div>
                        <div class="payment-name">Cash</div>
                    </div>
                    <div class="payment-method" onclick="selectPayment(this)">
                        <div class="payment-icon">
                            <img src="{{ asset('images/qris_logo.png') }}" alt="QRIS">
                        </div>
                        <div class="payment-name">Qris</div>
                    </div>
                    <div class="payment-method" onclick="selectPayment(this)">
                        <div class="payment-icon">
                            <img src="{{ asset('images/bni_logo.png') }}" alt="BNI">
                        </div>
                        <div class="payment-name">Bank BNI</div>
                    </div>
                    <div class="payment-method" onclick="selectPayment(this)">
                        <div class="payment-icon">
                            <img src="{{ asset('images/spay_logo.png') }}" alt="ShopeePay">
                        </div>
                        <div class="payment-name">Shopeepay</div>
                    </div>
                </div>
            </div>

            <!-- Upload Section -->
            <div class="upload-section">
                <h2 class="section-title">Upload Bukti Pembayaran</h2>

                <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                    <input type="file" id="fileInput" style="display: none;" accept="image/*" onchange="handleFileUpload(this)">
                    <button class="upload-button">Upload bukti</button>
                    <p style="margin-top: 1rem; color: #666;">Klik untuk memilih file bukti pembayaran</p>
                </div>

                <div id="uploadResult" style="margin-top: 1rem; display: none;">
                    <div style="padding: 1rem; background: #d4edda; border-radius: 5px; color: #155724;">
                        File berhasil dipilih: <span id="fileName"></span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script>
        // Payment method selection
        function selectPayment(element) {
            // Remove selected class from all payment methods
            document.querySelectorAll('.payment-method').forEach(method => {
                method.classList.remove('selected');
            });

            // Add selected class to clicked element
            element.classList.add('selected');

            // Update payment info based on selection
            const paymentName = element.querySelector('.payment-name').textContent;
            updatePaymentInfo(paymentName);
        }

        function updatePaymentInfo(method) {
            const sectionTitle = document.querySelector('.payment-section .section-title');
            const accountInfo = document.querySelector('.account-info');

            switch(method) {
                case 'Bank BNI':
                    sectionTitle.textContent = 'Metode Pembayaran : BNI (1406976531) An. Yattaqi Ahmad Faza';
                    accountInfo.innerHTML = `
                        <strong>Informasi Rekening:</strong><br>
                        Bank BNI - 1406976531<br>
                        Atas Nama: Yattaqi Ahmad Faza
                    `;
                    break;
                case 'Cash':
                    sectionTitle.textContent = 'Metode Pembayaran : Cash';
                    accountInfo.innerHTML = `
                        <strong>Pembayaran Cash:</strong><br>
                        Silakan bayar langsung di lokasi camping
                    `;
                    break;
                case 'Qris':
                    sectionTitle.textContent = 'Metode Pembayaran : QRIS';
                    accountInfo.innerHTML = `
                        <strong>Pembayaran QRIS:</strong><br>
                        Scan kode QR yang tersedia di lokasi
                    `;
                    break;
                case 'Shopeepay':
                    sectionTitle.textContent = 'Metode Pembayaran : ShopeePay';
                    accountInfo.innerHTML = `
                        <strong>ShopeePay:</strong><br>
                        Transfer ke nomor: 081234567890<br>
                        Atas Nama: Yattaqi Ahmad Faza
                    `;
                    break;
            }
        }

        // File upload handling
        function handleFileUpload(input) {
            const file = input.files[0];
            if (file) {
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('uploadResult').style.display = 'block';
            }
        }
    </script>
</body>
</html>
