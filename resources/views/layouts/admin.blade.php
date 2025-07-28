<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Page')</title>

    <!-- Vite CSS & JS Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @push('styles')
    @endpush
</head>

<body class="bg-[#F4F4F4]">
    @include('layouts.partials.admin_sidebar')

    {{-- content --}}
    @yield('content')

    @push('scripts')
    @endpush
</body>

</html>
