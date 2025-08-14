@extends('admin.layouts.admin')

@section('title', 'Transaksi')
@section('content')
    <div class="px-4 py-8 sm:ml-56">
        <div class="md:mx-8 mb-6">
            <h1 class="font-poppins font-semibold text-2xl text-gray-900 mb-2">Transaksi</h1>
            <p class="text-sm text-gray-600">Kelola dan pantau semua transaksi pembayaran kavling wisata</p>
        </div>
        <div class="md:mx-8 p-4 bg-white rounded-[20px] shadow-lg ">
            <div class="mx-auto max-w-screen-2xl font-montserrat">
                <div class="relative overflow-hidden bg-white sm:rounded-lg">
                    <div
                        class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                        <div class="flex items-center flex-1 space-x-4 text-sm">
                            <h5>
                                <span class="text-gray-500">Semua Transaksi:</span>
                                <span class="">{{ number_format($totalBookings) }}</span>
                            </h5>
                            <h5>
                                <span class="text-gray-500">Total Pendapatan:</span>
                                <span class="">Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                            </h5>
                        </div>
                        <div>
                            <form class="flex items-center" method="GET" action="{{ route('admin.transactions') }}">
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
                                    <input type="text" id="simple-search" name="search" value="{{ request('search') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full pl-10 pr-3 py-2"
                                        placeholder="Cari transaksi, pelanggan, kavling...">
                                    <button type="submit"
                                        class="absolute right-0 top-0 h-full px-3 bg-lime-700 text-white rounded-r-lg hover:bg-lime-800 focus:ring-4 focus:outline-none focus:ring-lime-300 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- Date Picker --}}
                    <div
                        class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                        <div class="w-full lg:w-auto">
                            <div id="sort-date-range-picker" date-rangepicker
                                class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0">
                                <div class="relative flex-1 sm:flex-none">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="sort-datepicker-range-start" name="start" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full ps-10 py-2"
                                        placeholder="Pilih tanggal awal">
                                </div>
                                <span class="mx-4 text-gray-500 text-xs hidden sm:block">-</span>
                                <div class="relative flex-1 sm:flex-none">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="sort-datepicker-range-end" name="end" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full ps-10 py-2"
                                        placeholder="Pilih tanggal akhir">
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-col flex-shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">

                            <!-- Mobile: Stacked buttons / Desktop: Inline buttons -->
                            <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
                                <!-- Filter Status Button -->
                                <button type="button"
                                    class="flex items-center justify-center px-3 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-lime-500">
                                    <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                        </path>
                                    </svg>
                                    <span class="hidden sm:inline">Filter</span>
                                </button>

                                <!-- Refresh Button -->
                                <button type="button"
                                    class="flex items-center justify-center px-3 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-lime-500">
                                    <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    <span class="hidden sm:inline">Refresh</span>
                                </button>

                                <!-- Export Button -->
                                <button type="button"
                                    class="flex items-center justify-center px-3 py-2 text-xs font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-lime-700 focus:z-10 focus:ring-4 focus:ring-gray-200 transition-colors duration-200">
                                    <svg class="w-4 h-4 sm:mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewbox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                    </svg>
                                    <span class="hidden sm:inline">Export</span>
                                </button>
                            </div>

                            <!-- Primary Action Button - Always visible with full text -->
                            <button data-modal-target="create-form-modal" data-modal-toggle="create-form-modal"
                                type="button"
                                class="flex items-center justify-center px-4 py-2 text-xs font-medium text-white rounded-lg bg-lime-700 hover:bg-lime-800 focus:ring-4 focus:ring-lime-300 focus:outline-none transition-colors duration-200 whitespace-nowrap">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                <span class="hidden xs:inline">Tambah Transaksi</span>
                                <span class="xs:hidden">Tambah</span>
                            </button>

                            <!--  Modal Tambah Data -->
                            <div id="create-form-modal" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-lg max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow-sm font-poppins">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                Tambah Transaksi Baru
                                            </h3>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                data-modal-toggle="create-form-modal">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <form class="p-4 md:p-5">
                                            <div class="grid gap-4 mb-4 grid-cols-2">
                                                <div class="col-span-2">
                                                    <label for="order"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Order/Kavling</label>
                                                    <input type="text" name="order" id="order"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="Masukkan nomor kavling" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="user"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Nama
                                                        Pelanggan</label>
                                                    <input type="text" name="user" id="user"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="Masukkan nama pelanggan" required="">
                                                </div>
                                                <div class="col-span-2 sm:col-span-1">
                                                    <label for="status"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                                                    <select id="status" name="status"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                                        <option selected="">Pilih Status</option>
                                                        <option value="check_in">Check In</option>
                                                        <option value="check_out">Check Out</option>
                                                        <option value="belum_dibayar">Belum Dibayar</option>
                                                        <option value="sudah_dibayar">Sudah Dibayar</option>
                                                    </select>
                                                </div>
                                                <div class="col-span-2 sm:col-span-1">
                                                    <label for="harga"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Harga
                                                        Sewa</label>
                                                    <input type="number" name="harga" id="harga"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="Rp 50000" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="mulai_sewa"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Tanggal
                                                        Sewa</label>
                                                    <div id="create-date-range-picker" date-rangepicker
                                                        class="flex items-center">
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                                </svg>
                                                            </div>
                                                            <input id="create-datepicker-range-start" name="start"
                                                                type="text"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full ps-10"
                                                                placeholder="Pilih tanggal awal">
                                                        </div>
                                                        <span class="mx-4 text-gray-500 text-xs">-</span>
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                                </svg>
                                                            </div>
                                                            <input id="create-datepicker-range-end" name="end"
                                                                type="text"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full ps-10"
                                                                placeholder="Pilih tanggal akhir">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="catatan"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Catatan</label>
                                                    <textarea id="catatan" name="catatan" rows="4"
                                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-lime-500 focus:border-lime-500"
                                                        placeholder="Tulis catatan transaksi disini (opsional)"></textarea>
                                                </div>
                                            </div>
                                            <button type="submit"
                                                class="text-white inline-flex items-center bg-lime-700 hover:bg-lime-800 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Tambah Transaksi
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Show Data -->
                            <div id="show-modal" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-lg max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow-sm font-poppins">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                Detail Transaksi
                                            </h3>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                data-modal-toggle="show-modal">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5">
                                            <div class="grid gap-4 mb-4">
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900">Order/Kavling</label>
                                                        <p class="text-sm text-gray-700 bg-gray-50 p-2.5 rounded-lg">
                                                            Kavling A1</p>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                                                        <span
                                                            class="uppercase bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded-sm">Check
                                                            In</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900">Nama
                                                        Pelanggan</label>
                                                    <p class="text-sm text-gray-700 bg-gray-50 p-2.5 rounded-lg">Dudul
                                                        Abdul Kasim</p>
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900">Harga
                                                        Sewa</label>
                                                    <p class="text-sm text-gray-700 bg-gray-50 p-2.5 rounded-lg">Rp 50.000
                                                    </p>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal
                                                            Mulai</label>
                                                        <p class="text-sm text-gray-700 bg-gray-50 p-2.5 rounded-lg">30 Jul
                                                            2025</p>
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal
                                                            Akhir</label>
                                                        <p class="text-sm text-gray-700 bg-gray-50 p-2.5 rounded-lg">1 Agu
                                                            2025</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900">Catatan</label>
                                                    <p
                                                        class="text-sm text-gray-700 bg-gray-50 p-2.5 rounded-lg min-h-[80px]">
                                                        Transaksi pembayaran kavling untuk liburan keluarga. Sudah termasuk
                                                        fasilitas lengkap.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit Data -->
                            <div id="edit-modal" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-lg max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow-sm font-poppins">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                Edit Transaksi
                                            </h3>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                data-modal-toggle="edit-modal">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <form class="p-4 md:p-5">
                                            <div class="grid gap-4 mb-4 grid-cols-2">
                                                <div class="col-span-2">
                                                    <label for="edit_order"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Order/Kavling</label>
                                                    <input type="text" name="order" id="edit_order"
                                                        value="Kavling A1"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="Masukkan nomor kavling" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="edit_user"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Nama
                                                        Pelanggan</label>
                                                    <input type="text" name="user" id="edit_user"
                                                        value="Dudul Abdul Kasim"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="Masukkan nama pelanggan" required="">
                                                </div>
                                                <div class="col-span-2 sm:col-span-1">
                                                    <label for="edit_status"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                                                    <select id="edit_status" name="status"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                                        <option value="check_in" selected>Check In</option>
                                                        <option value="check_out">Check Out</option>
                                                        <option value="belum_dibayar">Belum Dibayar</option>
                                                        <option value="sudah_dibayar">Sudah Dibayar</option>
                                                    </select>
                                                </div>
                                                <div class="col-span-2 sm:col-span-1">
                                                    <label for="edit_harga"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Harga
                                                        Sewa</label>
                                                    <input type="number" name="harga" id="edit_harga" value="50000"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="Rp 50000" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="edit_mulai_sewa"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Tanggal
                                                        Sewa</label>
                                                    <div id="edit-date-range-picker" date-rangepicker
                                                        class="flex items-center">
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                                </svg>
                                                            </div>
                                                            <input id="edit-datepicker-range-start" name="start"
                                                                type="text" value="30/07/2025"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full ps-10"
                                                                placeholder="Pilih tanggal awal">
                                                        </div>
                                                        <span class="mx-4 text-gray-500 text-xs">-</span>
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                                </svg>
                                                            </div>
                                                            <input id="edit-datepicker-range-end" name="end"
                                                                type="text" value="01/08/2025"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-500 focus:border-lime-500 block w-full ps-10"
                                                                placeholder="Pilih tanggal akhir">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="edit_catatan"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Catatan</label>
                                                    <textarea id="edit_catatan" name="catatan" rows="4"
                                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-lime-500 focus:border-lime-500"
                                                        placeholder="Tulis catatan transaksi disini (opsional)">Transaksi pembayaran kavling untuk liburan keluarga. Sudah termasuk fasilitas lengkap.</textarea>
                                                </div>
                                            </div>
                                            <div class="flex gap-3">
                                                <button type="submit"
                                                    class="text-white inline-flex items-center bg-lime-700 hover:bg-lime-800 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Update Transaksi
                                                </button>
                                                <button type="button" data-modal-toggle="edit-modal"
                                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Delete Confirmation -->
                            <div id="delete-modal" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow-sm font-poppins">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                Konfirmasi Hapus
                                            </h3>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                data-modal-toggle="delete-modal">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <h3 class="mb-3 text-lg font-normal text-gray-500">
                                                Apakah Anda yakin ingin menghapus transaksi ini?
                                            </h3>
                                            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                                <p class="text-sm text-gray-700">
                                                    <span class="font-medium">Order:</span> Kavling A1<br>
                                                    <span class="font-medium">Pelanggan:</span> Dudul Abdul Kasim<br>
                                                    <span class="font-medium">Tanggal:</span> 30 Jul - 1 Agu 2025
                                                </p>
                                            </div>
                                            <div class="flex justify-center gap-3">
                                                <button type="button"
                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Ya, Hapus
                                                </button>
                                                <button type="button" data-modal-toggle="delete-modal"
                                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                                                    Batal
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 pb-6 max-h-[50vh] overflow-auto">
                        <table class="w-full text-sm text-left text-gray-500 font-montserrat">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th scope="col" class="p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-all" type="checkbox"
                                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-lime-600 focus:ring-lime-500 focus:ring-2">
                                            <label for="checkbox-all" class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Tanggal</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Order</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">User</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Status</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Total</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Mulai Sewa</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Akhir Sewa</th>
                                    <th scope="col" class="px-4 py-3 font-semibold text-center">
                                        Opsi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-xs">
                                @forelse($bookings as $booking)
                                    <tr class="border-b hover:bg-gray-50 transition-colors duration-150">
                                        <td class="w-4 px-4 py-3">
                                            <div class="flex items-center">
                                                <input id="checkbox-table-search-{{ $booking->id }}" type="checkbox"
                                                    onclick="event.stopPropagation()"
                                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-lime-600 focus:ring-lime-500 focus:ring-2">
                                                <label for="checkbox-table-search-{{ $booking->id }}" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $booking->created_at->format('D, d M Y') }}
                                        </td>
                                        <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $booking->booking_code }}
                                        </td>
                                        <th scope="row"
                                            class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap me-1">
                                            <img src="{{ $booking->user->profile_picture ? asset('storage/' . $booking->user->profile_picture) : 'https://placehold.co/500x500' }}" 
                                                 class="w-auto h-8 mr-3 rounded-full">
                                            {{ $booking->user->name }}
                                        </th>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <span class="uppercase text-xs font-bold me-2 px-2.5 py-0.5 rounded-sm
                                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($booking->status === 'pending') bg-orange-100 text-orange-800
                                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                                @else bg-blue-100 text-blue-800
                                                @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            <span class="font-semibold text-green-600">
                                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date)->format('D, d M Y') : '-' }}
                                        </td>
                                        <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $booking->check_out_date ? \Carbon\Carbon::parse($booking->check_out_date)->format('D, d M Y') : '-' }}
                                        </td>
                                        <td class="px-4 py-3 flex items-center justify-center">
                                            <button id="booking-{{ $booking->id }}-dropdown-button"
                                                data-dropdown-toggle="booking-{{ $booking->id }}-dropdown"
                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-150"
                                                type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                            <div id="booking-{{ $booking->id }}-dropdown"
                                                class="hidden z-10 w-44 bg-white rounded-lg shadow-lg border border-gray-100 divide-y divide-gray-100">
                                                <ul class="py-1 text-sm text-gray-700"
                                                    aria-labelledby="booking-{{ $booking->id }}-dropdown-button">
                                                    <li>
                                                        <a href="#" onclick="showBookingDetail({{ $booking->id }})"
                                                            class="flex items-center py-2 px-4 hover:bg-gray-100 text-gray-700">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                                </path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                </path>
                                                            </svg>
                                                            Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" onclick="editBooking({{ $booking->id }})"
                                                            class="flex items-center py-2 px-4 hover:bg-gray-100 text-gray-700">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                </path>
                                                            </svg>
                                                            Edit Status
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                            Tidak ada data transaksi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <nav class="flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0"
                        aria-label="Table navigation">
                        <span class="text-xs font-normal text-gray-500">
                            Menampilkan
                            <span class="font-semibold text-gray-900">{{ $bookings->firstItem() ?? 0 }}-{{ $bookings->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-semibold text-gray-900">{{ $bookings->total() }}</span>
                        </span>
                        
                        {{ $bookings->appends(request()->query())->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
