@extends('admin.layouts.admin')

@section('title', 'User')
@section('content')
    <div class="px-4 py-8 sm:ml-56">
        <div class="md:mx-8 mb-6">
            <h1 class="font-poppins font-semibold text-2xl text-gray-900 mb-2">User</h1>
            <p class="text-sm text-gray-600">Kelola dan pantau semua user yang terdaftar di sistem</p>
        </div>
        <div class="md:mx-8 p-4 bg-white rounded-[20px] shadow-lg ">
            <div class="mx-auto max-w-screen-2xl font-montserrat">
                <div class="relative overflow-hidden bg-white sm:rounded-lg">
                    <div
                        class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                        <div class="flex items-center flex-1 space-x-4 text-sm">
                            <h5>
                                <span class="text-gray-500">Total User:</span>
                                <span class="">{{ number_format($totalUsers) }}</span>
                            </h5>
                            <h5>
                                <span class="text-gray-500">User Aktif:</span>
                                <span class="">{{ number_format($activeUsers) }}</span>
                            </h5>
                        </div>
                        <div>
                            <form class="flex items-center" method="GET" action="{{ route('admin.users') }}">
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
                                        placeholder="Cari user berdasarkan nama, email, atau no HP...">
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
                    <div
                        class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">

                            <!-- Mobile: Stacked buttons / Desktop: Inline buttons -->
                            <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">

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
                                <span class="hidden xs:inline">Tambah User</span>
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
                                                Tambah User Baru
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
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                                                    <input type="text" name="name" id="name"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="Masukkan nama lengkap" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="email"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                                    <input type="email" name="email" id="email"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="contoh@email.com" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="phone"
                                                        class="block mb-2 text-sm font-medium text-gray-900">No. HP</label>
                                                    <input type="tel" name="phone" id="phone"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="08xxxxxxxxxx" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="password"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                                                    <input type="password" name="password" id="password"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="Masukkan password" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="password_confirmation"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password</label>
                                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="Konfirmasi password" required="">
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
                                                Tambah User
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
                                                Detail User
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
                                                            class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                                                        <p class="text-sm text-gray-700 bg-gray-50 p-2.5 rounded-lg">
                                                            Ahmad Rizki Pratama</p>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                                                        <span
                                                            class="uppercase bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded-sm">Aktif</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                                    <p class="text-sm text-gray-700 bg-gray-50 p-2.5 rounded-lg">ahmad.rizki@email.com</p>
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900">No. HP</label>
                                                    <p class="text-sm text-gray-700 bg-gray-50 p-2.5 rounded-lg">081234567890</p>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Daftar</label>
                                                        <p class="text-sm text-gray-700 bg-gray-50 p-2.5 rounded-lg">15 Jan 2025</p>
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-medium text-gray-900">Jumlah Transaksi</label>
                                                        <p class="text-sm text-gray-700 bg-gray-50 p-2.5 rounded-lg">5 Transaksi</p>
                                                    </div>
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
                                                Edit User
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
                                                    <label for="edit_name"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                                                    <input type="text" name="name" id="edit_name"
                                                        value="Ahmad Rizki Pratama"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="Masukkan nama lengkap" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="edit_email"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                                    <input type="email" name="email" id="edit_email"
                                                        value="ahmad.rizki@email.com"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="contoh@email.com" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="edit_phone"
                                                        class="block mb-2 text-sm font-medium text-gray-900">No. HP</label>
                                                    <input type="tel" name="phone" id="edit_phone"
                                                        value="081234567890"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="08xxxxxxxxxx" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="edit_password"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Password Baru</label>
                                                    <input type="password" name="password" id="edit_password"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="Kosongkan jika tidak ingin mengubah password">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="edit_password_confirmation"
                                                        class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password Baru</label>
                                                    <input type="password" name="password_confirmation" id="edit_password_confirmation"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                        placeholder="Konfirmasi password baru">
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
                                                    Update User
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
                                                Apakah Anda yakin ingin menghapus user ini?
                                            </h3>
                                            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                                <p class="text-sm text-gray-700">
                                                    <span class="font-medium">Nama:</span> Ahmad Rizki Pratama<br>
                                                    <span class="font-medium">Email:</span> ahmad.rizki@email.com<br>
                                                    <span class="font-medium">No. HP:</span> 081234567890
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
                                    <th scope="col" class="px-4 py-3 font-semibold">User</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">No. HP</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Email</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Tanggal Pembuatan Akun</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Jumlah Transaksi</th>
                                    <th scope="col" class="px-4 py-3 font-semibold text-center">
                                        Opsi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-xs">
                                @forelse($users as $user)
                                    <tr class="border-b hover:bg-gray-50 transition-colors duration-150">
                                        <td class="w-4 px-4 py-3">
                                            <div class="flex items-center">
                                                <input id="checkbox-table-search-{{ $user->id }}" type="checkbox"
                                                    onclick="event.stopPropagation()"
                                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-lime-600 focus:ring-lime-500 focus:ring-2">
                                                <label for="checkbox-table-search-{{ $user->id }}" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <th scope="row"
                                            class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap me-1">
                                            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://placehold.co/500x500' }}" 
                                                 class="w-auto h-8 mr-3 rounded-full">
                                            {{ $user->name }}
                                            @if($user->role === 'admin')
                                                <span class="ml-2 px-2 py-1 text-xs bg-orange-100 text-orange-800 rounded-full">Admin</span>
                                            @endif
                                        </th>
                                        <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $user->phone ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $user->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <span class="uppercase text-xs font-bold me-2 px-2.5 py-0.5 rounded-sm
                                                @if($user->is_active) bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 flex items-center justify-center">
                                            <button id="user-{{ $user->id }}-dropdown-button"
                                                data-dropdown-toggle="user-{{ $user->id }}-dropdown"
                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-150"
                                                type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                            <div id="user-{{ $user->id }}-dropdown"
                                                class="hidden z-10 w-44 bg-white rounded-lg shadow-lg border border-gray-100 divide-y divide-gray-100">
                                                <ul class="py-1 text-sm text-gray-700"
                                                    aria-labelledby="user-{{ $user->id }}-dropdown-button">
                                                    <li>
                                                        <a href="#" onclick="showUserDetail({{ $user->id }})"
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
                                                    @if($user->role !== 'admin')
                                                        <li>
                                                            <a href="#" onclick="toggleUserStatus({{ $user->id }})"
                                                                class="flex items-center py-2 px-4 hover:bg-gray-100 text-gray-700">
                                                                @if($user->is_active)
                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                                                    </svg>
                                                                    Nonaktifkan
                                                                @else
                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                    Aktifkan
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                            Tidak ada data user
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
                                    class="z-10 flex items-center justify-center px-3 py-2 text-xs leading-tight border text-lime-600 bg-lime-50 border-lime-300 hover:bg-lime-100 hover:text-lime-700">3</a>
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
@endsection
