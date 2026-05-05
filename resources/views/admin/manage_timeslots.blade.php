<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Jam & Harga - {{ $venue->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
<body class="bg-[#F8FAFC] text-slate-900">

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
        <main class="flex-1 overflow-y-auto custom-scrollbar bg-[#F8FAFC]">
            <div class="p-8 max-w-7xl mx-auto">
                
                <!-- Notifikasi -->
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    <i class="fa-solid fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    <i class="fa-solid fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
                @endif

                @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    <i class="fa-solid fa-exclamation-circle mr-2"></i>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-green-700 text-sm mb-2 inline-flex items-center gap-2 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
                        </a>
                        <h2 class="text-2xl font-bold text-gray-800">Pantau Slot & Harga</h2>
                        <p class="text-gray-500 text-sm mt-1">
                            <i class="fa-solid fa-map-pin text-green-600 mr-1"></i> {{ $venue->name }} — {{ $venue->address }}
                        </p>
                    </div>
                    <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full shadow-sm">
                        Harga Default: <strong class="text-green-700">Rp {{ number_format($venue->price, 0, ',', '.') }}</strong>/jam
                    </span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- BAGIAN KIRI: FORM KELOLA -->
                    <div class="lg:col-span-1 space-y-6">
                        
                        <!-- FORM GENERATE OTOMATIS -->
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2"><i class="fa-solid fa-gears text-orange-500 mr-2"></i>Generate Slot Otomatis</h3>
                            
                            <form action="{{ route('admin.courts.hours.update', $court->id) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Jam Buka</label>
                                    <select name="operation_start_time" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-green-600 text-sm bg-white">
                                        @for($h = 0; $h < 24; $h++)
                                            <option value="{{ sprintf('%02d:00', $h) }}" {{ (substr($venue->operation_start_time ?? '07:00', 0, 2) == $h) ? 'selected' : '' }}>{{ sprintf('%02d:00', $h) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Jam Tutup</label>
                                    <select name="operation_end_time" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-green-600 text-sm bg-white">
                                        @for($h = 1; $h <= 24; $h++)
                                            <option value="{{ sprintf('%02d:00', $h % 24) }}" {{ (substr($venue->operation_end_time ?? '23:00', 0, 2) == $h % 24) ? 'selected' : '' }}>{{ sprintf('%02d:00', $h % 24) }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Harga Default (Rp)</label>
                                    <input type="number" name="default_price" required min="0" value="{{ $court->price }}"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-green-600 text-sm">
                                </div>

                                <button type="submit" onclick="return confirm('Peringatan: Generate ulang akan MENGHAPUS semua slot jam yang belum di-booking pada lapangan ini. Lanjutkan?')" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-lg transition text-sm">
                                    <i class="fa-solid fa-rotate mr-2"></i>Generate Ulang Slot
                                </button>
                            </form>
                        </div>

                        <!-- FORM TAMBAH SLOT MANUAL -->
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-24">
                            <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2"><i class="fa-solid fa-plus-circle text-green-600 mr-2"></i>Tambah Slot Manual</h3>
                            
                            <form action="{{ route('admin.courts.timeslots.store', $court->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Jam Mulai</label>
                                    <select name="start_time" required id="manual-start" onchange="autoFillEndTime()"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-green-600 text-sm bg-white">
                                        <option value="">-- Pilih Jam --</option>
                                        @for($h = 0; $h < 24; $h++)
                                            <option value="{{ sprintf('%02d:00', $h) }}">{{ sprintf('%02d:00', $h) }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Jam Selesai</label>
                                    <select name="end_time" required id="manual-end"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-green-600 text-sm bg-white">
                                        <option value="">-- Pilih Jam --</option>
                                        @for($h = 1; $h <= 24; $h++)
                                            <option value="{{ sprintf('%02d:00', $h % 24) }}">{{ sprintf('%02d:00', $h % 24) }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Harga (Rp)</label>
                                    <input type="number" name="price" required min="0" placeholder="100000" value="{{ $venue->price }}"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-green-600 text-sm">
                                </div>

                                <button type="submit" class="w-full bg-[#00684A] hover:bg-[#00382B] text-white font-bold py-3 rounded-lg transition text-sm">
                                    <i class="fa-solid fa-plus mr-2"></i>Tambah Slot
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- TABEL SLOT YANG ADA -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                <h3 class="font-bold text-gray-800">
                                    <i class="fa-solid fa-clock text-green-600 mr-2"></i>Daftar Slot Jam
                                </h3>
                                <span class="text-xs text-gray-400">{{ $timeSlots->count() }} slot terdaftar</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-gray-600">
                                    <thead class="bg-gray-50 text-gray-800 font-semibold">
                                        <tr>
                                            <th class="px-6 py-3">Jam</th>
                                            <th class="px-6 py-3">Harga</th>
                                            <th class="px-6 py-3 text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($timeSlots as $slot)
                                        <tr class="hover:bg-gray-50 transition {{ !$slot->is_active ? 'opacity-50' : '' }}">
                                            <td class="px-6 py-4">
                                                <span class="font-bold text-gray-800">{{ date('H:i', strtotime($slot->start_time)) }}</span>
                                                <span class="text-gray-400 mx-1">—</span>
                                                <span class="text-gray-600">{{ date('H:i', strtotime($slot->end_time)) }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-bold text-green-700">Rp {{ number_format($slot->price, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-xs font-bold px-3 py-1 rounded-full {{ $slot->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                    {{ $slot->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                                                <i class="fa-solid fa-clock text-3xl mb-3 block opacity-30"></i>
                                                <p class="font-medium">Belum ada slot jam yang terdaftar.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Info footer dihapus --}}
                    </div>

                </div>

            </div>
        </main>
    </div>

    <script>
        // Auto-fill end time = start + 1 jam (untuk form Tambah Slot manual)
        function autoFillEndTime() {
            const startSelect = document.getElementById('manual-start');
            const endSelect = document.getElementById('manual-end');
            const startVal = startSelect.value;
            
            if (startVal) {
                const startHour = parseInt(startVal.split(':')[0]);
                const endHour = (startHour + 1) % 24;
                const endVal = String(endHour).padStart(2, '0') + ':00';
                endSelect.value = endVal;
            }
        }
    </script>
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
