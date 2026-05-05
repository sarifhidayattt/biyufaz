<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Lapangan - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-green-700 text-sm mb-4 inline-flex items-center gap-2 transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah GOR Baru</h2>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 max-w-3xl">
                <form action="{{ route('admin.venue.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- === INFO DASAR === --}}
                    <div class="border-b border-gray-100 pb-4 mb-2">
                        <h3 class="font-bold text-gray-700 flex items-center gap-2">
                            <i class="fa-solid fa-info-circle text-green-600"></i> Informasi Dasar
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tipe GOR</label>
                            <select name="type" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-600 appearance-none bg-white font-bold text-slate-700">
                                <option value="Futsal">Futsal</option>
                                <option value="Basket">Basket</option>
                                <option value="Badminton">Badminton</option>
                                <option value="Mini Soccer">Mini Soccer</option>
                                <option value="Voli">Voli</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama GOR / Lokasi</label>
                            <input type="text" name="name" required value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-600" placeholder="Contoh: Gor Futsal Merdeka">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Alamat</label>
                        <input type="text" name="address" required value="{{ old('address') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-600" placeholder="Jalan Raya No. 123">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Kontak (WhatsApp)</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-600" placeholder="08xxxxxxxxxx">
                        <p class="text-xs text-gray-500 mt-1">Nomor HP/WhatsApp pengelola lapangan untuk dihubungi pelanggan</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Lokasi Peta (Koordinat GIS)</label>
                        <div id="map" class="w-full h-64 rounded-lg z-0 mb-2 border border-gray-300" style="z-index: 1;"></div>
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <p class="text-xs text-gray-500"><i class="fa-solid fa-map-pin text-red-500"></i> Klik pada peta untuk menandai titik lokasi GOR yang presisi.</p>
                    </div>

                    {{-- === DAFTAR LAPANGAN === --}}
                    <div class="border-b border-gray-100 pb-4 mb-2 mt-8 flex justify-between items-center">
                        <h3 class="font-bold text-gray-700 flex items-center gap-2">
                            <i class="fa-solid fa-layer-group text-green-600"></i> Daftar Lapangan
                        </h3>
                        <button type="button" onclick="addCourt()" class="bg-green-100 text-green-700 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-green-200 transition">
                            <i class="fa-solid fa-plus mr-1"></i> Tambah Lapangan
                        </button>
                    </div>

                    <div id="courts-container" class="space-y-4">
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg relative">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lapangan</label>
                                    <input type="text" name="court_name[]" required value="Lapangan A" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-600">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Tipe Lantai</label>
                                    <select name="court_type[]" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-600 appearance-none bg-white">
                                        <option value="Vinyl">Vinyl</option>
                                        <option value="Rumput Sintetis">Rumput Sintetis</option>
                                        <option value="Interlock">Interlock</option>
                                        <option value="Parquet">Parquet</option>
                                        <option value="Semen">Semen</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Harga Per Jam (Rp)</label>
                                    <input type="number" name="court_price[]" required value="100000" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-600">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-xs font-bold text-gray-700 mb-1">Foto / Gambar Lapangan</label>
                                <input type="file" name="court_image[]" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-600 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Foto Lapangan</label>
                        <input type="file" name="image" accept="image/*" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-600 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        <p class="text-xs text-gray-500 mt-1">*Upload foto lapangan (JPG, PNG, max 2MB)</p>
                    </div>

                    {{-- === FASILITAS === --}}
                    <div class="border-b border-gray-100 pb-4 mb-2 mt-8">
                        <h3 class="font-bold text-gray-700 flex items-center gap-2">
                            <i class="fa-solid fa-list-check text-green-600"></i> Fasilitas
                        </h3>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @php
                            $facilityOptions = ['Parkir', 'WiFi', 'Toilet', 'Mushola', 'Kantin', 'Ruang Ganti', 'Tribun', 'Lampu Sorot'];
                        @endphp
                        @foreach($facilityOptions as $facility)
                        <label class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-lg cursor-pointer hover:bg-green-50 transition border border-gray-200">
                            <input type="checkbox" name="facilities[]" value="{{ $facility }}" class="rounded text-green-600 focus:ring-green-500"
                                   {{ is_array(old('facilities')) && in_array($facility, old('facilities')) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">{{ $facility }}</span>
                        </label>
                        @endforeach
                    </div>

                    {{-- === JAM OPERASIONAL === --}}
                    <div class="border-b border-gray-100 pb-4 mb-2 mt-8">
                        <h3 class="font-bold text-gray-700 flex items-center gap-2">
                            <i class="fa-solid fa-clock text-green-600"></i> Jam Operasional
                        </h3>
                        <p class="text-xs text-gray-400 mt-1">Slot pemesanan per jam akan otomatis dibuat berdasarkan jam buka & tutup</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Jam Buka</label>
                            <select name="operation_start_time" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-600">
                                @for($h = 0; $h < 24; $h++)
                                    @php $val = sprintf('%02d:00', $h); @endphp
                                    <option value="{{ $val }}" {{ (old('operation_start_time', '08:00') == $val) ? 'selected' : '' }}>{{ $val }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Jam Tutup</label>
                            <select name="operation_end_time" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-600">
                                @for($h = 0; $h < 24; $h++)
                                    @php $val = sprintf('%02d:00', $h); @endphp
                                    <option value="{{ $val }}" {{ (old('operation_end_time', '22:00') == $val) ? 'selected' : '' }}>{{ $val }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg text-xs">
                        <i class="fa-solid fa-info-circle mr-1"></i>
                        <strong>Contoh:</strong> Jam Buka 08:00 & Tutup 22:00 → otomatis membuat 14 slot (08:00-09:00, 09:00-10:00, ..., 21:00-22:00) dengan harga default yang Anda tetapkan di atas.
                        Harga tiap slot bisa diubah nanti di halaman "Kelola Jam & Harga".
                    </div>

                    <button type="submit" class="w-full bg-[#00684A] hover:bg-[#00382B] text-white font-bold py-3 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-bolt text-yellow-300"></i> Simpan GOR & Generate Jadwal
                    </button>
                </form>
            </div>
        </main>
    </div>
    <script>
        let courtCount = 1;
        function addCourt() {
            courtCount++;
            const char = String.fromCharCode(64 + courtCount); // A, B, C...
            const container = document.getElementById('courts-container');
            const courtHtml = `
            <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg relative mt-4">
                <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-xs font-bold"><i class="fa-solid fa-times"></i> Hapus</button>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lapangan</label>
                        <input type="text" name="court_name[]" required value="Lapangan ${char}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-600">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tipe Lantai</label>
                        <select name="court_type[]" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-600 appearance-none bg-white">
                            <option value="Vinyl">Vinyl</option>
                            <option value="Rumput Sintetis">Rumput Sintetis</option>
                            <option value="Interlock">Interlock</option>
                            <option value="Parquet">Parquet</option>
                            <option value="Semen">Semen</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Harga Per Jam (Rp)</label>
                        <input type="number" name="court_price[]" required value="100000" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-600">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Foto / Gambar Lapangan</label>
                    <input type="file" name="court_image[]" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-600 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>
            </div>`;
            container.insertAdjacentHTML('beforeend', courtHtml);
        }

        // Inisialisasi Peta Leaflet
        document.addEventListener('DOMContentLoaded', function() {
            // Default center point (e.g., Jakarta)
            const defaultLat = -6.2088;
            const defaultLng = 106.8456;
            
            const map = L.map('map').setView([defaultLat, defaultLng], 12);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            let marker;

            // Handle map clicks
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                // Update hidden inputs
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                // Create or update marker
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }
            });
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