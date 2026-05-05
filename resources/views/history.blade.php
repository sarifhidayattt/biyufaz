<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Booking - Biyufaz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        futsal: {
                            dark: '#00382B',
                            primary: '#00684A',
                            secondary: '#00A86B',
                            light: '#E9F5F2',
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 pb-[72px] md:pb-0">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-futsal-primary rounded-full flex items-center justify-center shadow-md">
                        <span class="font-bold text-xl text-white">F</span>
                    </div>
                    <span class="font-bold text-xl text-futsal-dark">Biyufaz</span>
                </a>
                
                <div class="hidden md:flex space-x-8 font-medium">
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-futsal-primary transition">Beranda</a>
                    <a href="{{ url('/venues') }}" class="text-gray-500 hover:text-futsal-primary transition">Lapangan</a>
                    <!-- Menu Aktif -->
                    <a href="{{ url('/history') }}" class="text-futsal-primary font-bold border-b-2 border-futsal-primary pb-1">Riwayat</a> 
                </div>

                <div class="flex items-center gap-4">
                    <span class="text-sm font-bold text-futsal-dark">Hi, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-futsal-dark">Riwayat Pemesanan</h1>
            <a href="{{ url('/venues') }}" class="bg-futsal-primary hover:bg-futsal-dark text-white px-5 py-2 rounded-lg text-sm font-bold transition shadow-md">
                + Booking Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                <i class="fa-solid fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @if($bookings->isEmpty())
                <!-- Tampilan Jika Belum Ada Booking -->
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 text-3xl">
                        <i class="fa-regular fa-calendar-xmark"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Riwayat</h3>
                    <p class="text-gray-500 mb-6">Anda belum pernah melakukan pemesanan lapangan.</p>
                    <a href="{{ url('/venues') }}" class="text-futsal-primary font-bold hover:underline">Cari Lapangan Sekarang</a>
                </div>
            @else
                <!-- Tabel Riwayat -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-futsal-light text-futsal-dark font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Detail Lapangan</th>
                                <th class="px-6 py-4">Jadwal Main</th>
                                <th class="px-6 py-4">Total Harga</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-mono text-xs text-gray-400">#{{ $booking->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0">
                                            <img src="{{ $booking->venue->image }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $booking->venue->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $booking->court_type }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</p>
                                    <p class="text-xs text-futsal-primary font-semibold">
                                        {{ implode(', ', $booking->time_slots) }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-800">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($booking->status == 'paid')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fa-solid fa-check-circle mr-1"></i> Lunas
                                        </span>
                                    @elseif($booking->status == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fa-solid fa-clock mr-1"></i> Menunggu
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fa-solid fa-circle-xmark mr-1"></i> Batal
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col gap-2 items-center">
                                        @if($booking->status == 'pending')
                                            <!-- Jika Pending, Munculkan Tombol Bayar -->
                                            <a href="{{ route('booking.payment', $booking->id) }}" class="bg-futsal-secondary hover:bg-futsal-primary text-white px-4 py-2 rounded text-xs font-bold shadow-sm transition w-full text-center">
                                                Bayar
                                            </a>
                                        @elseif($booking->status == 'paid')
                                            <a href="{{ route('booking.ticket', $booking->id) }}" class="bg-futsal-primary hover:bg-futsal-dark text-white px-4 py-2 rounded text-xs font-bold shadow-sm transition w-full text-center inline-flex items-center justify-center gap-1.5">
                                                <i class="fa-solid fa-ticket"></i> Lihat Tiket
                                            </a>
                                        @endif

                                        @php
                                            $canCancel = false;
                                            if (in_array($booking->status, ['pending', 'dp'])) {
                                                $bDate = \Carbon\Carbon::parse($booking->booking_date)->startOfDay();
                                                $now = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->startOfDay();
                                                if ($now->lessThan($bDate)) {
                                                    $canCancel = true;
                                                }
                                            }
                                        @endphp

                                        @if($canCancel)
                                            <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" class="w-full" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Jika Anda sudah melakukan DP, silakan hubungi admin untuk proses refund.')">
                                                @csrf
                                                <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 px-4 py-2 rounded text-xs font-bold shadow-sm transition w-full">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- FOOTER SIMPLE -->
    <footer class="bg-white mt-12 border-t border-gray-200 py-6 text-center text-sm text-gray-500">
        <p>&copy; 2024 Biyufaz. All rights reserved.</p>
    </footer>

    <!-- MOBILE BOTTOM NAVIGATION -->
    <div class="md:hidden fixed bottom-0 left-0 w-full bg-white shadow-[0_-4px_20px_rgba(0,0,0,0.1)] z-[100] border-t border-gray-100 flex justify-around items-center py-3 px-2">
        <a href="{{ url('/') }}" class="flex flex-col items-center gap-1 {{ request()->is('/') ? 'text-futsal-primary' : 'text-gray-500 hover:text-futsal-primary' }}">
            <i class="fa-solid fa-house text-lg"></i>
            <span class="text-[10px] font-semibold">Beranda</span>
        </a>
        <a href="{{ url('/venues') }}" class="flex flex-col items-center gap-1 {{ request()->is('venues') ? 'text-futsal-primary' : 'text-gray-500 hover:text-futsal-primary' }}">
            <i class="fa-solid fa-map-location-dot text-lg"></i>
            <span class="text-[10px] font-semibold">Lapangan</span>
        </a>
        <a href="{{ url('/about') }}" class="flex flex-col items-center gap-1 {{ request()->is('about') ? 'text-futsal-primary' : 'text-gray-500 hover:text-futsal-primary' }}">
            <i class="fa-solid fa-circle-info text-lg"></i>
            <span class="text-[10px] font-semibold">Tentang</span>
        </a>
        <a href="{{ url('/contact') }}" class="flex flex-col items-center gap-1 {{ request()->is('contact') ? 'text-futsal-primary' : 'text-gray-500 hover:text-futsal-primary' }}">
            <i class="fa-solid fa-address-book text-lg"></i>
            <span class="text-[10px] font-semibold">Kontak</span>
        </a>
        @auth
        <a href="{{ url('/profile') }}" class="flex flex-col items-center gap-1 {{ request()->is('profile') ? 'text-futsal-primary' : 'text-gray-500 hover:text-futsal-primary' }}">
            <i class="fa-solid fa-user text-lg"></i>
            <span class="text-[10px] font-semibold">Profil</span>
        </a>
        @endauth
    </div>

</body>
</html>