<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Web Pariwisata</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Vite CSS & JS Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat font-poppins"
    style="background-image: url('{{ asset('images/background.png') }}');">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 bg-white bg-opacity-95 backdrop-blur-md px-8 py-4 z-50 shadow-lg">
        <nav class="flex justify-between items-center max-w-screen-xl mx-auto">
            <div class="text-2xl font-bold text-green-800">
                <img src="{{ asset('images/admin/logo-upi.webp') }}" alt="UPI Logo" class="h-10 w-auto">
            </div>
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
                        class="px-6 py-2 rounded-full no-underline font-medium transition-all duration-300 bg-green-700 text-white hover:transform hover:-translate-y-0.5 hover:shadow-lg {{ request()->is('booking') ? 'text-white' : '' }}">Reservasi</a>
                </li>
            </ul>
            <div class="flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-6 py-2 rounded-full no-underline font-medium transition-all duration-300 bg-green-700 text-white hover:transform hover:-translate-y-0.5 hover:shadow-lg">Dashboard</a>
                    @else
                        <a href="{{ url('/booking') }}"
                            class="px-6 py-2 rounded-full no-underline font-medium transition-all duration-300 bg-green-700 text-white hover:transform hover:-translate-y-0.5 hover:shadow-lg">Reservasi</a>
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="font-poppins py-36">
        <div class="mx-auto relative px-4">
            <!-- Register Card -->
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white bg-opacity-90 backdrop-blur-sm rounded-3xl shadow-2xl p-8 w-full max-w-lg mx-auto">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h1 class="text-2xl font-semibold text-gray-900 mb-2">Daftar Akun</h1>
                        <p class="text-gray-600 text-sm">Buat akun baru untuk mengakses layanan kami</p>
                    </div>

                    <!-- Registration Form -->
                    <form method="POST" action="{{ url('/register') }}" class="space-y-5">
                        @csrf

                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                Lengkap</label>
                            @error('name')
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="bg-gray-50 border-2 border-red-500 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-3"
                                    placeholder="Masukkan nama lengkap Anda" required>
                            @else
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-3"
                                    placeholder="Masukkan nama lengkap Anda" required>
                            @enderror
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            @error('email')
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="bg-gray-50 border-2 border-red-500 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-3"
                                    placeholder="contoh@email.com" required>
                            @else
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-3"
                                    placeholder="contoh@email.com" required>
                            @enderror
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">No. HP</label>
                            @error('phone')
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="bg-gray-50 border-2 border-red-500 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-3"
                                    placeholder="08xxxxxxxxxx" required>
                            @else
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-3"
                                    placeholder="08xxxxxxxxxx" required>
                            @enderror
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <div class="relative">
                                @error('password')
                                    <input type="password" name="password" id="password"
                                        class="bg-gray-50 border-2 border-red-500 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-3 pr-10"
                                        placeholder="Minimal 8 karakter" required>
                                @else
                                    <input type="password" name="password" id="password"
                                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-3 pr-10"
                                        placeholder="Minimal 8 karakter" required>
                                @enderror
                                <button type="button" onclick="togglePasswordVisibility('password', 'eye-icon-1')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                    <svg id="eye-icon-1" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <label for="password_confirmation"
                                class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password</label>
                            <div class="relative">
                                @error('password_confirmation')
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="bg-gray-50 border-2 border-red-500 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-3 pr-10"
                                        placeholder="Konfirmasi password Anda" required>
                                @else
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-3 pr-10"
                                        placeholder="Konfirmasi password Anda" required>
                                @enderror
                                <button type="button"
                                    onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-2')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                    <svg id="eye-icon-2" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                    class="w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 rounded focus:ring-lime-500 focus:ring-2">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-900">
                                    Saya setuju dengan <a href="#"
                                        class="text-lime-600 hover:text-lime-800 font-medium">syarat dan ketentuan</a>
                                    yang berlaku
                                </label>
                            </div>
                        </div>

                        <!-- Register Button -->
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full text-white bg-lime-700 hover:bg-lime-800 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition-colors duration-300">
                                Daftar Sekarang
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center pt-4">
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

    <!-- Remove all modal content and related scripts -->
    <script>
        // Header background on scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.classList.remove('bg-opacity-95');
                header.classList.add('bg-opacity-98');
            } else {
                header.classList.remove('bg-opacity-98');
                header.classList.add('bg-opacity-95');
            }
        });

        // Toggle password visibility for multiple fields
        function togglePasswordVisibility(fieldId, iconId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.792 6.792M9.878 9.878l-2.085 2.085m4.242 4.242L15.12 9.878M12.121 9.878l2.085-2.085M12.121 9.878L9.878 12.12"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"></path>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const phone = document.getElementById('phone').value;
            const terms = document.getElementById('terms').checked;

            // Check if terms are accepted
            if (!terms) {
                e.preventDefault();
                alert('Anda harus menyetujui syarat dan ketentuan untuk mendaftar.');
                return;
            }

            // Validate password match
            if (password !== passwordConfirmation) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return;
            }

            // Validate password length
            if (password.length < 8) {
                e.preventDefault();
                alert('Password harus minimal 8 karakter!');
                return;
            }

            // Validate phone number format
            const phoneRegex = /^08[0-9]{8,11}$/;
            if (!phoneRegex.test(phone)) {
                e.preventDefault();
                alert('Nomor HP harus dimulai dengan 08 dan berisi 10-13 digit!');
                return;
            }
        });

        // Show success message if registration successful
        @if (session('success'))
            alert('{{ session('success') }}');
        @endif

        // Show error message if registration failed
        @if (session('error'))
            alert('{{ session('error') }}');
        @endif
    </script>
</body>

</html>
