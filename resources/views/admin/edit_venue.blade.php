<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit GOR - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; letter-spacing: -0.01em; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="bg-[#F1F5F9] text-slate-900 overflow-hidden">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR -->
        <aside class="w-72 bg-[#0F172A] text-white flex flex-col hidden lg:flex no-print shrink-0 shadow-2xl relative z-20">
            <div class="h-24 flex items-center px-8 border-b border-slate-800/50">
                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl mr-4 flex items-center justify-center shadow-lg shadow-green-500/20">
                    <i class="fa-solid fa-bolt text-white text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <h1 class="text-xl font-black tracking-tight leading-none">Biyufaz</h1>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">Admin Panel</span>
                </div>
            </div>
            
            <div class="flex-1 py-8 custom-scrollbar overflow-y-auto px-4">
                <div class="mb-10">
                    <p class="text-[11px] font-black text-slate-600 uppercase tracking-[0.2em] mb-4 px-4">Menu Utama</p>
                    <nav class="space-y-1.5">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800/50 hover:text-white rounded-2xl transition-all duration-300 group">
                            <i class="fa-solid fa-house-chimney w-5 text-sm opacity-50 group-hover:opacity-100"></i> 
                            <span class="text-sm font-bold ml-3">Dashboard</span>
                        </a>
                        <a href="{{ route('admin.venues.index') }}" class="flex items-center px-4 py-3 bg-green-500/10 text-green-500 rounded-2xl border-r-4 border-green-500 transition-all duration-300 group">
                            <i class="fa-solid fa-map-location-dot w-5 text-sm"></i> 
                            <span class="text-sm font-bold ml-3">Kelola Lapangan</span>
                        </a>
                        <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800/50 hover:text-white rounded-2xl transition-all duration-300 group">
                            <i class="fa-solid fa-chart-line w-5 text-sm opacity-50 group-hover:opacity-100"></i> 
                            <span class="text-sm font-bold ml-3">Laporan Analitik</span>
                        </a>
                    </nav>
                </div>

                <div class="mb-6">
                    <p class="text-[11px] font-black text-slate-600 uppercase tracking-[0.2em] mb-4 px-4">Konfigurasi</p>
                    <nav class="space-y-1.5">
                        <a href="{{ route('admin.payment_methods.index') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800/50 hover:text-white rounded-2xl transition-all duration-300 group">
                            <i class="fa-solid fa-wallet w-5 text-sm opacity-50 group-hover:opacity-100"></i> 
                            <span class="text-sm font-bold ml-3">Metode Bayar</span>
                        </a>
                    </nav>
                </div>
            </div>

            <div class="p-8 border-t border-slate-800/50 bg-slate-900/50">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center justify-center px-4 py-4 text-slate-400 hover:text-red-400 rounded-2xl transition-all font-bold text-[10px] uppercase tracking-widest bg-slate-800/50 hover:bg-red-500/10 border border-slate-700/50 group">
                        <i class="fa-solid fa-power-off mr-2 group-hover:scale-110 transition-transform"></i> Keluar Aplikasi
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto custom-scrollbar bg-[#F8FAFC]">
            <div class="p-8 lg:p-12 max-w-6xl mx-auto">

                <!-- Header Section -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-3 mb-4">
                            <a href="{{ route('admin.venues.index') }}" class="w-10 h-10 bg-white rounded-2xl shadow-sm border border-slate-200 flex items-center justify-center text-slate-400 hover:text-green-600 hover:border-green-300 transition-all active:scale-90">
                                <i class="fa-solid fa-arrow-left text-xs"></i>
                            </a>
                            <nav class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <span class="hover:text-slate-600 cursor-pointer">ADMIN</span>
                                <span class="mx-2 text-slate-300">/</span>
                                <span class="hover:text-slate-600 cursor-pointer">LAPANGAN</span>
                                <span class="mx-2 text-slate-300">/</span>
                                <span class="text-green-600">EDIT GOR</span>
                            </nav>
                        </div>
                        <h2 class="text-4xl font-black text-slate-900 tracking-tight flex items-center gap-4">
                            Edit Profil GOR
                            <div class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></div>
                        </h2>
                    </div>
                </div>

                <form action="{{ route('admin.venue.update', $venue->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                        
                        <!-- Left Column: Form Info -->
                        <div class="lg:col-span-7 space-y-10">
                            
                            <!-- Card: Informasi Utama -->
                            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
                                <div class="px-10 py-7 border-b border-slate-100 bg-slate-50/30 flex items-center justify-between">
                                    <h3 class="font-black text-slate-800 flex items-center gap-3 uppercase text-[10px] tracking-[0.2em]">
                                        <div class="w-8 h-8 bg-green-500 rounded-xl shadow-lg shadow-green-500/20 flex items-center justify-center text-white">
                                            <i class="fa-solid fa-info text-xs"></i>
                                        </div>
                                        Informasi Utama
                                    </h3>
                                </div>
                                <div class="p-10 space-y-8">
                                    <div class="space-y-6">
                                        <div class="col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div class="md:col-span-1">
                                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3 px-1">Tipe GOR</label>
                                                <select name="type" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all font-bold text-slate-700 text-sm shadow-sm appearance-none">
                                                    <option value="Futsal" {{ (old('type', $venue->type) == 'Futsal') ? 'selected' : '' }}>Futsal</option>
                                                    <option value="Basket" {{ (old('type', $venue->type) == 'Basket') ? 'selected' : '' }}>Basket</option>
                                                    <option value="Badminton" {{ (old('type', $venue->type) == 'Badminton') ? 'selected' : '' }}>Badminton</option>
                                                    <option value="Mini Soccer" {{ (old('type', $venue->type) == 'Mini Soccer') ? 'selected' : '' }}>Mini Soccer</option>
                                                    <option value="Voli" {{ (old('type', $venue->type) == 'Voli') ? 'selected' : '' }}>Voli</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3 px-1">Nama GOR / Lokasi</label>
                                                <input type="text" name="name" required value="{{ old('name', $venue->name) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all font-bold text-slate-700 text-sm shadow-sm" placeholder="Contoh: GOR Futsal Sentosa">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3 px-1">Alamat Lengkap</label>
                                            <textarea name="address" required rows="4" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all font-bold text-slate-700 text-sm shadow-sm leading-relaxed" placeholder="Jalan Raya No. 123...">{{ old('address', $venue->address) }}</textarea>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3 px-1">Nomor WhatsApp</label>
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-slate-400">
                                                        <i class="fa-brands fa-whatsapp text-lg"></i>
                                                    </div>
                                                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $venue->contact_phone) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-14 pr-6 py-4 focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all font-bold text-slate-700 text-sm shadow-sm" placeholder="08123456789">
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3 px-1">Lat</label>
                                                    <input type="text" name="latitude" value="{{ old('latitude', $venue->latitude) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 focus:outline-none focus:border-green-500 focus:bg-white transition-all font-bold text-slate-700 text-xs shadow-sm" placeholder="-6.2088">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3 px-1">Long</label>
                                                    <input type="text" name="longitude" value="{{ old('longitude', $venue->longitude) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 focus:outline-none focus:border-green-500 focus:bg-white transition-all font-bold text-slate-700 text-xs shadow-sm" placeholder="106.8456">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card: Fasilitas -->
                            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
                                <div class="px-10 py-7 border-b border-slate-100 bg-slate-50/30">
                                    <h3 class="font-black text-slate-800 flex items-center gap-3 uppercase text-[10px] tracking-[0.2em]">
                                        <div class="w-8 h-8 bg-green-500 rounded-xl shadow-lg shadow-green-500/20 flex items-center justify-center text-white">
                                            <i class="fa-solid fa-list-check text-xs"></i>
                                        </div>
                                        Fasilitas Tersedia
                                    </h3>
                                </div>
                                <div class="p-10">
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                        @php
                                            $facilityOptions = ['Parkir', 'WiFi', 'Toilet', 'Mushola', 'Kantin', 'Ruang Ganti', 'Tribun', 'Lampu Sorot'];
                                            $currentFacilities = $venue->facilities ?? [];
                                        @endphp
                                        @foreach($facilityOptions as $facility)
                                        <label class="group relative flex flex-col items-center justify-center h-20 rounded-2xl border-2 transition-all duration-300 cursor-pointer overflow-hidden
                                            {{ in_array($facility, $currentFacilities) ? 'bg-green-600 border-green-600 shadow-md shadow-green-600/20' : 'bg-slate-50 border-slate-100 hover:border-slate-200' }}">
                                            
                                            <input type="checkbox" name="facilities[]" value="{{ $facility }}" class="sr-only"
                                                {{ in_array($facility, $currentFacilities) ? 'checked' : '' }}
                                                onchange="
                                                    const isChecked = this.checked;
                                                    const parent = this.parentElement;
                                                    const labelText = parent.querySelector('.label-text');
                                                    const checkBadge = parent.querySelector('.check-badge');

                                                    if(isChecked) {
                                                        parent.classList.remove('bg-slate-50', 'border-slate-100', 'hover:border-slate-200');
                                                        parent.classList.add('bg-green-600', 'border-green-600', 'shadow-md', 'shadow-green-600/20');
                                                        labelText.classList.remove('text-slate-500');
                                                        labelText.classList.add('text-white');
                                                        checkBadge.classList.remove('opacity-0', 'scale-50');
                                                        checkBadge.classList.add('opacity-100', 'scale-100');
                                                    } else {
                                                        parent.classList.add('bg-slate-50', 'border-slate-100', 'hover:border-slate-200');
                                                        parent.classList.remove('bg-green-600', 'border-green-600', 'shadow-md', 'shadow-green-600/20');
                                                        labelText.classList.add('text-slate-500');
                                                        labelText.classList.remove('text-white');
                                                        checkBadge.classList.add('opacity-0', 'scale-50');
                                                        checkBadge.classList.remove('opacity-100', 'scale-100');
                                                    }
                                                ">
                                            
                                            <span class="label-text text-[9px] font-black uppercase tracking-[0.2em] text-center transition-colors px-2
                                                {{ in_array($facility, $currentFacilities) ? 'text-white' : 'text-slate-500' }}">{{ $facility }}</span>
                                            
                                            <div class="check-badge absolute top-1.5 right-1.5 transition-all duration-300 transform
                                                {{ in_array($facility, $currentFacilities) ? 'opacity-100 scale-100' : 'opacity-0 scale-50' }}">
                                                <div class="w-3.5 h-3.5 bg-white/30 rounded-full flex items-center justify-center border border-white/40">
                                                    <i class="fa-solid fa-check text-[6px] text-white font-black"></i>
                                                </div>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Sidebar -->
                        <div class="lg:col-span-5 space-y-10">
                            
                            <!-- Card: Banner GOR -->
                            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
                                <div class="px-8 py-7 border-b border-slate-100 bg-slate-50/30">
                                    <h3 class="font-black text-slate-800 flex items-center gap-3 uppercase text-[10px] tracking-[0.2em]">
                                        <div class="w-8 h-8 bg-green-500 rounded-xl shadow-lg shadow-green-500/20 flex items-center justify-center text-white">
                                            <i class="fa-solid fa-image text-xs"></i>
                                        </div>
                                        Banner GOR
                                    </h3>
                                </div>
                                <div class="p-8 space-y-6">
                                    @if($venue->image)
                                    <div class="relative group aspect-[4/3] rounded-3xl overflow-hidden shadow-inner bg-slate-100 border border-slate-200">
                                        <img src="{{ asset('storage/' . $venue->image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity"></div>
                                        <div class="absolute bottom-5 left-5 right-5 flex items-center justify-between">
                                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[8px] font-black text-white uppercase tracking-widest border border-white/30">Preview Saat Ini</span>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <div class="relative">
                                        <input type="file" name="image" id="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="border-2 border-dashed border-slate-200 rounded-3xl p-8 bg-slate-50 group hover:bg-green-50 hover:border-green-400 transition-all text-center">
                                            <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center text-slate-400 mx-auto mb-4 group-hover:text-green-500 group-hover:shadow-md transition-all">
                                                <i class="fa-solid fa-camera-retro text-xl"></i>
                                            </div>
                                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Upload Foto Baru</p>
                                            <p class="text-[8px] text-slate-400 font-medium">JPEG, PNG, JPG (Maks. 2MB)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card: Operasional -->
                            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
                                <div class="px-8 py-7 border-b border-slate-100 bg-slate-50/30">
                                    <h3 class="font-black text-slate-800 flex items-center gap-3 uppercase text-[10px] tracking-[0.2em]">
                                        <div class="w-8 h-8 bg-green-500 rounded-xl shadow-lg shadow-green-500/20 flex items-center justify-center text-white">
                                            <i class="fa-solid fa-clock text-xs"></i>
                                        </div>
                                        Jam Operasional
                                    </h3>
                                </div>
                                <div class="p-8 space-y-8">
                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="space-y-3">
                                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block px-1">Jam Buka</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-green-500">
                                                    <i class="fa-regular fa-sun text-xs"></i>
                                                </div>
                                                <select name="operation_start_time" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-12 pr-4 py-3.5 focus:outline-none focus:border-green-500 transition-all font-black text-slate-700 text-xs appearance-none shadow-sm">
                                                    @for($h = 0; $h < 24; $h++)
                                                        @php $val = sprintf('%02d:00', $h); @endphp
                                                        <option value="{{ $val }}" {{ (old('operation_start_time', substr($venue->operation_start_time, 0, 5)) == $val) ? 'selected' : '' }}>{{ $val }} WIB</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="space-y-3">
                                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block px-1">Jam Tutup</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-400">
                                                    <i class="fa-solid fa-moon text-xs"></i>
                                                </div>
                                                <select name="operation_end_time" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-12 pr-4 py-3.5 focus:outline-none focus:border-green-500 transition-all font-black text-slate-700 text-xs appearance-none shadow-sm">
                                                    @for($h = 0; $h < 24; $h++)
                                                        @php $val = sprintf('%02d:00', $h); @endphp
                                                        <option value="{{ $val }}" {{ (old('operation_end_time', substr($venue->operation_end_time, 0, 5)) == $val) ? 'selected' : '' }}>{{ $val }} WIB</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="p-5 bg-gradient-to-br from-amber-50 to-orange-50 rounded-3xl border border-amber-100 shadow-sm">
                                        <div class="flex items-start gap-4">
                                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-amber-500 shadow-sm shrink-0 border border-amber-100">
                                                <i class="fa-solid fa-lightbulb text-xs"></i>
                                            </div>
                                            <p class="text-[9px] leading-relaxed text-amber-900 font-bold uppercase tracking-wide">
                                                Catatan: Perubahan jam operasional di sini hanya memperbarui profil. Untuk mengedit slot waktu booking, gunakan menu <span class="text-green-600 underline">Atur Jadwal</span>.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Action Footer -->
                    <div class="flex items-center justify-end gap-6 pt-6 border-t border-slate-200">
                        <a href="{{ route('admin.venues.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hover:text-slate-600 transition-colors">Batalkan Perubahan</a>
                        <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-700 hover:from-emerald-700 hover:to-green-600 text-white font-black py-5 px-14 rounded-2xl transition-all duration-300 shadow-xl shadow-green-600/30 active:scale-95 flex items-center gap-4 text-xs uppercase tracking-[0.1em]">
                            <i class="fa-solid fa-check-circle"></i>
                            Simpan Data GOR
                        </button>
                    </div>

                </form>
            </div>
        </main>
    </div>

    <!-- MOBILE NAV -->
    <div class="lg:hidden fixed bottom-6 left-6 right-6 bg-[#0F172A] rounded-[2rem] shadow-2xl z-[100] border border-white/5 flex justify-around items-center py-5 px-8 no-print">
        <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-white transition-colors">
            <i class="fa-solid fa-house-chimney text-xl"></i>
        </a>
        <a href="{{ route('admin.venues.index') }}" class="text-green-500">
            <i class="fa-solid fa-map-location-dot text-xl"></i>
        </a>
        <a href="{{ route('admin.payment_methods.index') }}" class="text-slate-500 hover:text-white transition-colors">
            <i class="fa-solid fa-wallet text-xl"></i>
        </a>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-red-400/60">
                <i class="fa-solid fa-power-off text-xl"></i>
            </button>
        </form>
    </div>

</body>
</html>
