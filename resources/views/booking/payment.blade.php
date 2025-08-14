<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Booking</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->                            <div class="file-upload" onclick="document.getElementById('payment_proof').click()">
                                <div class="upload-icon">+</div>
                                <div class="upload-text">Klik untuk upload bukti transfer</div>
                                <div class="file-info">Format: JPG, PNG (Max: 2MB)</div>
                            </div><style>
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
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 2rem;
        }

        .payment-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .payment-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .payment-title {
            font-size: 1.8rem;
            color: #3A5A40;
            margin-bottom: 0.5rem;
        }

        .booking-info {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .booking-code {
            font-weight: 600;
            color: #3A5A40;
        }

        .payment-methods {
            margin-bottom: 2rem;
        }

        .method-section {
            margin-bottom: 1.5rem;
        }

        .method-title {
            font-size: 1.1rem;
            color: #3A5A40;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .method-grid {
            display: grid;
            gap: 1rem;
        }

        .method-card {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            background: white;
        }

        .bank-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .bank-logo {
            width: 60px;
            height: 40px;
            background: #f8f9fa;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #666;
        }

        .bank-details h4 {
            color: #333;
            margin-bottom: 0.25rem;
        }

        .account-number {
            font-family: monospace;
            font-size: 1.1rem;
            font-weight: 600;
            color: #3A5A40;
            margin: 0.5rem 0;
        }

        .account-name {
            color: #666;
            font-size: 0.9rem;
        }

        .copy-btn {
            background: #3A5A40;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .copy-btn:hover {
            background: #2d4530;
        }

        .upload-section {
            border-top: 2px solid #e9ecef;
            padding-top: 2rem;
        }

        .upload-title {
            font-size: 1.2rem;
            color: #3A5A40;
            margin-bottom: 1rem;
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

        .file-upload {
            border: 2px dashed #e9ecef;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: border-color 0.3s;
            cursor: pointer;
        }

        .file-upload:hover {
            border-color: #3A5A40;
        }

        .upload-icon {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 1rem;
        }

        .upload-text {
            color: #666;
            margin-bottom: 0.5rem;
        }

        .file-info {
            font-size: 0.9rem;
            color: #999;
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
            width: 100%;
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
            margin-top: 1rem;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        /* Order Summary */
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
            font-size: 1.3rem;
            color: #3A5A40;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-item.total {
            border-top: 2px solid #3A5A40;
            padding-top: 1rem;
            margin-top: 1rem;
            font-size: 1.2rem;
            font-weight: 600;
            color: #3A5A40;
        }

        .countdown {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .countdown-text {
            color: #856404;
            font-weight: 600;
        }

        .countdown-timer {
            font-size: 1.5rem;
            color: #dc3545;
            font-weight: bold;
            margin-top: 0.5rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
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

            .payment-card, .order-summary {
                padding: 1.5rem;
            }

            .order-summary {
                position: static;
            }
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="main-content">
        <div class="container">
            <!-- Payment Form -->
            <div class="payment-card">
                <div class="payment-header">
                    <h1 class="payment-title">Pembayaran Booking</h1>
                    <div class="booking-info">
                        <div class="booking-code">Kode Booking: {{ $booking->booking_code }}</div>
                        <div>Total: <strong>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</strong></div>
                    </div>
                </div>

                <!-- Countdown Timer -->
                <div class="countdown">
                    <div class="countdown-text">Waktu tersisa untuk menyelesaikan pembayaran:</div>
                    <div class="countdown-timer" id="countdown">23:59:59</div>
                </div>

                <!-- Payment Methods -->
                <div class="payment-methods">
                    <div class="method-section">
                        <h3 class="method-title">Transfer Bank</h3>
                        <div class="method-grid">
                            <div class="method-card">
                                <div class="bank-info">
                                    <div class="bank-logo">BCA</div>
                                    <div class="bank-details">
                                        <h4>Bank Central Asia</h4>
                                        <div class="account-number">1234567890</div>
                                        <div class="account-name">a.n. PT Pariwisata Camping</div>
                                        <button class="copy-btn" onclick="copyToClipboard('1234567890')">Copy Rekening</button>
                                    </div>
                                </div>
                            </div>

                            <div class="method-card">
                                <div class="bank-info">
                                    <div class="bank-logo">BRI</div>
                                    <div class="bank-details">
                                        <h4>Bank Rakyat Indonesia</h4>
                                        <div class="account-number">0987654321</div>
                                        <div class="account-name">a.n. PT Pariwisata Camping</div>
                                        <button class="copy-btn" onclick="copyToClipboard('0987654321')">Copy Rekening</button>
                                    </div>
                                </div>
                            </div>

                            <div class="method-card">
                                <div class="bank-info">
                                    <div class="bank-logo">BNI</div>
                                    <div class="bank-details">
                                        <h4>Bank Negara Indonesia</h4>
                                        <div class="account-number">1122334455</div>
                                        <div class="account-name">a.n. PT Pariwisata Camping</div>
                                        <button class="copy-btn" onclick="copyToClipboard('1122334455')">Copy Rekening</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Payment Proof -->
                <div class="upload-section">
                    <h3 class="upload-title">Upload Bukti Pembayaran</h3>
                    
                    @if($errors->any())
                        <div class="alert alert-error">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('web.booking.payment.process', $booking->booking_code) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label" for="payment_proof">Bukti Transfer *</label>
                            <div class="file-upload" onclick="document.getElementById('payment_proof').click()">
                                <div class="upload-icon">�</div>
                                <div class="upload-text">Klik untuk upload bukti transfer</div>
                                <div class="file-info">Format: JPG, PNG (Max: 2MB)</div>
                            </div>
                            <input type="file" id="payment_proof" name="payment_proof" accept=".jpg,.jpeg,.png" style="display: none;" required onchange="showFileName(this)">
                            <div id="file-name" style="margin-top: 0.5rem; color: #3A5A40; font-weight: 600;"></div>
                        </div>

                        <div class="alert alert-warning">
                            <strong>Penting:</strong> Pastikan bukti transfer jelas dan menunjukkan nominal yang sesuai dengan total pembayaran.
                        </div>

                        <button type="submit" class="btn btn-primary">Upload & Konfirmasi Pembayaran</button>
                        <a href="{{ route('web.booking.confirmation', $booking->booking_code) }}" class="btn btn-secondary">Kembali ke Detail Booking</a>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3 class="summary-title">Ringkasan Pesanan</h3>
                
                <div class="summary-item">
                    <span>Camping Ground</span>
                    <span>{{ $booking->facility->name }}</span>
                </div>

                <div class="summary-item">
                    <span>Check-in</span>
                    <span>{{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') }}</span>
                </div>

                <div class="summary-item">
                    <span>Check-out</span>
                    <span>{{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') }}</span>
                </div>

                <div class="summary-item">
                    <span>Lama</span>
                    <span>{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} malam</span>
                </div>

                <div class="summary-item">
                    <span>Peserta</span>
                    <span>{{ $booking->guests }} orang</span>
                </div>

                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                </div>

                <div class="summary-item">
                    <span>Pajak (11%)</span>
                    <span>Rp {{ number_format($booking->tax_amount, 0, ',', '.') }}</span>
                </div>

                <div class="summary-item total">
                    <span>Total</span>
                    <span>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script>
        // Payment form validation
        let paymentValidationErrors = {};

        // Validate file upload
        function validatePaymentProof(file) {
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            const maxSize = 2 * 1024 * 1024; // 2MB

            if (!file) {
                return { valid: false, message: 'Pilih file bukti transfer terlebih dahulu' };
            }

            if (!allowedTypes.includes(file.type)) {
                return { valid: false, message: 'Format file harus JPG, JPEG, atau PNG' };
            }

            if (file.size > maxSize) {
                return { valid: false, message: 'Ukuran file maksimal 2MB' };
            }

            return { valid: true, message: '' };
        }

        // Show error message
        function showPaymentError(message) {
            // Remove existing error
            const existingError = document.querySelector('.payment-error');
            if (existingError) {
                existingError.remove();
            }

            // Create error element
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-error payment-error';
            errorDiv.textContent = message;

            // Insert before submit button
            const submitButton = document.querySelector('.btn-primary');
            submitButton.parentNode.insertBefore(errorDiv, submitButton);
        }

        // Remove error message
        function removePaymentError() {
            const existingError = document.querySelector('.payment-error');
            if (existingError) {
                existingError.remove();
            }
        }

        // Show selected file name with validation
        function showFileName(input) {
            const file = input.files[0];
            const fileNameDiv = document.getElementById('file-name');
            
            if (file) {
                const validation = validatePaymentProof(file);
                
                if (validation.valid) {
                    fileNameDiv.innerHTML = `<span style="color: #3A5A40;">✓ File dipilih: ${file.name}</span>`;
                    removePaymentError();
                } else {
                    fileNameDiv.innerHTML = `<span style="color: #dc3545;">✗ ${validation.message}</span>`;
                    showPaymentError(validation.message);
                    input.value = ''; // Clear invalid file
                }
            } else {
                fileNameDiv.textContent = '';
            }
        }

        // Validate payment form on submit
        function validatePaymentForm(event) {
            event.preventDefault();
            
            const fileInput = document.getElementById('payment_proof');
            const file = fileInput.files[0];
            
            // Validate file
            const validation = validatePaymentProof(file);
            
            if (!validation.valid) {
                showPaymentError(validation.message);
                return false;
            }
            
            // Show loading state
            const submitButton = event.target.querySelector('.btn-primary');
            const originalText = submitButton.textContent;
            submitButton.disabled = true;
            submitButton.textContent = 'Memproses...';
            
            // Submit form after short delay to show loading state
            setTimeout(() => {
                event.target.submit();
            }, 500);
            
            return true;
        }

        // Initialize payment form validation
        document.addEventListener('DOMContentLoaded', function() {
            const paymentForm = document.querySelector('form[action*="payment.process"]');
            if (paymentForm) {
                paymentForm.addEventListener('submit', validatePaymentForm);
            }
        });

        // Countdown Timer
        function updateCountdown() {
            const createdAt = new Date('{{ $booking->created_at }}');
            const deadline = new Date(createdAt.getTime() + 24 * 60 * 60 * 1000); // 24 hours
            const now = new Date();
            const timeLeft = deadline - now;

            if (timeLeft <= 0) {
                document.getElementById('countdown').textContent = 'EXPIRED';
                document.getElementById('countdown').style.color = '#dc3545';
                
                // Disable form when expired
                const form = document.querySelector('form[action*="payment.process"]');
                const submitButton = form?.querySelector('.btn-primary');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Waktu Pembayaran Habis';
                    submitButton.style.background = '#6c757d';
                }
                
                return;
            }

            const hours = Math.floor(timeLeft / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            document.getElementById('countdown').textContent = 
                `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
            // Change color when time is low
            if (timeLeft < 3600000) { // Less than 1 hour
                document.getElementById('countdown').style.color = '#dc3545';
            } else if (timeLeft < 7200000) { // Less than 2 hours
                document.getElementById('countdown').style.color = '#fd7e14';
            }
        }

        // Update countdown every second
        updateCountdown();
        setInterval(updateCountdown, 1000);

        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Create success feedback
                const feedback = document.createElement('div');
                feedback.textContent = 'Nomor rekening berhasil disalin!';
                feedback.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: #3A5A40;
                    color: white;
                    padding: 1rem;
                    border-radius: 8px;
                    z-index: 1000;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                `;
                document.body.appendChild(feedback);
                
                // Remove after 3 seconds
                setTimeout(() => {
                    feedback.remove();
                }, 3000);
            }).catch(function() {
                alert('Gagal menyalin. Silakan salin manual: ' + text);
            });
        }
    </script>
</body>
</html>
