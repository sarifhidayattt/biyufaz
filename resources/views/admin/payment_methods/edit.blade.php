<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Metode Pembayaran - Admin</title>
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
        <main class="flex-1 overflow-y-auto custom-scrollbar bg-[#F8FAFC]">
            <div class="p-8 max-w-7xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('admin.payment_methods.index') }}" class="text-gray-500 hover:text-green-700 text-sm inline-flex items-center gap-2 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
                <h2 class="text-2xl font-bold text-gray-800 mt-2">Edit Metode Pembayaran</h2>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
                <form action="{{ route('admin.payment_methods.update', $paymentMethod->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Metode (Cth: Bank BCA, QRIS)</label>
                        <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500" value="{{ old('name', $paymentMethod->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nomor Rekening / QR Code Data</label>
                        <input type="text" name="account_number" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500" value="{{ old('account_number', $paymentMethod->account_number) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Atas Nama</label>
                        <input type="text" name="account_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500" value="{{ old('account_name', $paymentMethod->account_name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Instruksi Pembayaran (Opsional)</label>
                        <textarea name="instructions" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">{{ old('instructions', $paymentMethod->instructions) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Ikon Bank / E-Wallet</label>
                        <select name="logo" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">
                            <option value="" {{ $paymentMethod->logo == '' ? 'selected' : '' }}>-- Pilih Ikon Default --</option>
                            <option value="qris" {{ $paymentMethod->logo == 'qris' ? 'selected' : '' }}>QRIS</option>
                            <option value="bca" {{ $paymentMethod->logo == 'bca' ? 'selected' : '' }}>Bank BCA</option>
                            <option value="bni" {{ $paymentMethod->logo == 'bni' ? 'selected' : '' }}>Bank BNI</option>
                            <option value="bri" {{ $paymentMethod->logo == 'bri' ? 'selected' : '' }}>Bank BRI</option>
                            <option value="mandiri" {{ $paymentMethod->logo == 'mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                            <option value="bsi" {{ $paymentMethod->logo == 'bsi' ? 'selected' : '' }}>Bank BSI</option>
                            <option value="dana" {{ $paymentMethod->logo == 'dana' ? 'selected' : '' }}>DANA</option>
                            <option value="ovo" {{ $paymentMethod->logo == 'ovo' ? 'selected' : '' }}>OVO</option>
                            <option value="gopay" {{ $paymentMethod->logo == 'gopay' ? 'selected' : '' }}>GoPay</option>
                            <option value="shopeepay" {{ $paymentMethod->logo == 'shopeepay' ? 'selected' : '' }}>ShopeePay</option>
                            <option value="linkaja" {{ $paymentMethod->logo == 'linkaja' ? 'selected' : '' }}>LinkAja</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" class="form-checkbox h-5 w-5 text-green-600 rounded border-gray-300 focus:ring-green-500" {{ $paymentMethod->is_active ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700 font-medium">Metode Aktif</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.payment_methods.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-bold transition">Batal</a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-bold transition">Update</button>
                    </div>
                </form>
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
