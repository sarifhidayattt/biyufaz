<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Metode Pembayaran - Biyufaz Admin</title>
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
                        <a href="{{ route('admin.payment_methods.index') }}" class="flex items-center px-4 py-3 sidebar-item-active rounded-l-xl transition-all duration-200">
                            <i class="fa-solid fa-wallet mr-3 text-sm"></i> 
                            <span class="text-sm font-bold">Metode Bayar</span>
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
                
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
                @endif

                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-6">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Metode Pembayaran</h2>
                        <p class="text-slate-500 text-sm mt-1">Konfigurasi rekening dan e-wallet untuk pembayaran konsumen</p>
                    </div>
                    <a href="{{ route('admin.payment_methods.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold transition-all text-sm flex items-center shadow-lg shadow-green-600/20 active:scale-95">
                        <i class="fa-solid fa-plus-circle mr-2 text-lg"></i> Tambah Metode
                    </a>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-credit-card text-green-500"></i>
                            Rekening Aktif
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100">Provider</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100">Informasi Rekening</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100 text-center">Status</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($paymentMethods as $method)
                                <tr class="hover:bg-slate-50/50 transition-all duration-200 group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-16 h-10 bg-white border border-slate-100 rounded-lg p-1.5 flex items-center justify-center shadow-sm shrink-0">
                                                @php
                                                    $logoUrls = [
                                                        'bca' => 'https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg',
                                                        'bni' => 'https://upload.wikimedia.org/wikipedia/id/5/55/BNI_logo.svg',
                                                        'bri' => 'https://upload.wikimedia.org/wikipedia/commons/9/9e/BRI_2020.svg',
                                                        'mandiri' => 'https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_of_Bank_Mandiri.svg',
                                                        'bsi' => 'https://upload.wikimedia.org/wikipedia/commons/a/a4/Bank_Syariah_Indonesia.svg',
                                                        'qris' => 'https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg',
                                                        'dana' => 'https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg',
                                                        'ovo' => 'https://upload.wikimedia.org/wikipedia/commons/e/e1/Logo_OVO.svg',
                                                        'gopay' => 'https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg',
                                                        'shopeepay' => 'https://upload.wikimedia.org/wikipedia/commons/f/fe/ShopeePay_Logo.png',
                                                        'linkaja' => 'https://upload.wikimedia.org/wikipedia/commons/8/85/LinkAja.svg',
                                                    ];
                                                    $imgUrl = $logoUrls[$method->logo] ?? null;
                                                @endphp
                                                @if($imgUrl)
                                                    <img src="{{ $imgUrl }}" class="max-w-full max-h-full object-contain">
                                                @else
                                                    <span class="text-[10px] font-black text-slate-300 uppercase">{{ $method->logo }}</span>
                                                @endif
                                            </div>
                                            <span class="font-black text-slate-800 text-sm">{{ $method->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-900 text-sm tabular-nums tracking-wide">{{ $method->account_number }}</span>
                                            <span class="text-[10px] text-slate-400 mt-1 font-bold uppercase tracking-widest">A.N. {{ $method->account_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex justify-center">
                                            @if($method->is_active)
                                                <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-lg border border-green-100">AKTIF</span>
                                            @else
                                                <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black rounded-lg border border-red-100">NONAKTIF</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('admin.payment_methods.edit', $method->id) }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-all active:scale-90">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </a>
                                            <form action="{{ route('admin.payment_methods.destroy', $method->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg transition-all active:scale-90">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center text-slate-400 italic font-medium">Belum ada metode pembayaran yang ditambahkan.</td>
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
        <a href="{{ route('admin.payment_methods.index') }}" class="text-green-500">
            <i class="fa-solid fa-wallet text-lg"></i>
        </a>
    </div>

</body>
</html>
