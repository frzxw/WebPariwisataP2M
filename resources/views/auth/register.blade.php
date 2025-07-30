<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Daftar akun baru di Web Pariwisata - Buat akun untuk mengelola reservasi dan transaksi pariwisata">
    <meta name="robots" content="noindex, nofollow">
    <title>Daftar - Web Pariwisata</title>

    <!-- Preload critical assets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preload" href="{{ asset('images/background.png') }}" as="image">
    <link rel="preload" href="{{ asset('images/admin/logo-upi.webp') }}" as="image">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Vite CSS & JS Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat font-poppins"
    style="background-image: url('{{ asset('images/background.png') }}');">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 bg-white bg-opacity-95 backdrop-blur-md px-4 sm:px-8 py-4 z-50 shadow-lg">
        <nav class="flex justify-between items-center max-w-screen-xl mx-auto">
            <!-- Mobile menu button -->
            <button data-drawer-target="mobile-sidebar" data-drawer-toggle="mobile-sidebar"
                aria-controls="mobile-sidebar" type="button"
                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                    </path>
                </svg>
            </button>

            <!-- Logo -->
            <div class="flex items-center">
                <img src="{{ asset('images/admin/logo-upi.webp') }}" alt="UPI Logo" class="h-8 sm:h-10 w-auto">
            </div>

            <!-- Desktop Navigation -->
            <ul class="hidden md:flex list-none gap-8 ml-auto mr-8">
                <li><a href="{{ url('/') }}"
                        class="no-underline text-gray-700 font-medium transition-colors duration-300 hover:text-green-800">Home</a>
                </li>
                <li><a href="{{ url('/about') }}"
                        class="no-underline text-gray-700 font-medium transition-colors duration-300 hover:text-green-800 {{ request()->is('about') ? 'text-green-800' : '' }}">About
                        Us</a></li>
                <li><a href="{{ url('/transaction') }}"
                        class="no-underline text-gray-700 font-medium transition-colors duration-300 hover:text-green-800 {{ request()->is('transaction') ? 'text-green-800' : '' }}">Transaksi</a>
                </li>
                <li><a href="{{ url('/') }}"
                        class="no-underline text-gray-700 font-medium transition-colors duration-300 hover:text-green-800">Akun</a>
                </li>
                <li><a href="{{ url('/booking') }}"
                        class="px-6 py-2 rounded-full no-underline font-medium transition-all duration-300 bg-baseGreen hover:bg-darkGreen text-white hover:transform hover:-translate-y-0.5 hover:shadow-lg {{ request()->is('booking') ? 'text-white' : '' }}">Reservasi</a>
                </li>
            </ul>

            <!-- Desktop Auth Button -->
            <div class="hidden md:flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-6 py-2 rounded-full no-underline font-medium transition-all duration-300 bg-green-700 text-white hover:transform hover:-translate-y-0.5 hover:shadow-lg">Dashboard</a>
                    @else
                        <a href="{{ url('/login') }}"
                            class="px-6 py-2 rounded-full no-underline font-medium transition-all duration-300 bg-green-700 text-white hover:transform hover:-translate-y-0.5 hover:shadow-lg">Masuk</a>
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <!-- Mobile Sidebar -->
    <aside id="mobile-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-white shadow-lg md:hidden"
        aria-label="Mobile Navigation">
        <div class="h-full px-4 py-6 overflow-y-auto">
            <!-- Mobile Sidebar Header -->
            <div class="flex items-center justify-between mb-8">
                <img src="{{ asset('images/admin/logo-upi.webp') }}" alt="UPI Logo" class="h-8 w-auto">
                <button type="button" data-drawer-hide="mobile-sidebar" aria-controls="mobile-sidebar"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close menu</span>
                </button>
            </div>

            <!-- Mobile Navigation Links -->
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ url('/') }}"
                        class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->is('/') ? 'bg-gray-100' : '' }}">
                        <span class="ml-1">Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/about') }}"
                        class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->is('about') ? 'bg-gray-100' : '' }}">
                        <span class="ml-1">About Us</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/transaction') }}"
                        class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->is('transaction') ? 'bg-gray-100' : '' }}">
                        <span class="ml-1">Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/') }}"
                        class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <span class="ml-1">Akun</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/booking') }}"
                        class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->is('booking') ? 'bg-gray-100' : '' }}">
                        <span class="ml-1">Reservasi</span>
                    </a>
                </li>
            </ul>

            <!-- Mobile Auth Section -->
            <div class="pt-6 mt-6 border-t border-gray-200">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-gray-100 group">
                            <span class="ml-1">Dashboard</span>
                        </a>
                    @else
                        <a href="{{ url('/login') }}"
                            class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-gray-100 group">
                            <span class="ml-1">Masuk</span>
                        </a>
                        <div class="mt-3">
                            <p class="text-sm text-gray-600 px-3 mb-2">Belum punya akun?</p>
                            <a href="{{ url('/register') }}"
                                class="block w-full text-center px-4 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:ring-green-300">
                                Daftar Sekarang
                            </a>
                        </div>
                    @endauth
                @endif
            </div>
        </div>
    </aside>

    <!-- Backdrop for mobile sidebar -->
    <div data-drawer-backdrop="mobile-sidebar" class="fixed inset-0 z-30 bg-gray-900/50 hidden"></div>

    <!-- Main Content -->
    <main class="font-poppins py-36">
        <div class="mx-auto relative px-4">
            <!-- Register Card -->
            <div class="flex items-center justify-center min-h-screen">
                <div
                    class="bg-white bg-opacity-70 backdrop-blur-sm rounded-3xl shadow-2xl p-8 w-full max-w-md mx-auto">
                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h1 class="text-xl font-medium text-baseGreen">Daftar Akun</h1>
                    </div>

                    <!-- Registration Form -->
                    <form method="POST" action="{{ url('/register') }}" class="space-y-3">
                        @csrf

                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-baseGreen">Nama
                                Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="bg-white text-gray-800 text-sm shadow-md rounded-2xl focus:ring-2 focus:ring-lime-500 focus:border-lime-500 block w-full px-3 py-4 @error('name') border-2 border-red-500 @else border-none @enderror"
                                placeholder="Masukkan nama lengkap Anda" required autocomplete="name">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-baseGreen">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="bg-white text-gray-800 text-sm rounded-2xl shadow-md focus:ring-2 focus:ring-lime-500 focus:border-lime-500 block w-full px-3 py-4 @error('email') border-2 border-red-500 @else border-none @enderror"
                                placeholder="janedoe@email.com" required autocomplete="email">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-baseGreen">No. HP</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                class="bg-white text-gray-800 text-sm rounded-2xl shadow-md focus:ring-2 focus:ring-lime-500 focus:border-lime-500 block w-full px-3 py-4 @error('phone') border-2 border-red-500 @else border-none @enderror"
                                placeholder="08xxxxxxxxxx" required autocomplete="tel" pattern="08[0-9]{8,11}">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-baseGreen">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password"
                                    class="bg-white text-gray-800 text-sm rounded-2xl shadow-md focus:ring-2 focus:ring-lime-500 focus:border-lime-500 block w-full px-3 py-4 pr-10 @error('password') border-2 border-red-500 @else border-none @enderror"
                                    placeholder="Minimal 8 karakter" required autocomplete="new-password"
                                    minlength="8">
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                                    aria-label="Toggle password visibility">
                                    <svg id="eyeOpenPassword" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="#3A5A40" stroke-width="2"
                                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                        <path stroke="#3A5A40" stroke-width="2"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <svg id="eyeClosedPassword" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24"
                                        class="hidden">
                                        <path stroke="#3A5A40" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <label for="password_confirmation"
                                class="block mb-2 text-sm font-medium text-baseGreen">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="bg-white text-gray-800 text-sm rounded-2xl shadow-md focus:ring-2 focus:ring-lime-500 focus:border-lime-500 block w-full px-3 py-4 pr-10 @error('password_confirmation') border-2 border-red-500 @else border-none @enderror"
                                    placeholder="Konfirmasi password Anda" required autocomplete="new-password"
                                    minlength="8">
                                <button type="button" id="togglePasswordConfirmation"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                                    aria-label="Toggle password confirmation visibility">
                                    <svg id="eyeOpenConfirmation" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="#3A5A40" stroke-width="2"
                                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                        <path stroke="#3A5A40" stroke-width="2"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <svg id="eyeClosedConfirmation" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24" class="hidden">
                                        <path stroke="#3A5A40" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="flex items-start mb-4">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                    class="w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 rounded-full focus:ring-lime-500 focus:ring-2"
                                    {{ old('terms') ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="text-gray-800">
                                    Saya setuju dengan
                                    <a href="#" class="text-lime-600 hover:text-lime-800 font-medium">
                                        syarat dan ketentuan
                                    </a>
                                    yang berlaku
                                </label>
                            </div>
                        </div>

                        <!-- Register Button -->
                        <div class="text-center mb-4">
                            <button type="submit"
                                class="min-w-36 w-fit text-white bg-baseGreen hover:bg-darkGreen focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-[64px] text-sm px-8 py-3 text-center transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                Daftar Sekarang
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Sudah punya akun?
                                <a href="{{ url('/login') }}" class="text-lime-600 hover:text-lime-800 font-medium">
                                    Masuk sekarang
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Configuration object for better maintainability
        const CONFIG = {
            SCROLL_THRESHOLD: 100,
            CLASSES: {
                HEADER_OPACITY_LOW: 'bg-opacity-95',
                HEADER_OPACITY_HIGH: 'bg-opacity-98',
                HIDDEN: 'hidden'
            },
            SELECTORS: {
                HEADER: 'header',
                PASSWORD_INPUT: '#password',
                PASSWORD_CONFIRMATION_INPUT: '#password_confirmation',
                TOGGLE_PASSWORD: '#togglePassword',
                TOGGLE_PASSWORD_CONFIRMATION: '#togglePasswordConfirmation',
                EYE_OPEN_PASSWORD: '#eyeOpenPassword',
                EYE_CLOSED_PASSWORD: '#eyeClosedPassword',
                EYE_OPEN_CONFIRMATION: '#eyeOpenConfirmation',
                EYE_CLOSED_CONFIRMATION: '#eyeClosedConfirmation',
                REGISTER_FORM: 'form[action*="/register"]',
                SUBMIT_BUTTON: 'button[type="submit"]',
                PHONE_INPUT: '#phone',
                TERMS_CHECKBOX: '#terms',
                MOBILE_SIDEBAR: '#mobile-sidebar',
                SIDEBAR_BACKDROP: '[data-drawer-backdrop="mobile-sidebar"]'
            },
            VALIDATION: {
                MIN_PASSWORD_LENGTH: 8,
                PHONE_REGEX: /^08[0-9]{8,11}$/
            }
        };

        // Header background opacity on scroll
        function handleScroll() {
            const header = document.querySelector(CONFIG.SELECTORS.HEADER);
            if (!header) return;

            if (window.scrollY > CONFIG.SCROLL_THRESHOLD) {
                header.classList.remove(CONFIG.CLASSES.HEADER_OPACITY_LOW);
                header.classList.add(CONFIG.CLASSES.HEADER_OPACITY_HIGH);
            } else {
                header.classList.remove(CONFIG.CLASSES.HEADER_OPACITY_HIGH);
                header.classList.add(CONFIG.CLASSES.HEADER_OPACITY_LOW);
            }
        }

        // Toggle password visibility for password field
        function togglePasswordVisibility() {
            const passwordInput = document.querySelector(CONFIG.SELECTORS.PASSWORD_INPUT);
            const eyeOpen = document.querySelector(CONFIG.SELECTORS.EYE_OPEN_PASSWORD);
            const eyeClosed = document.querySelector(CONFIG.SELECTORS.EYE_CLOSED_PASSWORD);

            if (!passwordInput || !eyeOpen || !eyeClosed) return;

            const isPasswordVisible = passwordInput.type === 'text';

            passwordInput.type = isPasswordVisible ? 'password' : 'text';
            eyeOpen.classList.toggle(CONFIG.CLASSES.HIDDEN, !isPasswordVisible);
            eyeClosed.classList.toggle(CONFIG.CLASSES.HIDDEN, isPasswordVisible);
        }

        // Toggle password visibility for confirmation field
        function togglePasswordConfirmationVisibility() {
            const passwordInput = document.querySelector(CONFIG.SELECTORS.PASSWORD_CONFIRMATION_INPUT);
            const eyeOpen = document.querySelector(CONFIG.SELECTORS.EYE_OPEN_CONFIRMATION);
            const eyeClosed = document.querySelector(CONFIG.SELECTORS.EYE_CLOSED_CONFIRMATION);

            if (!passwordInput || !eyeOpen || !eyeClosed) return;

            const isPasswordVisible = passwordInput.type === 'text';

            passwordInput.type = isPasswordVisible ? 'password' : 'text';
            eyeOpen.classList.toggle(CONFIG.CLASSES.HIDDEN, !isPasswordVisible);
            eyeClosed.classList.toggle(CONFIG.CLASSES.HIDDEN, isPasswordVisible);
        }

        // Form validation and submission handling
        function handleFormSubmission(event) {
            const password = document.querySelector(CONFIG.SELECTORS.PASSWORD_INPUT)?.value;
            const passwordConfirmation = document.querySelector(CONFIG.SELECTORS.PASSWORD_CONFIRMATION_INPUT)?.value;
            const phone = document.querySelector(CONFIG.SELECTORS.PHONE_INPUT)?.value;
            const terms = document.querySelector(CONFIG.SELECTORS.TERMS_CHECKBOX)?.checked;
            const submitButton = event.target.querySelector(CONFIG.SELECTORS.SUBMIT_BUTTON);

            // Check if terms are accepted
            if (!terms) {
                event.preventDefault();
                showNotification('Anda harus menyetujui syarat dan ketentuan untuk mendaftar.', 'error');
                return;
            }

            // Validate password match
            if (password !== passwordConfirmation) {
                event.preventDefault();
                showNotification('Password dan konfirmasi password tidak cocok!', 'error');
                return;
            }

            // Validate password length
            if (password && password.length < CONFIG.VALIDATION.MIN_PASSWORD_LENGTH) {
                event.preventDefault();
                showNotification('Password harus minimal 8 karakter!', 'error');
                return;
            }

            // Validate phone number format
            if (phone && !CONFIG.VALIDATION.PHONE_REGEX.test(phone)) {
                event.preventDefault();
                showNotification('Nomor HP harus dimulai dengan 08 dan berisi 10-13 digit!', 'error');
                return;
            }

            // Disable submit button to prevent double submission
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Memproses...';

                // Re-enable button after 5 seconds to prevent permanent lockout
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Daftar Sekarang';
                }, 5000);
            }
        }

        // Show notifications
        function showNotification(message, type = 'info') {
            // Using simple alert for now, can be replaced with toast notifications
            if (message) {
                alert(message);
            }
        }

        // Mobile sidebar functionality
        function initMobileSidebar() {
            const sidebar = document.querySelector(CONFIG.SELECTORS.MOBILE_SIDEBAR);
            const backdrop = document.querySelector(CONFIG.SELECTORS.SIDEBAR_BACKDROP);
            const toggleButtons = document.querySelectorAll('[data-drawer-toggle="mobile-sidebar"]');
            const hideButtons = document.querySelectorAll('[data-drawer-hide="mobile-sidebar"]');

            if (!sidebar || !backdrop) return;

            // Show sidebar
            function showSidebar() {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove(CONFIG.CLASSES.HIDDEN);
                document.body.classList.add('overflow-hidden');
            }

            // Hide sidebar
            function hideSidebar() {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add(CONFIG.CLASSES.HIDDEN);
                document.body.classList.remove('overflow-hidden');
            }

            // Event listeners for toggle buttons
            toggleButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.stopPropagation();
                    showSidebar();
                });
            });

            // Event listeners for hide buttons
            hideButtons.forEach(button => {
                button.addEventListener('click', hideSidebar);
            });

            // Close sidebar when clicking backdrop
            backdrop.addEventListener('click', hideSidebar);

            // Close sidebar when pressing Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                    hideSidebar();
                }
            });

            // Close sidebar when clicking links (mobile UX)
            const sidebarLinks = sidebar.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    // Small delay to allow navigation
                    setTimeout(hideSidebar, 100);
                });
            });
        }

        // Initialize event listeners when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize mobile sidebar
            initMobileSidebar();

            // Scroll event listener
            window.addEventListener('scroll', handleScroll);

            // Password toggle event listeners
            const togglePasswordButton = document.querySelector(CONFIG.SELECTORS.TOGGLE_PASSWORD);
            if (togglePasswordButton) {
                togglePasswordButton.addEventListener('click', togglePasswordVisibility);
            }

            const togglePasswordConfirmationButton = document.querySelector(CONFIG.SELECTORS
                .TOGGLE_PASSWORD_CONFIRMATION);
            if (togglePasswordConfirmationButton) {
                togglePasswordConfirmationButton.addEventListener('click', togglePasswordConfirmationVisibility);
            }

            // Form submission event listener
            const registerForm = document.querySelector(CONFIG.SELECTORS.REGISTER_FORM);
            if (registerForm) {
                registerForm.addEventListener('submit', handleFormSubmission);
            }

            // Show session messages
            @if (session('success'))
                showNotification('{{ session('success') }}', 'success');
            @endif

            @if (session('error'))
                showNotification('{{ session('error') }}', 'error');
            @endif

            // Show validation errors
            @if ($errors->any())
                const errors = @json($errors->all());
                if (errors.length > 0) {
                    showNotification('Terdapat kesalahan: ' + errors.join(', '), 'error');
                }
            @endif
        });

        // Cleanup event listeners on page unload
        window.addEventListener('beforeunload', function() {
            window.removeEventListener('scroll', handleScroll);
        });
    </script>
</body>

</html>
