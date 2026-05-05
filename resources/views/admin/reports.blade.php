<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Admin - Biyufaz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; letter-spacing: -0.01em; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .print-only { display: block !important; }
            .main-container { padding: 0 !important; max-width: 100% !important; }
            .card { border: 1px solid #f1f5f9 !important; shadow: none !important; }
        }

        .sidebar-item-active {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border-right: 3px solid #10b981;
        }
    </style>
</head>
<body class="bg-[#F1F5F9] text-slate-900">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR (No Print) -->
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
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800/50 hover:text-white rounded-xl transition-all duration-200 group">
                            <i class="fa-solid fa-house-chimney mr-3 text-sm opacity-50 group-hover:opacity-100"></i> 
                            <span class="text-sm font-semibold">Dashboard</span>
                        </a>
                        <a href="{{ route('admin.venues.index') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800/50 hover:text-white rounded-xl transition-all duration-200 group">
                            <i class="fa-solid fa-map-location-dot mr-3 text-sm opacity-50 group-hover:opacity-100"></i> 
                            <span class="text-sm font-semibold">Kelola Lapangan</span>
                        </a>
                        <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 sidebar-item-active rounded-l-xl transition-all duration-200">
                            <i class="fa-solid fa-chart-line mr-3 text-sm"></i> 
                            <span class="text-sm font-bold">Laporan Analitik</span>
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

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto custom-scrollbar no-print">
            <div class="p-6 lg:p-10 max-w-[1600px] mx-auto">
                
                <!-- HEADER -->
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-6">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Laporan Penjualan</h2>
                        <p class="text-slate-500 text-sm mt-1">Data statistik pesanan dan pendapatan lapangan</p>
                    </div>
                    <div class="flex items-center gap-3 no-print">
                        <button onclick="window.print()" class="bg-white border border-slate-200 text-slate-700 px-5 py-2.5 rounded-xl font-bold hover:bg-slate-50 transition-all text-sm flex items-center shadow-sm">
                            <i class="fa-solid fa-print mr-2 opacity-50"></i> Cetak Laporan
                        </button>
                        <a href="{{ route('admin.reports.export', ['start_date' => $startDate, 'end_date' => $endDate, 'status' => $status]) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all text-sm flex items-center shadow-lg shadow-green-600/20">
                            <i class="fa-solid fa-file-excel mr-2"></i> Export Excel (CSV)
                        </a>
                    </div>
                </div>

                <!-- FILTER -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8 no-print">
                    <form action="{{ route('admin.reports') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" 
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" 
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Status</label>
                            <div class="relative">
                                <select name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all appearance-none">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="dp" {{ $status == 'dp' ? 'selected' : '' }}>DP (Sebagian)</option>
                                    <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Lunas</option>
                                    <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[10px]"></i>
                            </div>
                        </div>
                        <button type="submit" class="bg-slate-900 hover:bg-black text-white py-2.5 rounded-xl font-bold transition-all shadow-lg text-sm">
                            <i class="fa-solid fa-filter mr-2"></i> Terapkan
                        </button>
                    </form>
                </div>

                <!-- STATS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center text-sm">
                                <i class="fa-solid fa-shopping-cart"></i>
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Pesanan</p>
                        </div>
                        <h3 class="text-3xl font-black text-slate-900">{{ $totalBookings }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">Dalam Periode Ini</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-sm">
                                <i class="fa-solid fa-sack-dollar"></i>
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Omzet Lunas</p>
                        </div>
                        <h3 class="text-3xl font-black text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        <p class="text-[10px] font-bold text-green-500 mt-1 uppercase tracking-tighter">Pendapatan Masuk</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Masih Pending</p>
                        </div>
                        <h3 class="text-3xl font-black text-slate-900">{{ $pendingBookings }}</h3>
                        <p class="text-[10px] font-bold text-amber-500 mt-1 uppercase tracking-tighter">Menunggu Konfirmasi</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-sm">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pesanan Batal</p>
                        </div>
                        <h3 class="text-3xl font-black text-slate-900">{{ $cancelledBookings }}</h3>
                        <p class="text-[10px] font-bold text-red-400 mt-1 uppercase tracking-tighter">Total Pembatalan</p>
                    </div>
                </div>

                <!-- CHARTS -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    <div class="lg:col-span-2 bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Tren Pendapatan</h3>
                                <p class="text-xs text-slate-500 mt-1 italic">Pergerakan omzet harian</p>
                            </div>
                            <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-lg">LIVE</span>
                        </div>
                        <div class="h-[300px]">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Pangsa Pasar Venue</h3>
                        <p class="text-xs text-slate-500 mb-8 italic">Distribusi pendapatan per venue</p>
                        <div class="h-[240px] relative">
                            <canvas id="venueChart"></canvas>
                        </div>
                        <div class="mt-8 space-y-3">
                            @foreach($revenueByVenue->take(4) as $index => $v)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'][$index % 4] }}"></span>
                                    <span class="text-[11px] font-bold text-slate-600 truncate max-w-[140px]">{{ $v['name'] }}</span>
                                </div>
                                <span class="text-[11px] font-black text-slate-900">Rp {{ number_format($v['total'], 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
                        <h3 class="text-lg font-bold text-slate-900">Log Pesanan Detail</h3>
                        <div class="flex items-center gap-3 no-print">
                            <div class="relative">
                                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input type="text" id="tableSearch" placeholder="Cari nama pemesan..." 
                                       class="pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all w-64">
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left" id="reportTable">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100">Info Booking</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100">Customer</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100 text-center">Jadwal</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100 text-right">Total Bayar</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($bookings as $booking)
                                <tr class="hover:bg-slate-50/50 transition-all duration-200 group report-row">
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-green-600 mb-1">ID: #{{ $booking->order_id }}</span>
                                            <span class="font-bold text-slate-900 text-sm leading-tight">{{ $booking->venue->name ?? 'Venue Dihapus' }}</span>
                                            <span class="text-[10px] text-slate-400 mt-1 font-bold uppercase tracking-widest">{{ $booking->court->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-black text-[10px] uppercase">
                                                {{ substr($booking->customer_name, 0, 1) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800 text-sm name-target">{{ $booking->customer_name }}</span>
                                                <div class="flex items-center gap-3 mt-0.5">
                                                    <span class="text-[10px] text-slate-500"><i class="fa-solid fa-phone mr-1.5 text-slate-300"></i>{{ $booking->customer_phone }}</span>
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->customer_phone) }}" target="_blank" class="text-[9px] text-green-500 font-black hover:underline flex items-center gap-1">
                                                        <i class="fa-brands fa-whatsapp text-[10px]"></i> WA
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <span class="text-xs font-bold text-slate-700 block mb-1">
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}
                                        </span>
                                        <div class="flex flex-wrap justify-center gap-1">
                                            @foreach($booking->time_slots as $slot)
                                            <span class="bg-white border border-slate-200 text-slate-600 px-1.5 py-0.5 rounded text-[8px] font-black">{{ $slot }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <span class="font-black text-slate-900 text-sm">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                        @if($booking->amount_paid > 0)
                                        <p class="text-[9px] font-black text-green-500 mt-1 uppercase tracking-tighter">Masuk: Rp {{ number_format($booking->amount_paid, 0, ',', '.') }}</p>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex justify-center">
                                            @php
                                                $style = match($booking->status) {
                                                    'paid' => 'bg-green-500 text-white',
                                                    'dp' => 'bg-blue-500 text-white',
                                                    'pending' => 'bg-amber-400 text-amber-950',
                                                    'cancelled' => 'bg-slate-200 text-slate-500',
                                                    default => 'bg-slate-100 text-slate-400'
                                                };
                                                $label = match($booking->status) {
                                                    'paid' => 'LUNAS',
                                                    'dp' => 'DP MASUK',
                                                    'pending' => 'PENDING',
                                                    'cancelled' => 'BATAL',
                                                    default => '?'
                                                };
                                            @endphp
                                            <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $style }} shadow-sm">
                                                {{ $label }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center text-slate-400">
                                        <i class="fa-solid fa-inbox text-4xl mb-3 opacity-20"></i>
                                        <p class="text-sm font-bold">Data tidak ditemukan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="mt-20 border-t border-slate-200 pt-10 text-center pb-20">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Sistem Manajemen Biyufaz</p>
                    <p class="text-slate-300 text-[9px] mt-2 italic">Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
                </div>
            </div>
        </main>
    </div>

    <!-- MOBILE NAV -->
    <div class="lg:hidden fixed bottom-6 left-6 right-6 bg-[#0F172A] rounded-2xl shadow-2xl z-[100] border border-white/5 flex justify-around items-center py-4 px-6 no-print">
        <a href="{{ route('admin.dashboard') }}" class="text-slate-500">
            <i class="fa-solid fa-house-chimney text-lg"></i>
        </a>
        <a href="{{ route('admin.reports') }}" class="text-green-500">
            <i class="fa-solid fa-chart-pie text-lg"></i>
        </a>
        <a href="{{ route('admin.venues.index') }}" class="text-slate-500">
            <i class="fa-solid fa-map-location-dot text-lg"></i>
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            const trendData = @json($trendData);
            
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: trendData.map(d => d.date),
                    datasets: [{
                        label: 'Omzet',
                        data: trendData.map(d => d.total),
                        borderColor: '#10b981',
                        backgroundColor: (context) => {
                            const ctx = context.chart.ctx;
                            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.15)');
                            gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');
                            return gradient;
                        },
                        borderWidth: 4,
                        pointRadius: 3,
                        pointBackgroundColor: '#fff',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 9, weight: 'bold' }, callback: v => 'Rp ' + (v/1000) + 'k' }
                        },
                        x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' } } }
                    }
                }
            });

            const venueCtx = document.getElementById('venueChart').getContext('2d');
            const venueData = @json($revenueByVenue);
            
            new Chart(venueCtx, {
                type: 'doughnut',
                data: {
                    labels: venueData.map(v => v.name),
                    datasets: [{
                        data: venueData.map(v => v.total),
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6'],
                        borderWidth: 4,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: { legend: { display: false } }
                }
            });

            const searchInput = document.getElementById('tableSearch');
            const tableRows = document.querySelectorAll('.report-row');

            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                tableRows.forEach(row => {
                    const name = row.querySelector('.name-target').textContent.toLowerCase();
                    row.style.display = name.includes(query) ? '' : 'none';
                });
            });
        });
    </script>
</body>
</html>
