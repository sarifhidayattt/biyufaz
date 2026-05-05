<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Lapangan - Biyufaz</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                            accent: '#F9A825',
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 pb-[72px] md:pb-0">

    <!-- NAVIGASI -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-futsal-primary rounded-full flex items-center justify-center shadow-md">
                        <span class="font-bold text-xl text-white">F</span>
                    </div>
                    <span class="font-bold text-xl text-futsal-dark">Biyufaz</span>
                </a>

                <div class="hidden md:flex space-x-8 font-medium">
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-futsal-secondary transition">Beranda</a>
                    <a href="{{ url('/venues') }}" class="text-futsal-primary font-bold border-b-2 border-futsal-primary pb-1">Lapangan</a>
                    <a href="{{ url('/about') }}" class="text-gray-500 hover:text-futsal-secondary transition">Tentang Kami</a>
                    <a href="{{ url('/contact') }}" class="text-gray-500 hover:text-futsal-secondary transition">Kontak</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <div class="flex items-center gap-3">
                            <a href="{{ url('/profile') }}" class="text-gray-700 font-semibold hover:text-futsal-primary transition flex items-center gap-2">
                                <i class="fa-solid fa-circle-user text-2xl text-gray-400"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                        </div>
                    @else
                        <a href="{{ url('/login') }}" class="text-gray-600 font-medium hover:text-futsal-primary transition">Masuk</a>
                        <a href="{{ url('/register') }}" class="bg-futsal-primary text-white px-6 py-2.5 rounded-full font-semibold hover:bg-futsal-dark transition shadow-lg">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- HEADER PENCARIAN -->
    <div class="bg-futsal-dark py-16 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 text-center text-white relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight uppercase italic">Temukan Lapangan Terbaik</h1>
            <p class="text-gray-300 mb-8 text-lg max-w-2xl mx-auto">Pilih fasilitas futsal unggulan dan pesan jadwal mainmu sekarang.</p>
            
            <!-- Form Pencarian -->
            <form action="{{ url('/venues') }}" method="GET" class="bg-white p-2 rounded-[2rem] md:rounded-full shadow-2xl mx-auto flex flex-col md:flex-row items-center gap-2 max-w-4xl">
                <div class="flex-1 flex items-center px-4 md:px-6 py-2 w-full text-left md:border-r md:border-gray-100">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 mr-3"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama lapangan atau lokasi..." class="w-full text-sm text-gray-800 focus:outline-none bg-transparent">
                </div>
                
                <div class="w-full md:w-auto px-4 py-2 flex items-center gap-2 text-left md:border-r md:border-gray-100">
                    <i class="fa-solid fa-layer-group text-gray-400"></i>
                    <select name="type" class="w-full text-sm text-gray-600 focus:outline-none bg-transparent cursor-pointer">
                        <option value="all">Semua Tipe Lapangan</option>
                        <option value="Rumput Sintetis" {{ request('type') == 'Rumput Sintetis' ? 'selected' : '' }}>Sintetis</option>
                        <option value="Vinyl" {{ request('type') == 'Vinyl' ? 'selected' : '' }}>Vinyl</option>
                        <option value="Plester" {{ request('type') == 'Plester' ? 'selected' : '' }}>Plester / Semen</option>
                        <option value="Interlock" {{ request('type') == 'Interlock' ? 'selected' : '' }}>Interlock</option>
                    </select>
                </div>

                <div class="w-full md:w-auto px-4 py-2 flex items-center gap-2 text-left">
                    <i class="fa-solid fa-arrow-down-short-wide text-gray-400"></i>
                    <select name="sort" class="w-full text-sm text-gray-600 focus:outline-none bg-transparent cursor-pointer">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="cheap" {{ request('sort') == 'cheap' ? 'selected' : '' }}>Harga: Termurah</option>
                        <option value="expensive" {{ request('sort') == 'expensive' ? 'selected' : '' }}>Harga: Termahal</option>
                    </select>
                </div>

                <button type="submit" class="bg-futsal-secondary hover:bg-futsal-primary text-white font-bold py-3 px-8 rounded-full transition w-full md:w-auto shadow-lg mt-2 md:mt-0">
                    Cari Lapangan
                </button>
            </form>
        </div>
        <!-- Dekorasi BG -->
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-futsal-primary opacity-20 rounded-full blur-3xl"></div>
        <div class="absolute -top-10 -right-10 w-60 h-60 bg-futsal-secondary opacity-10 rounded-full blur-3xl"></div>
    </div>

    <!-- PETA LOKASI SEMUA LAPANGAN -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-4">
        <div class="bg-white p-2 rounded-3xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 px-6 pt-4 pb-2 flex items-center gap-3 italic uppercase tracking-tight">
                <i class="fa-solid fa-map-location-dot text-futsal-primary"></i> Peta Lokasi Lapangan
            </h2>
            <div id="venuesMap" class="w-full h-[400px] rounded-2xl z-0 relative" style="z-index: 1;"></div>
        </div>
    </div>

    <!-- DAFTAR LAPANGAN -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(request('search'))
            <p class="mb-10 text-gray-500 font-medium">
                <i class="fa-solid fa-filter text-futsal-primary mr-2"></i>
                Menampilkan hasil pencarian untuk: <span class="text-futsal-dark font-bold underline">"{{ request('search') }}"</span>
            </p>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            
            @forelse($venues as $venue)
            <div class="bg-white rounded-[2rem] shadow-[0_10px_40px_-15px_rgba(0,0,0,0.1)] hover:shadow-[0_20px_50px_-12px_rgba(0,104,74,0.15)] transition-all duration-500 overflow-hidden border border-gray-100 group flex flex-col h-full hover:-translate-y-2">
                <!-- Foto Lapangan -->
                <div class="relative h-64 overflow-hidden">
                    @php
                        $imageSrc = \Illuminate\Support\Str::startsWith($venue->image, 'http') ? $venue->image : asset('storage/' . $venue->image);
                    @endphp
                    <img src="{{ $imageSrc }}" alt="{{ $venue->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                    
                    <!-- Badge Status -->
                    <div class="absolute top-4 left-4">
                        <div class="bg-white/90 backdrop-blur-md text-[#00684A] text-[9px] font-black px-3 py-1.5 rounded-lg shadow-sm uppercase tracking-widest flex items-center gap-1.5 border border-white">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                            Tersedia Sekarang
                        </div>
                    </div>

                    <!-- Overlay Harga Glassmorphism Refined -->
                    <div class="absolute bottom-4 right-4 bg-[#00382B]/60 backdrop-blur-md text-white p-3 rounded-2xl shadow-xl border border-white/10 flex flex-col items-end">
                        <span class="text-[9px] font-bold opacity-80 uppercase tracking-widest mb-0.5">Mulai Dari</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-xs font-bold opacity-90">Rp</span>
                            <span class="text-xl font-black tracking-tight">{{ number_format($venue->price, 0, ',', '.') }}</span>
                            <span class="text-[10px] opacity-70 font-medium">/jam</span>
                        </div>
                    </div>
                </div>
                
                <!-- Konten Kartu -->
                <div class="p-7 flex flex-col flex-grow text-left">
                    <div class="mb-5">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="bg-futsal-primary/10 text-futsal-primary text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-tighter">{{ $venue->type }}</span>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900 truncate tracking-tight group-hover:text-futsal-primary transition-colors">{{ $venue->name }}</h3>
                    </div>
                    
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($venue->name . ' ' . $venue->address) }}" target="_blank" class="text-slate-500 text-xs flex items-start mb-5 leading-relaxed hover:text-futsal-primary transition-colors group/address">
                        <div class="w-7 h-7 bg-slate-50 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 group-hover/address:bg-futsal-primary/10 transition-colors">
                            <i class="fa-solid fa-location-dot text-futsal-primary text-xs group-hover/address:scale-110 transition-transform"></i>
                        </div>
                        <span class="line-clamp-2 underline-offset-4 group-hover/address:underline">{{ $venue->address }}</span>
                    </a>

                    <!-- JAM OPERASIONAL REFINED -->
                    <div class="flex items-center gap-4 bg-slate-50/80 backdrop-blur-sm p-3 rounded-2xl border border-slate-100 mb-6 group/hours hover:bg-white hover:shadow-sm transition-all duration-300">
                        <div class="flex-1 flex items-center gap-3 border-r border-slate-200/60 pr-4">
                            <div class="w-8 h-8 bg-white rounded-xl flex items-center justify-center shadow-sm text-futsal-primary">
                                <i class="fa-regular fa-sun text-amber-500 text-[10px]"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[8px] text-slate-400 font-bold uppercase tracking-tighter">Buka</span>
                                <span class="text-[10px] font-black text-slate-700 leading-tight">{{ $venue->operation_start_time ? date('H:i', strtotime($venue->operation_start_time)) : '08:00' }}</span>
                            </div>
                        </div>
                        <div class="flex-1 flex items-center gap-3">
                            <div class="w-8 h-8 bg-white rounded-xl flex items-center justify-center shadow-sm text-futsal-primary">
                                <i class="fa-solid fa-moon text-indigo-400 text-[10px]"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[8px] text-slate-400 font-bold uppercase tracking-tighter">Tutup</span>
                                <span class="text-[10px] font-black text-slate-700 leading-tight">{{ $venue->operation_end_time ? date('H:i', strtotime($venue->operation_end_time)) : '23:00' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fasilitas Premium Style -->
                    <div class="flex flex-wrap gap-1.5 mb-8">
                        @if(isset($venue->facilities) && is_array($venue->facilities))
                            @foreach(array_slice($venue->facilities, 0, 4) as $f)
                                <span class="text-[9px] font-bold text-slate-600 bg-slate-100/50 px-2.5 py-1 rounded-md border border-slate-200/60 uppercase tracking-tighter">{{ $f }}</span>
                            @endforeach
                        @else
                            <span class="text-[9px] font-bold text-slate-600 bg-slate-100/50 px-2.5 py-1 rounded-md border border-slate-200/60 uppercase tracking-tighter">Fasilitas Lengkap</span>
                        @endif
                    </div>

                    <!-- Tombol Aksi yang Disesuaikan -->
                    <div class="mt-auto">
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('booking.show', $venue->id) }}" class="w-full bg-slate-900 hover:bg-black text-white font-black py-4 px-6 rounded-2xl transition-all duration-300 shadow-xl text-[11px] uppercase tracking-[0.1em] flex items-center justify-center gap-3 active:scale-95">
                                <i class="fa-solid fa-gear text-xs"></i>
                                <span>Kelola Lapangan</span>
                            </a>
                        @else
                            <a href="{{ route('booking.show', $venue->id) }}" class="w-full bg-gradient-to-r from-futsal-primary to-futsal-dark hover:from-futsal-dark hover:to-futsal-primary text-white font-black py-4 px-6 rounded-2xl transition-all duration-300 shadow-lg shadow-futsal-primary/25 text-[11px] uppercase tracking-[0.1em] flex items-center justify-center gap-3 active:scale-95 group/btn overflow-hidden relative">
                                <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                                <span class="relative z-10">Pesan Sekarang</span>
                                <i class="fa-solid fa-calendar-check text-xs group-hover:rotate-12 transition-transform relative z-10"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-24 bg-white rounded-[3rem] shadow-inner border border-dashed border-gray-200">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                    <i class="fa-solid fa-futbol text-4xl animate-bounce"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-600 uppercase italic tracking-tight">Lapangan Tidak Ditemukan</h3>
                <p class="text-gray-400 mt-2 max-w-sm mx-auto">Maaf, kami tidak menemukan lapangan yang sesuai dengan kriteria pencarian Anda.</p>
                <a href="{{ url('/venues') }}" class="inline-block mt-8 text-futsal-primary font-bold hover:underline underline-offset-8">Tampilkan Semua Lapangan</a>
            </div>
            @endforelse

        </div>
    </div>

    <footer class="bg-futsal-dark pt-20 pb-12 text-gray-500 text-center text-sm border-t border-white/5">
        <div class="flex justify-center gap-6 mb-8 text-gray-400">
            <a href="#" class="hover:text-futsal-secondary transition-colors"><i class="fa-brands fa-instagram text-xl"></i></a>
            <a href="#" class="hover:text-futsal-secondary transition-colors"><i class="fa-brands fa-whatsapp text-xl"></i></a>
            <a href="#" class="hover:text-futsal-secondary transition-colors"><i class="fa-brands fa-tiktok text-xl"></i></a>
        </div>
        <p class="font-bold text-gray-400 mb-2 uppercase tracking-[0.3em]">&copy; 2025 Biyufaz Arena Management</p>
        <p class="text-[10px] opacity-40 uppercase tracking-widest">Premium Futsal Booking Ecosystem</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data venue dari server
            const venues = @json($venues);
            
            // Inisialisasi peta (pusatkan di Jakarta secara default atau di venue pertama)
            let centerLat = -6.2088;
            let centerLng = 106.8456;
            
            // Cari venue pertama yang punya koordinat untuk titik tengah awal
            const venueWithCoord = venues.find(v => v.latitude && v.longitude);
            if (venueWithCoord) {
                centerLat = venueWithCoord.latitude;
                centerLng = venueWithCoord.longitude;
            }

            const map = L.map('venuesMap').setView([centerLat, centerLng], 12);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Tambahkan marker untuk setiap venue yang punya koordinat
            let hasMarkers = false;
            const bounds = L.latLngBounds();

            venues.forEach(venue => {
                if (venue.latitude && venue.longitude) {
                    hasMarkers = true;
                    const latLng = [venue.latitude, venue.longitude];
                    
                    // Buat popup content
                    const imageSrc = venue.image.startsWith('http') ? venue.image : '/storage/' + venue.image;
                    const price = new Intl.NumberFormat('id-ID').format(venue.price);
                    
                    const popupContent = `
                        <div class="text-center p-1 w-48">
                            <img src="${imageSrc}" class="w-full h-24 object-cover rounded-lg mb-2" alt="${venue.name}">
                            <h3 class="font-bold text-sm mb-1">${venue.name}</h3>
                            <p class="text-xs text-gray-500 mb-2 truncate">${venue.address}</p>
                            <p class="text-futsal-primary font-bold text-xs mb-3">Rp ${price} / jam</p>
                            <a href="/booking/${venue.id}" class="bg-futsal-primary text-white text-xs font-bold py-1.5 px-3 rounded-lg block w-full hover:bg-futsal-dark transition">Pesan Sekarang</a>
                        </div>
                    `;

                    L.marker(latLng)
                        .addTo(map)
                        .bindPopup(popupContent);
                        
                    bounds.extend(latLng);
                }
            });

            // Sesuaikan zoom agar semua marker terlihat
            if (hasMarkers) {
                map.fitBounds(bounds, { padding: [50, 50] });
            }
        });
    </script>

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
