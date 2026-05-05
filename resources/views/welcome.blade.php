<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biyufaz - Platform Booking Futsal Indonesia</title>
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
                            gradient_start: '#00382B',
                            gradient_end: '#A8773E'
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        
        .btn-bounce:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans pb-[72px] md:pb-0">

    <!-- NAVIGASI -->
    <nav class="absolute top-0 left-0 w-full z-50 bg-transparent py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md">
                    <span class="font-bold text-2xl text-futsal-primary">F</span>
                </div>
                <span class="font-bold text-2xl text-white">Biyufaz</span>
            </div>

            <!-- Menu Tengah -->
            <div class="hidden md:flex space-x-8 text-white font-medium">
                <a href="{{ url('/') }}" class="hover:text-futsal-secondary transition">Beranda</a>
                <a href="{{ url('/venues') }}" class="hover:text-futsal-secondary transition">Lapangan</a>
                <a href="{{ url('/about') }}" class="hover:text-futsal-secondary transition">Tentang Kami</a>
                <a href="{{ url('/contact') }}" class="hover:text-futsal-secondary transition">Kontak</a>
            </div>

            <!-- MENU KANAN (DROPDOWN PROFESIONAL) -->
            <div class="flex items-center gap-4">
                @auth
                    <!-- JIKA SUDAH LOGIN: TAMPILKAN MENU DROPDOWN -->
                    <div class="relative group">
                        <button class="flex items-center gap-3 focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-bold text-white">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-gray-200 uppercase tracking-wider">{{ Auth::user()->role }}</p>
                            </div>
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center border-2 border-white/50 overflow-hidden hover:bg-white/30 transition">
                                <!-- Inisial Nama -->
                                <span class="font-bold text-white text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <i class="fa-solid fa-chevron-down text-white text-xs"></i>
                        </button>

                        <!-- Isi Dropdown -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 z-50 border border-gray-100">
                            
                            <!-- Header Dropdown Mobile -->
                            <div class="px-4 py-3 border-b border-gray-100 sm:hidden">
                                <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>

                            @if(Auth::user()->role === 'admin')
                                <a href="{{ url('/admin/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                                    <i class="fa-solid fa-gauge mr-2 w-5 text-center"></i> Dashboard Admin
                                </a>
                            @endif
                            
                            <!-- LINK KE PROFIL -->
                            <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                                <i class="fa-solid fa-user mr-2 w-5 text-center"></i> Akun Saya
                            </a>

                            @if(Auth::user()->role !== 'admin')
                                <a href="{{ url('/history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                                    <i class="fa-solid fa-clock-rotate-left mr-2 w-5 text-center"></i> Riwayat Booking
                                </a>
                            @endif

                            <div class="border-t border-gray-100 my-1"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition">
                                    <i class="fa-solid fa-arrow-right-from-bracket mr-2 w-5 text-center"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>

                @else
                    <!-- JIKA BELUM LOGIN (Tamu) -->
                    <a href="{{ url('/login') }}" class="text-white font-medium hover:text-futsal-dark transition">Masuk</a>
                    <a href="{{ url('/register') }}" class="bg-futsal-primary text-white px-6 py-2 rounded-full font-medium hover:bg-futsal-dark transition shadow-lg">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <div class="relative h-[650px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1551958219-acbc608c6377?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-futsal-dark/90 via-futsal-primary/50 to-futsal-light/20">
        </div>

        <div class="relative z-10 text-center text-white px-4 mt-10 max-w-5xl">
            <span class="bg-white/20 text-white text-sm font-semibold px-4 py-1 rounded-full border border-white/30 backdrop-blur-sm mb-6 inline-block">
                #1 Platform Booking Futsal Indonesia
            </span>
            
            <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight tracking-tight">
                Main Futsal <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">Tanpa Ribet</span>
            </h1>
            
            <p class="text-lg md:text-xl text-gray-100 mb-10 max-w-2xl mx-auto font-light">
                Temukan lapangan terbaik, cek jadwal real-time, dan booking dalam hitungan detik. Main kapan saja, di mana saja.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <button onclick="document.getElementById('mulai-jelajah').scrollIntoView({ behavior: 'smooth' })"
                    class="btn-bounce bg-futsal-secondary hover:bg-green-500 text-white text-lg font-bold py-4 px-10 rounded-full transition shadow-xl shadow-green-900/30 flex items-center gap-3 group">
                    Jelajahi Sekarang
                    <i class="fa-solid fa-arrow-down group-hover:translate-y-1 transition-transform"></i>
                </button>
            </div>
            
            <div class="mt-12 flex justify-center gap-8 md:gap-16 text-center text-white/80">
                <div>
                    <span class="block text-2xl font-bold text-white">50+</span>
                    <span class="text-sm">Lapangan</span>
                </div>
                <div class="w-px bg-white/30 h-10"></div>
                <div>
                    <span class="block text-2xl font-bold text-white">10k+</span>
                    <span class="text-sm">Pemain</span>
                </div>
                <div class="w-px bg-white/30 h-10"></div>
                <div>
                    <span class="block text-2xl font-bold text-white">24/7</span>
                    <span class="text-sm">Layanan</span>
                </div>
            </div>

        </div>
    </div>

    <!-- TARGET SCROLL -->
    <div id="mulai-jelajah" class="bg-gray-100 py-6 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <span class="w-2 h-8 bg-futsal-primary rounded-full"></span>
                Lapangan Tersedia
            </h2>
        </div>
    </div>

    <!-- FEATURED VENUES (DATA DINAMIS) -->
    <div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Ayo Booking</h2>
            <p class="text-gray-600 mt-2 max-w-2xl mx-auto">"Setiap pemesanan lapangan diwajibkan membayar Uang Muka (Down Payment) minimal 50% dari total biaya sewa."</p>
        </div>

        <!-- GRID LAPANGAN -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @forelse($venues as $venue)
            <div class="bg-white rounded-[2rem] shadow-[0_10px_40px_-15px_rgba(0,0,0,0.1)] hover:shadow-[0_20px_50px_-12px_rgba(0,104,74,0.15)] transition-all duration-500 overflow-hidden border border-gray-100 group flex flex-col h-full hover:-translate-y-2">
                <!-- Photo Lapangan -->
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
            <div class="col-span-3 text-center py-16">
                <div class="text-gray-300 text-6xl mb-4"><i class="fa-regular fa-folder-open"></i></div>
                <h3 class="text-xl font-bold text-gray-600">Belum ada lapangan tersedia</h3>
                <p class="text-gray-500 mt-2">Data database kosong. Silakan jalankan seeder atau tambah manual di admin.</p>
            </div>
            @endforelse

        </div>
        
        <div class="mt-12 text-center">
            <a href="{{ url('/venues') }}" class="inline-block border-2 border-futsal-primary text-futsal-primary font-bold py-3 px-8 rounded-full hover:bg-futsal-primary hover:text-white transition">
                Lihat Semua Lapangan
            </a>
        </div>
    </div>

    <!-- WHY CHOOSE US -->
    <div class="bg-futsal-light py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-12">Kenapa Memilih Biyufaz?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                    <div class="w-16 h-16 bg-futsal-light rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-medal text-3xl text-futsal-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Kualitas Premium</h3>
                    <p class="text-gray-600">Kami bermitra dengan venue terbaik untuk memastikan lapangan dan fasilitas kelas atas.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                    <div class="w-16 h-16 bg-futsal-light rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-shield-halved text-3xl text-futsal-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Pemesanan Aman</h3>
                    <p class="text-gray-600">Transaksi aman dan terjamin.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                    <div class="w-16 h-16 bg-futsal-light rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-bolt text-3xl text-futsal-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Konfirmasi Instan</h3>
                    <p class="text-gray-600">Dapatkan konfirmasi langsung tanpa menunggu lama.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                    <div class="w-16 h-16 bg-futsal-light rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-users text-3xl text-futsal-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Komunitas</h3>
                    <p class="text-gray-600">Gabung dengan komunitas pecinta futsal terbesar.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-futsal-dark pt-16 pb-8 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                        <span class="font-bold text-xl text-futsal-primary">F</span>
                    </div>
                    <span class="font-bold text-2xl text-white">Biyufaz</span>
                </div>
                <p class="mb-6 pr-4">Platform terbaik Anda untuk menemukan dan memesan lapangan futsal terbaik di kota.</p>
            </div>

            <div>
                <h3 class="text-white font-bold mb-6">Perusahaan</h3>
                <ul class="space-y-4">
                    <li><a href="{{ url('/about') }}" class="hover:text-white transition">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-white transition">Karir</a></li>
                    <li><a href="#" class="hover:text-white transition">Mitra</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold mb-6">Bantuan</h3>
                <ul class="space-y-4">
                    <li><a href="#" class="hover:text-white transition">Pusat Bantuan</a></li>
                    <li><a href="#" class="hover:text-white transition">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold mb-6">Hubungi Kami</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-envelope mt-1 text-futsal-primary"></i>
                        <span>support@biyufaz.com</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-brands fa-whatsapp mt-1 text-futsal-primary"></i>
                        <span>+62 852-2045-0801</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot mt-1 text-futsal-primary"></i>
                        <span>Jl. Sudirman No. 123, Jakarta Selatan</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 border-t border-gray-800 pt-8 text-sm text-center">
            <p>&copy; 2025 Biyufaz. All rights reserved.</p>
        </div>
    </footer>

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
