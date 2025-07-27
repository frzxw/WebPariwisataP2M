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

<body class="bg-[#F4F4F4]">
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-darkGreen rounded-lg sm:hidden hover:bg-whiteGreen focus:outline-none focus:ring-2 focus:ring-gray-200">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-[90vh] transition-transform -translate-x-full sm:translate-x-0 mx-4 my-6 rounded-[20px] shadow-md sm:shadow-none overflow-hidden"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-white">
            <a href="#" class="flex justify-center mx-auto mt-6 md:mt-10 mb-5">
                <img src="{{ asset('images/admin/logo-upi.webp') }}" class="h-10 sm:h-12" alt="UPI Logo" />
            </a>
            <ul class="space-y-2 font-poppins font-medium">
                <li>
                    <a href="#" class="flex items-center p-2 text-darkGreen rounded-lg hover:bg-whiteGreen group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-darkGreen"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-darkGreen rounded-lg hover:bg-whiteGreen group">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-darkGreen"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 20">
                            <path
                                d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Transaksi</span>
                        <span
                            class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-green-800 bg-green-100 rounded-full">3</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-darkGreen rounded-lg hover:bg-whiteGreen group">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-darkGreen"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 18">
                            <path
                                d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pelanggan</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-darkGreen rounded-lg hover:bg-whiteGreen group">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-darkGreen"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 18">
                            <path
                                d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Barang</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-darkGreen rounded-lg hover:bg-whiteGreen group">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-darkGreen"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z" />
                            <path
                                d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z" />
                            <path
                                d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Sign Up</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    {{-- content --}}
    <div class="px-4 py-6 sm:ml-64">
        <h1 class="font-poppins md:mx-8 font-medium text-xl mt-6 mb-8">Transaksi</h1>
        <div class="md:mx-8 p-4 bg-white rounded-[20px] shadow-lg ">
            <div class="mx-auto max-w-screen-2xl font-montserrat">
                <div class="relative overflow-hidden bg-white sm:rounded-lg">
                    <div
                        class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                        <div class="flex items-center flex-1 space-x-4 text-sm">
                            <h5>
                                <span class="text-gray-500">Semua Transaksi:</span>
                                <span class="">51</span>
                            </h5>
                            <h5>
                                <span class="text-gray-500">Total Pendapatan:</span>
                                <span class="">Rp. 20.000.000</span>
                            </h5>
                        </div>
                        <div>
                            <form class="flex items-center">
                                <label for="simple-search" class="sr-only">Cari</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor"
                                            viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2"
                                        placeholder="Search" required="">
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- Date Picker --}}
                    <div
                        class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4 ">
                        <div>

                            <div id="date-range-picker" date-rangepicker class="flex items-center">
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="datepicker-range-start" name="start" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full ps-10"
                                        placeholder="Pilih tanggal awal">
                                </div>
                                <span class="mx-4 text-gray-500 text-xs">-</span>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="datepicker-range-end" name="end" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full ps-10"
                                        placeholder="Pilih tanggal akhir">
                                </div>
                            </div>

                        </div>
                        <div
                            class="flex flex-col flex-shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">
                            <button type="button"
                                class="flex items-center justify-center px-4 py-2 text-xs font-medium text-white rounded-lg bg-lime-700 hover:bg-lime-800 focus:ring-4 focus:ring-lime-300 focus:outline-none">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                Tambah Transaksi
                            </button>
                            <button type="button"
                                class="flex items-center justify-center flex-shrink-0 px-3 py-2 text-xs font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewbox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                                Export
                            </button>
                        </div>
                    </div>
                    <div class="max-h-[50vh] overflow-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-all" type="checkbox"
                                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2">
                                            <label for="checkbox-all" class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3">Tanggal</th>
                                    <th scope="col" class="px-4 py-3">Order</th>
                                    <th scope="col" class="px-4 py-3">User</th>
                                    <th scope="col" class="px-4 py-3">Status</th>
                                    <th scope="col" class="px-4 py-3">Mulai Sewa</th>
                                    <th scope="col" class="px-4 py-3">Akhir Sewa</th>
                                    <th scope="col" class="px-4 py-3">
                                        Detail
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-xs">
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="w-4 px-4 py-3">
                                        <div class="flex items-center">
                                            <input id="checkbox-table-search-1" type="checkbox"
                                                onclick="event.stopPropagation()"
                                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                        Sabtu, 26 Jul 2025</td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                        Kavling A1</td>
                                    <th scope="row"
                                        class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap me-1">
                                        <img src="https://placehold.co/500x500" class="w-auto h-8 mr-3 rounded-full">
                                        Dudul Abdul Kasim
                                    </th>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{-- Status: Check In, Check Out, Belum Dibayar, Sudah Dibayar --}}
                                        <span
                                            class="uppercase bg-green-100 text-green-800 text-xs font-bold me-2 px-2.5 py-0.5 rounded-sm">Check
                                            In</span>
                                        {{-- <span
                                            class="uppercase bg-red-100 text-red-800 text-xs font-bold me-2 px-2.5 py-0.5 rounded-sm">Check
                                            Out</span>
                                        <span
                                            class="uppercase bg-orange-100 text-orange-800 text-xs font-bold me-2 px-2.5 py-0.5 rounded-sm">Belum
                                            Dibayar</span>
                                        <span
                                            class="uppercase bg-blue-100 text-blue-800 text-xs font-bold me-2 px-2.5 py-0.5 rounded-sm">Sudah
                                            Dibayar</span> --}}
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                        Sabtu, 30 Jul 2025</td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                        Sabtu, 1 Agu 2025</td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <button id="apple-imac-27-dropdown-button"
                                            data-dropdown-toggle="apple-imac-27-dropdown"
                                            class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none"
                                            type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div id="apple-imac-27-dropdown"
                                            class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow">
                                            <ul class="py-1 text-sm text-gray-700"
                                                aria-labelledby="apple-imac-27-dropdown-button">
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100">Show</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="block py-2 px-4 hover:bg-gray-100">Edit</a>
                                                </li>
                                            </ul>
                                            <div class="py-1">
                                                <a href="#"
                                                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav class="flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0"
                        aria-label="Table navigation">
                        <span class="text-xs font-normal text-gray-500">
                            Menampilkan
                            <span class="font-semibold text-gray-900">1-10</span>
                            dari
                            <span class="font-semibold text-gray-900">1000</span>
                        </span>
                        <ul class="inline-flex items-stretch -space-x-px">
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                                    <span class="sr-only">Sebelumnya</span>
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center px-3 py-2 text-xs leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">1</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center px-3 py-2 text-xs leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">2</a>
                            </li>
                            <li>
                                <a href="#" aria-current="page"
                                    class="z-10 flex items-center justify-center px-3 py-2 text-xs leading-tight border text-primary-600 bg-primary-50 border-primary-300 hover:bg-primary-100 hover:text-primary-700">3</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center px-3 py-2 text-xs leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">...</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center px-3 py-2 text-xs leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">100</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                                    <span class="sr-only">Selanjutnya</span>
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
