<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - Biyufaz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        futsal: {
                            dark: '#00382B',      /* Hijau Footer */
                            primary: '#00684A',   /* Hijau Utama */
                            accent: '#D97706',    /* Oranye/Emas */
                            light: '#F3F4F6',     /* Abu-abu background */
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
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 pb-[72px] md:pb-0">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-futsal-primary rounded-full flex items-center justify-center shadow-md">
                        <span class="font-bold text-xl text-white">F</span>
                    </div>
                    <span class="font-bold text-xl text-futsal-dark">Biyufaz</span>
                </a>

                <div class="hidden md:flex space-x-8 font-medium">
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-futsal-primary transition">Beranda</a>
                    <a href="{{ url('/venues') }}" class="text-gray-500 hover:text-futsal-primary transition">Lapangan</a>
                    <a href="{{ url('/about') }}" class="text-futsal-primary font-bold transition">Tentang Kami</a>
                    <a href="{{ url('/contact') }}" class="hover:text-futsal-secondary transition">Kontak</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-3 focus:outline-none">
                                <div class="text-right hidden sm:block">
                                    <p class="text-sm font-bold text-futsal-dark">{{ Auth::user()->name }}</p>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-wider">{{ Auth::user()->role }}</p>
                                </div>
                                <div class="w-10 h-10 bg-futsal-primary/10 rounded-full flex items-center justify-center border-2 border-futsal-primary/30 overflow-hidden hover:bg-futsal-primary/20 transition">
                                    <span class="font-bold text-futsal-primary text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <i class="fa-solid fa-chevron-down text-gray-500 text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 z-50 border border-gray-100">
                                <div class="px-4 py-3 border-b border-gray-100 sm:hidden">
                                    <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ url('/admin/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                                        <i class="fa-solid fa-gauge mr-2 w-5 text-center"></i> Dashboard Admin
                                    </a>
                                @endif
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
                        <a href="{{ url('/login') }}" class="text-gray-600 font-medium hover:text-futsal-primary">Masuk</a>
                        <a href="{{ url('/register') }}" class="bg-futsal-primary text-white px-5 py-2 rounded-lg font-medium hover:bg-futsal-dark transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-16 pb-12 bg-gray-50 text-center px-4">
        <h1 class="text-4xl font-bold text-futsal-dark mb-4">Tentang Biyufaz</h1>
        <p class="text-gray-600 max-w-2xl mx-auto leading-relaxed text-justify">
           "Futsal itu bukan cuma soal keringat, tapi soal kebersamaan, strategi, dan momen seru bareng teman-teman. 
Tapi, kami tahu rasanya bad mood saat semangat sudah tinggi, tapi lapangan penuh semua atau telepon pengelola nggak diangkat-angkat. 
Karena itulah Biyufaz lahir. 
Dibuat dari sesama pecinta futsal untuk komunitas futsal, misi kami sederhana: Bikin booking lapangan secepat tendangan penalti. 
Nggak perlu lagi keliling kota atau telepon sana-sini.
Cukup klik, pilih, dan main! Kami ingin membangun komunitas futsal yang lebih besar dan solid. Di sini, Anda bisa menemukan lapangan terbaik, membandingkan fasilitas, dan langsung mengamankan jadwal tanding tim Anda dalam hitungan detik. 
Ayo main, kami yang urus lapangannya!"
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 h-full">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full border-2 border-futsal-primary flex items-center justify-center text-futsal-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-futsal-primary">Misi Kami</h2>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Untuk merevolusi cara orang menemukan, memesan, dan menikmati pengalaman futsal. Kami percaya setiap orang berhak mendapatkan akses ke fasilitas olahraga berkualitas dan kegembiraan dalam bermain futsal.
                </p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 h-full">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full border-2 border-futsal-accent flex items-center justify-center text-futsal-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-futsal-accent">Visi Kami</h2>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Menjadi platform pemesanan futsal terkemuka secara global, membina komunitas pemain, dan mendukung pemilik lapangan lokal agar dapat berkembang di era digital.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-10 mb-20">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <h3 class="text-4xl font-bold text-futsal-primary">500+</h3>
                <p class="text-gray-500 text-sm mt-1">Lapangan</p>
            </div>
            <div>
                <h3 class="text-4xl font-bold text-futsal-accent">10K+</h3>
                <p class="text-gray-500 text-sm mt-1">Pemain</p>
            </div>
            <div>
                <h3 class="text-4xl font-bold text-futsal-dark">50K</h3>
                <p class="text-gray-500 text-sm mt-1">Booking</p>
            </div>
            <div>
                <h3 class="text-4xl font-bold text-futsal-accent">25+</h3>
                <p class="text-gray-500 text-sm mt-1">Lokasi</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 text-center">
        <h2 class="text-3xl font-bold text-futsal-dark mb-12">Mengapa Memilih Biyufaz?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="bg-white p-8 rounded-xl border border-futsal-primary/20 hover:shadow-lg transition">
                <div class="w-12 h-12 mx-auto mb-4 text-futsal-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-futsal-primary mb-2">Booking Instan</h3>
                <p class="text-gray-500 text-sm">Pesan lapangan futsal favorit Anda dalam hitungan detik dengan proses pemesanan kami yang efisien.</p>
            </div>

            <div class="bg-white p-8 rounded-xl border border-futsal-accent/30 hover:shadow-lg transition">
                <div class="w-12 h-12 mx-auto mb-4 text-futsal-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-futsal-accent mb-2">Lokasi Strategis</h3>
                <p class="text-gray-500 text-sm">Akses lapangan futsal premium di lokasi-lokasi terbaik di kota Anda.</p>
            </div>

            <div class="bg-white p-8 rounded-xl border border-futsal-primary/20 hover:shadow-lg transition">
                <div class="w-12 h-12 mx-auto mb-4 text-futsal-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-futsal-primary mb-2">Komunitas</h3>
                <p class="text-gray-500 text-sm">Bergabunglah dengan komunitas pecinta futsal yang aktif dan bangun koneksi baru.</p>
            </div>

        </div>
    </div>



    <div class="max-w-7xl mx-auto px-4 mb-20">
        <div class="bg-gradient-to-r from-[#C29249] to-[#6FA867] rounded-2xl py-16 px-8 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Siap Bermain?</h2>
            <p class="max-w-2xl mx-auto mb-8 text-white/90">Bergabunglah dengan ribuan pemain yang mempercayai Biyufaz untuk kebutuhan futsal mereka. Pesan jadwal main Anda hari ini!</p>
            <div class="flex justify-center gap-4">
                <a href="#" class="bg-white text-futsal-dark font-bold px-6 py-3 rounded-lg hover:bg-gray-100 transition">Mulai Sekarang</a>
                <a href="#" class="border border-white text-white font-bold px-6 py-3 rounded-lg hover:bg-white/10 transition">Lihat Lapangan</a>
            </div>
        </div>
    </div>

    <footer class="bg-futsal-dark pt-16 pb-8 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                        <span class="font-bold text-xl text-futsal-primary">F</span>
                    </div>
                    <span class="font-bold text-2xl text-white">Biyufaz</span>
                </div>
                <p class="mb-6 pr-4">Destinasi utama Anda untuk pemesanan lapangan futsal. Rasakan fasilitas terbaik dan proses pemesanan yang lancar.</p>
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
            <p>&copy; 2025 Biyufaz. Hak Cipta Dilindungi.</p>
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