<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akun</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600&display=swap"
        rel="stylesheet">
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
                        <a href="{{ url('/admin/login') }}"
                            class="px-6 py-2 rounded-full no-underline font-medium transition-all duration-300 border-2 border-green-700 text-green-700 bg-transparent hover:transform hover:-translate-y-0.5 hover:shadow-lg">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ url('/booking') }}"
                                class="px-6 py-2 rounded-full no-underline font-medium transition-all duration-300 bg-green-700 text-white hover:transform hover:-translate-y-0.5 hover:shadow-lg">Reservasi</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="pt-20 font-poppins">
        <div class="mx-auto pt-16 relative px-4">
            <!-- Page Header -->
            <div class="mb-6 text-center">
                <h1 class="font-poppins font-semibold text-3xl text-gray-900 mb-2">Profil Saya</h1>
                <p class="text-sm text-gray-600">Kelola informasi profil dan keamanan akun Anda</p>
            </div>

            <!-- Account Card -->
            <div class="bg-white rounded-[20px] shadow-lg p-8 w-full min-h-screen font-poppins relative">
                <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8 max-w-5xl mx-auto">
                    <!-- Profile Info Section with overlapping photo -->
                    <div class="flex-shrink-0 mx-auto lg:mx-0 relative">
                        <!-- Profile Picture - Positioned to overlap background and white card -->
                        <div class="absolute -top-20 left-1/2 transform -translate-x-1/2 z-10">
                            <div class="w-56 h-56 rounded-full overflow-hidden border-4 border-white shadow-2xl">
                                <img src="https://placehold.co/500x500" alt="Profile Picture"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>

                        <div class="text-center lg:text-left mb-6 pt-40">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Yattaqi Ahmad Hitam</h2>
                            <p class="text-gray-500 text-sm">Member sejak Januari 2025</p>
                        </div>
                    </div>

                    <!-- Profile Information -->
                    <div class="flex-1 w-full font-montserrat">
                        <!-- Form Fields -->
                        <div class="space-y-6">
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                    Lengkap</label>
                                <input type="text" id="name" name="name" value="Yattaqi Ahmad Hitam"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-2.5"
                                    readonly>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                <input type="email" id="email" name="email" value="example@gmail.com"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-2.5"
                                    readonly>
                            </div>

                            <!-- Phone Field -->
                            <div>
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">No.
                                    HP</label>
                                <input type="tel" id="phone" name="phone" value="081234567890"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-2.5"
                                    readonly>
                            </div>

                            <!-- Edit Profile Button -->
                            <div class="pt-4 text-end">
                                <button type="button" data-modal-target="edit-profile-modal"
                                    data-modal-toggle="edit-profile-modal"
                                    class="text-white inline-flex items-center bg-lime-700 hover:bg-lime-800 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-300">
                                    <svg class="me-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Edit Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Edit Profile Modal -->
    <div id="edit-profile-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm font-poppins">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Edit Profile
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="edit-profile-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" id="editProfileForm">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <!-- Profile Picture Upload -->
                        <div class="col-span-2 text-center">
                            <div class="mb-4">
                                <div
                                    class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-gray-200 relative">
                                    <img id="profile-preview" src="https://placehold.co/500x500"
                                        alt="Profile Picture" class="w-full h-full object-cover">
                                    <label for="profile-picture"
                                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center cursor-pointer opacity-0 hover:opacity-100 transition-opacity duration-200">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </label>
                                </div>
                                <input type="file" id="profile-picture" name="profile_picture" accept="image/*"
                                    class="hidden">
                                <p class="text-xs text-gray-500 mt-2">Klik pada foto untuk mengubah</p>
                            </div>
                        </div>

                        <!-- Name Field -->
                        <div class="col-span-2">
                            <label for="edit_name" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                Lengkap</label>
                            <input type="text" name="name" id="edit_name" value="Yattaqi Ahmad Hitam"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-2.5"
                                placeholder="Masukkan nama lengkap" required>
                        </div>

                        <!-- Email Field -->
                        <div class="col-span-2">
                            <label for="edit_email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" id="edit_email" value="example@gmail.com"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-2.5"
                                placeholder="contoh@email.com" required>
                        </div>

                        <!-- Phone Field -->
                        <div class="col-span-2">
                            <label for="edit_phone" class="block mb-2 text-sm font-medium text-gray-900">No.
                                HP</label>
                            <input type="tel" name="phone" id="edit_phone" value="081234567890"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-2.5"
                                placeholder="08xxxxxxxxxx" required>
                        </div>

                        <!-- Current Password (for security) -->
                        <div class="col-span-2">
                            <label for="current_password"
                                class="block mb-2 text-sm font-medium text-gray-900">Password Saat Ini</label>
                            <input type="password" name="current_password" id="current_password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-2.5"
                                placeholder="Masukkan password saat ini untuk konfirmasi" required>
                        </div>

                        <!-- New Password (Optional) -->
                        <div class="col-span-2">
                            <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900">Password
                                Baru</label>
                            <input type="password" name="new_password" id="new_password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-2.5"
                                placeholder="Kosongkan jika tidak ingin mengubah password">
                            <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="col-span-2">
                            <label for="new_password_confirmation"
                                class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full p-2.5"
                                placeholder="Konfirmasi password baru">
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex gap-3">
                        <button type="submit"
                            class="text-white inline-flex items-center bg-lime-700 hover:bg-lime-800 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-300">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <button type="button" data-modal-toggle="edit-profile-modal"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 transition-colors duration-300">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

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
    </script>
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

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
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

        // Profile picture preview
        document.getElementById('profile-picture').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Form validation and submission
        document.getElementById('editProfileForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const currentPassword = document.getElementById('current_password').value;
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('new_password_confirmation').value;

            // Validate current password is provided
            if (!currentPassword) {
                alert('Password saat ini harus diisi untuk konfirmasi perubahan!');
                return;
            }

            // Validate new password if provided
            if (newPassword || confirmPassword) {
                if (newPassword !== confirmPassword) {
                    alert('Password baru dan konfirmasi password tidak cocok!');
                    return;
                }

                if (newPassword.length < 8) {
                    alert('Password baru harus minimal 8 karakter!');
                    return;
                }
            }

            // Validate email format
            const email = document.getElementById('edit_email').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Format email tidak valid!');
                return;
            }

            // Validate phone number
            const phone = document.getElementById('edit_phone').value;
            const phoneRegex = /^08[0-9]{8,11}$/;
            if (!phoneRegex.test(phone)) {
                alert('Nomor HP harus dimulai dengan 08 dan berisi 10-13 digit!');
                return;
            }

            // Here you would typically send the data to your server
            // For now, we'll just show a success message and update the display
            const name = document.getElementById('edit_name').value;
            const updatedEmail = document.getElementById('edit_email').value;
            const updatedPhone = document.getElementById('edit_phone').value;

            // Update the main form fields
            document.getElementById('name').value = name;
            document.getElementById('email').value = updatedEmail;
            document.getElementById('phone').value = updatedPhone;

            // Update the profile name display
            document.querySelector('h2.text-2xl').textContent = name;

            alert('Profile berhasil diperbarui!');

            // Close modal using Flowbite modal API
            const modal = FlowbiteInstances.getInstance('Modal', 'edit-profile-modal');
            if (modal) {
                modal.hide();
            }
        });

        // Password field synchronization
        document.getElementById('new_password').addEventListener('input', function() {
            const confirmField = document.getElementById('new_password_confirmation');
            if (this.value === '') {
                confirmField.value = '';
                confirmField.disabled = true;
                confirmField.placeholder = 'Masukkan password baru terlebih dahulu';
            } else {
                confirmField.disabled = false;
                confirmField.placeholder = 'Konfirmasi password baru';
            }
        });
    </script>
</body>

</html>
