<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Lapangan - Biyufaz Admin</title>
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
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800/50 hover:text-white rounded-xl transition-all duration-200 group">
                            <i class="fa-solid fa-house-chimney mr-3 text-sm opacity-50 group-hover:opacity-100"></i> 
                            <span class="text-sm font-semibold">Dashboard</span>
                        </a>
                        <a href="{{ route('admin.venues.index') }}" class="flex items-center px-4 py-3 sidebar-item-active rounded-l-xl transition-all duration-200">
                            <i class="fa-solid fa-map-location-dot mr-3 text-sm"></i> 
                            <span class="text-sm font-bold">Kelola Lapangan</span>
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

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto custom-scrollbar no-print">
            <div class="p-6 lg:p-10 max-w-[1600px] mx-auto">
                
                <!-- Notifikasi -->
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
                @endif

                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-6">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Lapangan (GOR)</h2>
                        <p class="text-slate-500 text-sm mt-1">Daftar lokasi gedung olahraga dan pengaturan fasilitas</p>
                    </div>
                    <a href="{{ route('admin.venue.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold transition-all text-sm flex items-center shadow-lg shadow-green-600/20 active:scale-95">
                        <i class="fa-solid fa-plus-circle mr-2 text-lg"></i> Tambah Lapangan Baru
                    </a>
                </div>

                <!-- TABLE SECTION -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-white sticky top-0 z-10 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-list-check text-green-500"></i>
                            Daftar Lokasi Terdaftar
                        </h3>
                        <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[10px] font-black rounded-lg uppercase">{{ $venues->count() }} Lokasi</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100">Informasi Lokasi</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100">Spesifikasi</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100">Kapasitas</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100 text-right">Harga Dasar</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($venues as $venue)
                                <tr class="hover:bg-slate-50/50 transition-all duration-200 group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl overflow-hidden shadow-sm bg-slate-100 shrink-0">
                                                @if($venue->image)
                                                    <img src="{{ asset('storage/' . $venue->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                        <i class="fa-solid fa-image text-lg"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-black text-slate-900 text-sm tracking-tight">{{ $venue->name }}</span>
                                                <span class="text-[10px] text-slate-400 mt-1 font-medium truncate max-w-[200px]"><i class="fa-solid fa-location-dot mr-1 text-slate-300"></i>{{ $venue->address }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col gap-1">
                                            <span class="px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg uppercase tracking-wider inline-block self-start">{{ $venue->type }}</span>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-[9px] font-bold text-slate-400"><i class="fa-solid fa-clock mr-1 text-slate-300"></i>{{ substr($venue->operation_start_time, 0, 5) }} - {{ substr($venue->operation_end_time, 0, 5) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                            <span class="text-xs font-black text-slate-700 tracking-tight">{{ $venue->courts->count() }} Sub-Lapangan</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right font-black text-slate-900 text-sm tabular-nums">
                                        Rp {{ number_format($venue->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('admin.venue.edit', $venue->id) }}" class="flex items-center gap-2 bg-white border border-slate-200 hover:border-green-500 hover:text-green-600 text-slate-600 px-4 py-2.5 rounded-xl text-[10px] font-black transition-all shadow-sm active:scale-95">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                EDIT
                                            </a>
                                            <a href="{{ route('admin.venue.courts', $venue->id) }}" class="flex items-center gap-2 bg-slate-900 hover:bg-black text-white px-4 py-2.5 rounded-xl text-[10px] font-black transition-all shadow-lg active:scale-95">
                                                <i class="fa-solid fa-gear text-xs text-green-400"></i>
                                                PENGATURAN
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-24 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-200">
                                                <i class="fa-solid fa-map-location text-4xl"></i>
                                            </div>
                                            <p class="text-slate-400 font-bold">Belum ada lokasi yang terdaftar</p>
                                            <p class="text-xs text-slate-300 mt-1">Klik tombol 'Tambah Lapangan Baru' untuk memulai</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- MOBILE NAV -->
    <div class="lg:hidden fixed bottom-6 left-6 right-6 bg-[#0F172A] rounded-2xl shadow-2xl z-[100] border border-white/5 flex justify-around items-center py-4 px-6 no-print">
        <a href="{{ route('admin.dashboard') }}" class="text-slate-500">
            <i class="fa-solid fa-house-chimney text-lg"></i>
        </a>
        <a href="{{ route('admin.reports') }}" class="text-slate-500">
            <i class="fa-solid fa-chart-pie text-lg"></i>
        </a>
        <a href="{{ route('admin.venues.index') }}" class="text-green-500">
            <i class="fa-solid fa-map-location-dot text-lg"></i>
        </a>
    </div>

</body>
</html>
