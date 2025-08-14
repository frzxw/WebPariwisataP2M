@extends('admin.layouts.admin')

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
                    <span class="text-3xl font-medium">{{ number_format($totalBookings) }}</span>
                </div>
                <div class="bg-[#D69C45] rounded-[20px] text-white px-6 py-8 shadow-lg">
                    <p>Total Pelanggan</p>
                    <span class="text-3xl font-medium">{{ number_format($totalUsers) }}</span>
                </div>
                <div class="bg-[#729CA1] rounded-[20px] text-white px-6 py-8 shadow-lg">
                    <p>Total Pendapatan</p>
                    <span class="text-3xl font-medium">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 font-poppins md:px-8">
            {{-- Recent Bookings --}}
            <div class="bg-white px-4 py-6 rounded-2xl shadow-xl">
                <p class="font-medium mb-3">Booking Terbaru</p>

                <div class="w-full min-h-[230px] max-h-[380px] space-y-3 overflow-auto">
                    @if($recentBookings->count() > 0)
                        @php
                            $groupedBookings = $recentBookings->groupBy(function($booking) {
                                return $booking->created_at->format('F Y');
                            });
                        @endphp
                        
                        @foreach($groupedBookings as $monthYear => $bookings)
                            <div class="space-y-1">
                                <div class="mb-2 px-2">
                                    <p class="text-sm mb-1">{{ $monthYear }}</p>
                                    <hr>
                                </div>
                                @foreach($bookings as $booking)
                                    <div class="bg-[#ECEFEC] rounded-2xl px-6 py-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium">{{ $booking->booking_code }}</p>
                                                <p class="text-sm">{{ $booking->user->name }}</p>
                                                <p class="text-[#7D7D7D] text-sm">Dipesan {{ $booking->created_at->format('d F Y') }}</p>
                                                @if($booking->campingPlot)
                                                    <p class="text-xs text-gray-500">
                                                        Plot: {{ $booking->campingPlot->plot_number }}
                                                    </p>
                                                @endif
                                                <p class="text-xs font-semibold text-green-600">
                                                    Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                                @else bg-blue-100 text-blue-800
                                                @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Belum ada booking</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white px-4 py-6 md:col-span-3 rounded-2xl shadow-xl">
                    <p class="font-medium">Transaksi</p>

                    <div class="w-full bg-white rounded-lg shadow-sm p-4 md:p-6 min-h-[230px]">
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
                    name: "Pendapatan",
                    data: [
                        @if(isset($monthlyRevenue) && $monthlyRevenue->count() > 0)
                            @foreach($monthlyRevenue as $revenue)
                                {{ $revenue->revenue }},
                            @endforeach
                        @else
                            0, 0, 0, 0, 0, 0
                        @endif
                    ],
                    color: "#65a30d",
                }],
                legend: {
                    show: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: [
                        @if(isset($monthlyRevenue) && $monthlyRevenue->count() > 0)
                            @foreach($monthlyRevenue as $revenue)
                                '{{ \Carbon\Carbon::create($revenue->year, $revenue->month)->format('M Y') }}',
                            @endforeach
                        @else
                            'Agu', 'Sep', 'Okt', 'Nov', 'Des', 'Jan'
                        @endif
                    ],
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Poppins, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 '
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
                            cssClass: 'text-xs font-normal fill-gray-500 '
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
