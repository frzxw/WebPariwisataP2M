@extends('layouts.admin')

@section('title', 'Transaksi')
@section('content')
    <div class="px-4 py-8 sm:ml-56">
        <div class="md:mx-8 mb-6">
            <h1 class="font-poppins font-semibold text-2xl text-gray-900 mb-2">Dashboard</h1>
            <p class="text-sm text-gray-600">Kelola dan pantau semua transaksi pembayaran kavling wisata</p>
        </div>
        <div class="md:mx-8 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mx-auto w-full font-poppins">
                <div class="bg-[#5F8F68] rounded-[20px] text-white px-6 py-8 shadow-lg">
                    <p>Total Transaksi</p>
                    <span class="text-3xl font-medium">50</span>
                </div>
                <div class="bg-[#D69C45] rounded-[20px] text-white px-6 py-8 shadow-lg">
                    <p>Total Pelanggan</p>
                    <span class="text-3xl font-medium">50</span>
                </div>
                <div class="bg-[#729CA1] rounded-[20px] text-white px-6 py-8 shadow-lg">
                    <p>Total Pendapatan</p>
                    <span class="text-3xl font-medium">Rp50.000.000</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 font-poppins md:px-8">
            {{-- Calendar --}}
            <div class="bg-white px-4 py-6 rounded-2xl shadow-xl">
                <p class="font-medium mb-3">Daftar Booking</p>

                <div class="w-full min-h-[230px] max-h-[380px] space-y-3 overflow-auto">
                    <div class="space-y-1">
                        <div class="mb-2 px-2">
                            <p class="text-sm mb-1">Agustus</p>
                            <hr>
                        </div>
                        <div class="bg-[#ECEFEC] rounded-2xl px-6 py-4">
                            <p class="font-medium">Kavling A1</p>
                            <p class="text-sm">Rumi</p>
                            <p class="text-[#7D7D7D] text-sm">Dipesan tanggal 10 Agustus 2025</p>
                        </div>
                        <div class="bg-[#ECEFEC] rounded-2xl px-6 py-4">
                            <p class="font-medium">Kavling A2</p>
                            <p class="text-sm">Joey</p>
                            <p class="text-[#7D7D7D] text-sm">Dipesan tanggal 11 Agustus 2025</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <div class="mb-2 px-2">
                            <span class="text-sm">September</span>
                            <hr>
                        </div>
                        <div class="bg-[#ECEFEC] rounded-2xl px-6 py-4">
                            <p class="font-medium">Kavling A1</p>
                            <p class="text-sm">Rumi</p>
                            <p class="text-[#7D7D7D] text-sm">Dipesan tanggal 10 September 2025</p>
                        </div>
                        <div class="bg-[#ECEFEC] rounded-2xl px-6 py-4">
                            <p class="font-medium">Kavling A2</p>
                            <p class="text-sm">Joey</p>
                            <p class="text-[#7D7D7D] text-sm">Dipesan tanggal 11 September 2025</p>
                        </div>
                        <div class="bg-[#ECEFEC] rounded-2xl px-6 py-4">
                            <p class="font-medium">Kavling B2</p>
                            <p class="text-sm">Upin</p>
                            <p class="text-[#7D7D7D] text-sm">Dipesan tanggal 11 September 2025</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <div class="mb-2 px-2">
                            <span class="text-sm">Desember</span>
                            <hr>
                        </div>
                        <div class="bg-[#ECEFEC] rounded-2xl px-6 py-4">
                            <p class="font-medium">Kavling A1</p>
                            <p class="text-sm">Rumi</p>
                            <p class="text-[#7D7D7D] text-sm">Dipesan tanggal 10 Desember 2025</p>
                        </div>
                        <div class="bg-[#ECEFEC] rounded-2xl px-6 py-4">
                            <p class="font-medium">Kavling A2</p>
                            <p class="text-sm">Joey</p>
                            <p class="text-[#7D7D7D] text-sm">Dipesan tanggal 11 Desember 2025</p>
                        </div>
                        <div class="bg-[#ECEFEC] rounded-2xl px-6 py-4">
                            <p class="font-medium">Kavling B2</p>
                            <p class="text-sm">Upin</p>
                            <p class="text-[#7D7D7D] text-sm">Dipesan tanggal 11 Desember 2025</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white px-4 py-6 md:col-span-3 rounded-2xl shadow-xl">
                    <p class="font-medium">Transaksi</p>

                    <div class="w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6 min-h-[230px]">
                        <div id="line-chart"></div>
                    </div>
                </div>
                <div class="bg-white px-4 py-6 rounded-2xl shadow-xl flex flex-col justify-between">
                    <p class="text-[#7D7D7D] font-medium text-sm">Top month</p>
                    <div>
                        <p class="text-xl text-baseGreen font-semibold">July</p>
                        <p class="text-[#A3B18A] text-sm">2025</p>
                    </div>
                </div>
                <div class="bg-white px-4 py-6 rounded-2xl shadow-xl flex flex-col justify-between">
                    <p class="text-[#7D7D7D] font-medium text-sm">Top year</p>
                    <div>
                        <p class="text-xl text-baseGreen font-semibold">2024</p>
                        <p class="text-[#A3B18A] text-sm">89 Terjual</p>
                    </div>
                </div>
                <div class="bg-white px-4 py-6 rounded-2xl shadow-xl flex flex-col justify-between">
                    <p class="text-[#7D7D7D] font-medium text-sm mb-1">Top Users</p>
                    <div>
                        <img src="https://placehold.co/100x100" alt="" class="rounded-full size-8 mb-1">
                        <p class="text-sm font-medium">Dudul Abdul Kasim</p>
                        <p class="text-[#454545] text-sm">081290310130</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const options = {
                chart: {
                    height: "100%",
                    maxWidth: "100%",
                    type: "line",
                    fontFamily: "Poppins, sans-serif",
                    dropShadow: {
                        enabled: false,
                    },
                    toolbar: {
                        show: false,
                    },
                },
                tooltip: {
                    enabled: false,
                    x: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: 6,
                },
                grid: {
                    show: true,
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                    },
                },
                series: [{
                    name: "Total Transaksi",
                    data: [10, 12, 20, 10, 20, 30],
                    color: "#65a30d",
                }],
                legend: {
                    show: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: ['Agu', 'Sep', 'Okt', 'Nov', 'Des', 'Jan'],
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Poppins, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                        }
                    },
                    axisBorder: {
                        show: true,
                    },
                    axisTicks: {
                        show: true,
                    },
                },
                yaxis: {
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Poppins, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                        }
                    },
                    axisBorder: {
                        show: true,
                    },
                    axisTicks: {
                        show: true,
                    },
                },
            }

            if (document.getElementById("line-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("line-chart"), options);
                chart.render();
            }


        });
    </script>
@endpush
