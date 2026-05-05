<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMIN - Biyufaz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; letter-spacing: -0.01em; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        
        .sidebar-item-active {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border-right: 3px solid #10b981;
        }
        
        .status-pulse {
            animation: pulse-green 2s infinite;
        }
        
        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
    </style>
</head>
<body class="bg-[#F1F5F9] text-slate-900">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR -->
        <aside class="w-64 bg-[#0F172A] text-white flex flex-col hidden lg:flex no-print shrink-0 shadow-2xl">
            <div class="h-20 flex items-center px-6 border-b border-slate-800/50">
                <div class="w-10 h-10 bg-green-500 rounded-xl mr-3 flex items-center justify-center shadow-lg shadow-green-500/20">
                    <i class="fa-solid fa-bolt text-white text-lg"></i>
                </div>
                <h1 class="text-xl font-extrabold tracking-tight">Biyufaz</h1>
            </div>
            
            <div class="flex-1 py-6 custom-scrollbar overflow-y-auto">
                <div class="px-4 mb-6">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4 px-2">Menu Utama</p>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 sidebar-item-active rounded-l-xl transition-all duration-200">
                            <i class="fa-solid fa-house-chimney mr-3 text-sm"></i> 
                            <span class="text-sm font-bold">Dashboard</span>
                        </a>
                        <a href="{{ route('admin.venues.index') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800/50 hover:text-white rounded-xl transition-all duration-200 group">
                            <i class="fa-solid fa-map-location-dot mr-3 text-sm opacity-50 group-hover:opacity-100"></i> 
                            <span class="text-sm font-semibold">Kelola Lapangan</span>
                        </a>
                        <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800/50 hover:text-white rounded-xl transition-all duration-200 group">
                            <i class="fa-solid fa-chart-line mr-3 text-sm opacity-50 group-hover:opacity-100"></i> 
                            <span class="text-sm font-semibold">Laporan Analitik</span>
                        </a>
                    </nav>
                </div>

                <div class="px-4 mb-6">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4 px-2">Konfigurasi</p>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.payment_methods.index') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800/50 hover:text-white rounded-xl transition-all duration-200 group">
                            <i class="fa-solid fa-wallet mr-3 text-sm opacity-50 group-hover:opacity-100"></i> 
                            <span class="text-sm font-semibold">Metode Bayar</span>
                        </a>
                    </nav>
                </div>
            </div>

            <div class="p-6 border-t border-slate-800/50">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center justify-center px-4 py-3 text-slate-500 hover:text-red-400 rounded-xl transition-all font-bold text-xs bg-slate-800/30">
                        <i class="fa-solid fa-power-off mr-2"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT (Operational View) -->
        <main class="flex-1 overflow-y-auto custom-scrollbar">
            
            <!-- TOP BAR -->
            <div class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-30 shadow-sm">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-2 px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-full status-pulse">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        SISTEM AKTIF
                    </span>
                    <span class="text-slate-300">|</span>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <div class="flex items-center gap-6">
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase leading-none">Admin Area</p>
                        <p class="text-xs font-bold text-slate-700 mt-1 uppercase">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-black text-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            <div class="p-6 lg:p-8 max-w-[1600px] mx-auto">
                
                @if(session('success'))
                <div class="bg-green-600 text-white px-6 py-4 rounded-2xl mb-8 flex items-center justify-between shadow-lg shadow-green-600/20">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-check-circle text-xl"></i>
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="opacity-50 hover:opacity-100"><i class="fa-solid fa-xmark"></i></button>
                </div>
                @endif

                <!-- QUICK STATS (OPERATIONAL) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Pesanan Hari Ini</p>
                        <div class="flex items-end justify-between">
                            <h3 class="text-3xl font-black text-slate-900">{{ $bookings->where('created_at', '>=', now()->startOfDay())->count() }}</h3>
                            <span class="text-[10px] font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg">LIVE</span>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Butuh Konfirmasi</p>
                        <div class="flex items-end justify-between">
                            <h3 class="text-3xl font-black {{ $bookings->where('status', 'pending')->count() > 0 ? 'text-amber-500' : 'text-slate-900' }}">
                                {{ $bookings->where('status', 'pending')->count() }}
                            </h3>
                            <i class="fa-solid fa-clock-rotate-left text-slate-200 text-2xl"></i>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Omzet Tunai/DP</p>
                        <div class="flex items-end justify-between">
                            <h3 class="text-2xl font-black text-slate-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Main 1 Jam Lagi</p>
                        <div class="flex items-end justify-between">
                            <h3 class="text-3xl font-black text-green-600">{{ $upcomingBookings->count() }}</h3>
                            <i class="fa-solid fa-running text-slate-200 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <!-- LEFT COLUMN: LIVE FEED (COMMAND CENTER STYLE) -->
                    <div class="lg:col-span-8 space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-[750px]">
                            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                                <h3 class="font-black text-slate-800 text-sm flex items-center gap-2">
                                    <i class="fa-solid fa-list-ul text-green-500"></i>
                                    MONITOR PESANAN MASUK
                                </h3>
                                <div class="flex items-center gap-4">
                                    <span class="text-[10px] font-bold text-slate-400 italic">Auto-refresh aktif</span>
                                </div>
                            </div>
                            <div class="flex-1 overflow-y-auto custom-scrollbar">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-white sticky top-0 z-10">
                                        <tr class="border-b border-slate-100">
                                            <th class="px-6 py-3 text-[10px] font-black text-slate-400 uppercase">Waktu / Konsumen</th>
                                            <th class="px-6 py-3 text-[10px] font-black text-slate-400 uppercase">Venue / Lapangan</th>
                                            <th class="px-6 py-3 text-[10px] font-black text-slate-400 uppercase text-right">Pembayaran</th>
                                            <th class="px-6 py-3 text-[10px] font-black text-slate-400 uppercase text-center">Status / Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @forelse($bookings->sortByDesc('created_at')->take(30) as $booking)
                                        <tr class="hover:bg-slate-50/80 transition-all group">
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    <span class="text-[9px] font-black text-green-600 mb-0.5 uppercase">{{ $booking->created_at->diffForHumans() }}</span>
                                                    <span class="font-bold text-slate-800 text-sm truncate max-w-[150px]">{{ $booking->customer_name }}</span>
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->customer_phone) }}" target="_blank" class="text-[10px] text-green-500 font-black hover:underline mt-1 flex items-center gap-1">
                                                        <i class="fa-brands fa-whatsapp"></i> HUBUNGI WA
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-slate-700 text-xs">{{ $booking->venue->name ?? '-' }}</span>
                                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $booking->court->name ?? '-' }}</span>
                                                    <span class="text-[9px] font-black text-slate-900 mt-1">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M') }} | {{ implode(',', $booking->time_slots) }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <p class="font-black text-slate-900 text-xs tabular-nums">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $booking->payment_type ?? 'Manual' }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex justify-center">
                                                    <form action="{{ route('admin.updateStatus', $booking->id) }}" method="POST">
                                                        @csrf
                                                        <select name="status" onchange="this.form.submit()" class="text-[9px] font-black px-3 py-1.5 rounded-lg border-2 appearance-none cursor-pointer focus:ring-0
                                                            {{ $booking->status == 'paid' ? 'bg-green-600 text-white border-green-600' : '' }}
                                                            {{ $booking->status == 'pending' ? 'bg-amber-400 text-amber-950 border-amber-400 animate-pulse' : '' }}
                                                            {{ $booking->status == 'dp' ? 'bg-blue-500 text-white border-blue-500' : '' }}
                                                            {{ $booking->status == 'cancelled' ? 'bg-slate-200 text-slate-500 border-slate-200' : '' }}
                                                        ">
                                                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>PENDING</option>
                                                            <option value="dp" {{ $booking->status == 'dp' ? 'selected' : '' }}>DP</option>
                                                            <option value="paid" {{ $booking->status == 'paid' ? 'selected' : '' }}>LUNAS</option>
                                                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>BATAL</option>
                                                        </select>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="py-20 text-center text-slate-300">Belum ada aktivitas</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: ALERTS & SUMMARIES -->
                    <div class="lg:col-span-4 space-y-6">
                        
                        <!-- UPCOMING GAMES (1 HR ALERT) -->
                        <div class="bg-[#0F172A] rounded-2xl shadow-xl p-6 text-white overflow-hidden relative group">
                            <div class="absolute -top-10 -right-10 w-40 h-40 bg-green-500/10 rounded-full blur-3xl group-hover:bg-green-500/20 transition-all"></div>
                            <div class="flex items-center justify-between mb-6 relative">
                                <h3 class="font-black text-sm tracking-widest uppercase">Segera Bermain</h3>
                                <span class="flex h-2 w-2 relative">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                            </div>
                            <div class="space-y-3 relative">
                                @forelse($upcomingBookings->take(5) as $ub)
                                <div class="p-3 bg-slate-800/50 rounded-xl border border-slate-700 hover:border-green-500/50 transition-all">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-[10px] font-black text-green-400 uppercase">{{ $ub->time_slots[0] }}</p>
                                        <p class="text-[10px] font-bold text-slate-500">{{ $ub->court->name ?? '-' }}</p>
                                    </div>
                                    <p class="font-bold text-sm">{{ $ub->customer_name }}</p>
                                </div>
                                @empty
                                <p class="text-center py-4 text-slate-500 text-xs italic">Semua lapangan bersih</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- REVENUE BREAKDOWN (OPERATIONAL RECAP) -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h3 class="font-black text-slate-800 text-xs uppercase tracking-widest mb-6">Rekap Kasir Hari Ini</h3>
                            <div class="space-y-4">
                                @foreach($paymentSummary as $ps)
                                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div>
                                        <span class="text-[10px] font-black text-slate-600 uppercase">{{ $ps->payment_type ?? 'MANUAL' }}</span>
                                    </div>
                                    <span class="text-xs font-black text-slate-900">Rp {{ number_format($ps->total, 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-6 pt-4 border-t border-slate-100">
                                <a href="{{ route('admin.reports') }}" class="w-full py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase flex items-center justify-center gap-2 hover:bg-black transition-all">
                                    Lihat Analitik Lengkap <i class="fa-solid fa-chart-line"></i>
                                </a>
                            </div>
                        </div>

                        <!-- SYSTEM HEALTH -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h3 class="font-black text-slate-800 text-xs uppercase tracking-widest mb-4">Informasi Sistem</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between text-[10px]">
                                    <span class="text-slate-500 font-bold">Total Member</span>
                                    <span class="font-black text-slate-900">{{ $totalUser }} User</span>
                                </div>
                                <div class="flex justify-between text-[10px]">
                                    <span class="text-slate-500 font-bold">Server Time</span>
                                    <span class="font-black text-slate-900">{{ now()->format('H:i') }} WIB</span>
                                </div>
                                <div class="flex justify-between text-[10px]">
                                    <span class="text-slate-500 font-bold">Active Venues</span>
                                    <span class="font-black text-slate-900">{{ $topVenues->count() }} Lokasi</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>