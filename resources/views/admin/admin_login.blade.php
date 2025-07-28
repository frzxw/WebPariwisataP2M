<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Admin Panel</title>

    <!-- Vite CSS & JS Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F4F4F4] min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <img src="{{ asset('images/admin/logo-upi.webp') }}" alt="Logo UPI" class="max-w-[200px] mx-auto mb-6">
        <form class="space-y-5 bg-white rounded-[34px] shadow-lg px-12 py-14 font-poppins">
            <h1 class="text-center text-green text-lg">Log In</h1>
            <div>
                <label for="email" class="block mb-2 text-sm text-baseGreen">Email</label>
                <input type="email" id="email" name="email"
                    class="bg-white border-2 border-gray-200 text-black text-sm rounded-2xl focus:ring-baseGreen focus:border-baseGreen block w-full p-2.5"
                    required />
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm text-baseGreen">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password"
                        class="bg-white border-2 border-gray-200 text-black text-sm rounded-2xl focus:ring-baseGreen focus:border-baseGreen block w-full p-2.5 pr-12"
                        required />
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                        <svg id="eyeOpen" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="#3A5A40" stroke-width="2"
                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                            <path stroke="#3A5A40" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                        <svg id="eyeClosed" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24" class="hidden">
                            <path stroke="#3A5A40" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                    </button>
                </div>
            </div>
            <div class="text-center">
                <button type="submit"
                    class="text-white bg-green-800 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-green-700 font-medium rounded-[64px] text-sm w-fit px-10 py-2.5 text-center">Login</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
