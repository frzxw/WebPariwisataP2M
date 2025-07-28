    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-darkGreen rounded-lg sm:hidden hover:bg-whiteGreen focus:outline-none focus:ring-2 focus:ring-gray-200">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-56 h-[100vh] sm:h-[90vh] transition-transform -translate-x-full sm:translate-x-0 sm:mx-2 md:mx-4 sm:my-6 sm:rounded-[20px] shadow-md sm:shadow-none overflow-hidden"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-white flex flex-col justify-between w-full">
            <div>
                <a href="#" class="flex justify-center mx-auto mt-6 md:mt-10 mb-5">
                    <img src="{{ asset('images/admin/logo-upi.webp') }}" class="h-8 sm:h-10" alt="UPI Logo" />
                </a>
                <ul class="space-y-2 font-poppins font-medium">
                    <li>
                        <a href="/admin/dashboard"
                            class="flex items-center p-2 text-darkGreen rounded-lg group {{ request()->is('admin/dashboard*') ? 'bg-[#f0f2ea]' : 'hover:bg-whiteGreen' }} ">
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
                        <a href="/admin/transactions"
                            class="flex items-center p-2 text-darkGreen rounded-lg {{ request()->is('admin/transactions*') ? 'bg-[#f0f2ea]' : 'hover:bg-whiteGreen' }} group">
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
                        <a href="/admin/users"
                            class="flex items-center p-2 text-darkGreen rounded-lg {{ request()->is('admin/users*') ? 'bg-[#f0f2ea]' : 'hover:bg-whiteGreen' }} group">
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
                        <a href="/admin/items"
                            class="flex items-center p-2 text-darkGreen rounded-lg {{ request()->is('admin/items*') ? 'bg-[#f0f2ea]' : 'hover:bg-whiteGreen' }} group">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-darkGreen"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 18 18">
                                <path
                                    d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Barang</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="font-poppins mx-2">
                <div class="flex space-x-2 items-center mb-6">
                    <img src="https://placehold.co/100x100" alt="" class="rounded-full size-10">
                    <div class="flex flex-col space-y-1">
                        <span class="text-sm font-medium">Dudul Abdul Kasim</span>
                        <span class="text-[10px] px-2 py-[2px] bg-[#FFCD71] rounded-[18px] w-fit">Admin</span>
                    </div>
                </div>
                <div class="mb-2 flex flex-col items-start">
                    <a href=""
                        class="flex items-center text-sm mb-2 hover:bg-gray-100 w-full px-1 py-2 rounded-md">
                        <svg class="size-5 me-1" width="12" height="13" viewBox="0 0 12 13" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.9375 3.63479C10.1093 3.73253 10.252 3.87428 10.3509 4.04547C10.4498 4.21666 10.5012 4.41111 10.5 4.60879V8.25079C10.5 8.65529 10.2785 9.0283 9.921 9.2248L6.546 11.3598C6.37868 11.4517 6.19088 11.4998 6 11.4998C5.80912 11.4998 5.62132 11.4517 5.454 11.3598L2.079 9.2248C1.90408 9.12921 1.75806 8.98838 1.65621 8.81703C1.55435 8.64569 1.5004 8.45013 1.5 8.25079V4.60829C1.5 4.20379 1.7215 3.83129 2.079 3.63479L5.454 1.64479C5.62627 1.54981 5.81978 1.5 6.0165 1.5C6.21322 1.5 6.40673 1.54981 6.579 1.64479L9.954 3.63479H9.9375Z"
                                stroke="#7D7D7D" stroke-width="0.9375" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M4.5 6.4998C4.5 6.89763 4.65804 7.27916 4.93934 7.56046C5.22064 7.84177 5.60218 7.9998 6 7.9998C6.39782 7.9998 6.77936 7.84177 7.06066 7.56046C7.34196 7.27916 7.5 6.89763 7.5 6.4998C7.5 6.10198 7.34196 5.72045 7.06066 5.43914C6.77936 5.15784 6.39782 4.9998 6 4.9998C5.60218 4.9998 5.22064 5.15784 4.93934 5.43914C4.65804 5.72045 4.5 6.10198 4.5 6.4998Z"
                                stroke="#7D7D7D" stroke-width="0.9375" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Pengaturan
                    </a>
                    <a href=""
                        class="flex items-center text-sm text-red-700 hover:bg-gray-100 w-full px-1 py-2 rounded-md">
                        <svg class="size-5 me-1" width="12" height="12" viewBox="0 0 12 12" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 4V3C7 2.73478 6.89464 2.48043 6.70711 2.29289C6.51957 2.10536 6.26522 2 6 2H2.5C2.23478 2 1.98043 2.10536 1.79289 2.29289C1.60536 2.48043 1.5 2.73478 1.5 3V9C1.5 9.26522 1.60536 9.51957 1.79289 9.70711C1.98043 9.89464 2.23478 10 2.5 10H6C6.26522 10 6.51957 9.89464 6.70711 9.70711C6.89464 9.51957 7 9.26522 7 9V8M4.5 6H10.5M10.5 6L9 4.5M10.5 6L9 7.5"
                                stroke="#B01212" stroke-width="0.9375" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Keluar
                    </a>
                </div>
            </div>
        </div>
    </aside>
