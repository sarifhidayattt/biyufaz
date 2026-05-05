<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Lapangan - Admin</title>
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
            <div class="mb-6 flex justify-between items-start">
                <div>
                    <a href="{{ route('admin.venues.index') }}" class="text-gray-500 hover:text-green-700 text-sm inline-flex items-center gap-2 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Lapangan
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800 mt-2">Pantau Lapangan</h2>
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="fa-solid fa-map-pin text-green-600 mr-1"></i> {{ $venue->name }} — {{ $venue->address }}
                    </p>
                </div>
                <a href="{{ route('admin.venue.edit', $venue->id) }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-50 transition flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Profil GOR
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm">
                    <i class="fa-solid fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach($courts as $court)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition-shadow">
                    @if($court->image)
                    <div class="h-32 w-full overflow-hidden rounded-lg mb-4 bg-gray-100">
                        <img src="{{ asset('storage/' . $court->image) }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1 min-w-0 pr-2">
                            <h3 class="font-bold text-lg text-gray-800 truncate">{{ $court->name }}</h3>
                            <span class="text-[10px] font-black text-gray-500 bg-gray-100 px-2 py-1 rounded mt-1 inline-block uppercase tracking-wider">{{ $court->type }}</span>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="block text-sm font-black text-green-700 italic">Rp {{ number_format($court->price, 0, ',', '.') }}</span>
                            <span class="text-[8px] text-gray-400 uppercase font-bold tracking-tighter">per jam</span>
                        </div>
                    </div>
                    
                    <div class="text-xs text-gray-500 mb-6 flex-1 flex items-center gap-2 font-medium">
                        <i class="fa-solid fa-clock text-green-500"></i> {{ $court->timeSlotConfigs->count() }} Slot Dikonfigurasi
                    </div>

                    <div class="flex flex-col gap-2 mt-auto">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.courts.timeslots', $court->id) }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-md active:scale-95">
                                <i class="fa-solid fa-calendar-check mr-1"></i> Atur Jadwal
                            </a>
                            
                            <button onclick="openEditModal({{ json_encode($court) }})" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2.5 rounded-xl text-xs transition active:scale-95">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                        </div>
                        
                        @if($courts->count() > 1)
                        <form action="{{ route('admin.courts.delete', $court->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lapangan ini? Semua jadwalnya akan terhapus.')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-center py-2 text-[10px] font-bold text-red-400 hover:text-red-600 transition">
                                <i class="fa-solid fa-trash-can mr-1"></i> Hapus Lapangan
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach

                <!-- Tombol Tambah Lapangan Baru (Modern) -->
                <button onclick="document.getElementById('add-court-modal').classList.remove('hidden')" class="border-2 border-dashed border-gray-200 rounded-xl p-6 flex flex-col items-center justify-center text-gray-400 hover:border-green-400 hover:text-green-500 hover:bg-green-50 transition group min-h-[250px]">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3 group-hover:bg-green-100 transition">
                        <i class="fa-solid fa-plus text-xl"></i>
                    </div>
                    <span class="font-bold text-sm">Tambah Sub-Lapangan</span>
                </button>
            </div>
        </div>
    </main>
</div>

    <!-- MODAL EDIT LAPANGAN -->
    <div id="edit-court-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[1000] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-200">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-black text-slate-800 uppercase tracking-tight">Edit Detail Lapangan</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times"></i></button>
            </div>
            <form id="edit-court-form" method="POST" enctype="multipart/form-data" class="p-8 space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Lapangan</label>
                    <input type="text" name="name" id="edit-name" required class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-green-600 outline-none transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tipe Lantai</label>
                        <select name="type" id="edit-type" required class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-green-600 outline-none transition-all appearance-none font-bold text-slate-700">
                            <option value="Vinyl">Vinyl</option>
                            <option value="Rumput Sintetis">Rumput Sintetis</option>
                            <option value="Interlock">Interlock</option>
                            <option value="Parquet">Parquet</option>
                            <option value="Semen">Semen</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Harga / Jam</label>
                        <input type="number" name="price" id="edit-price" required class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-green-600 outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Ganti Foto (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-100 text-gray-600 font-bold py-3 rounded-xl text-xs uppercase tracking-widest">Batal</button>
                    <button type="submit" class="flex-1 bg-green-600 text-white font-bold py-3 rounded-xl text-xs uppercase tracking-widest shadow-lg shadow-green-600/20">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL TAMBAH LAPANGAN -->
    <div id="add-court-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[1000] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-200">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-black text-slate-800 uppercase tracking-tight">Tambah Lapangan Baru</h3>
                <button onclick="document.getElementById('add-court-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times"></i></button>
            </div>
            <form action="{{ route('admin.venue.courts.store', $venue->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Lapangan</label>
                    <input type="text" name="name" placeholder="Cth: Lapangan B" required class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-green-600 outline-none transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tipe Lantai</label>
                        <select name="type" required class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-green-600 outline-none transition-all appearance-none font-bold text-slate-700">
                            <option value="Vinyl">Vinyl</option>
                            <option value="Rumput Sintetis">Rumput Sintetis</option>
                            <option value="Interlock">Interlock</option>
                            <option value="Parquet">Parquet</option>
                            <option value="Semen">Semen</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Harga / Jam</label>
                        <input type="number" name="price" value="100000" required class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-green-600 outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Foto Lapangan</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="document.getElementById('add-court-modal').classList.add('hidden')" class="flex-1 bg-gray-100 text-gray-600 font-bold py-3 rounded-xl text-xs uppercase tracking-widest">Batal</button>
                    <button type="submit" class="flex-1 bg-slate-900 text-white font-bold py-3 rounded-xl text-xs uppercase tracking-widest shadow-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(court) {
            const form = document.getElementById('edit-court-form');
            form.action = `/admin/courts/${court.id}/update`;
            
            document.getElementById('edit-name').value = court.name;
            document.getElementById('edit-type').value = court.type;
            document.getElementById('edit-price').value = court.price;
            
            document.getElementById('edit-court-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-court-modal').classList.add('hidden');
        }

        // Close modals on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeEditModal();
                document.getElementById('add-court-modal').classList.add('hidden');
            }
        });
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
