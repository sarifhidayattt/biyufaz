<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hubungi Kami - FutsalPoint</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        futsal: {
                            dark: '#00382B',      /* Hijau Gelap */
                            primary: '#00684A',   /* Hijau Utama */
                            accent: '#D97706',    /* Oranye/Emas */
                            brown: '#A0522D',     /* Coklat (Venue Owners) */
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
<body class="bg-gray-100 text-gray-800 pb-[72px] md:pb-0">

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
                    <a href="{{ url('/about') }}" class="text-gray-500 hover:text-futsal-primary transition">Tentang Kami</a>
                    <a href="{{ url('/contact') }}" class="text-futsal-primary font-bold transition">Kontak</a>
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

    <div class="pt-16 pb-10 text-center px-4">
        <h1 class="text-4xl font-bold text-futsal-dark mb-4">Hubungi Kami</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">
            Punya pertanyaan tentang Biyufaz? Butuh bantuan dengan pesanan Anda? Kami siap membantu! Hubungi kami melalui salah satu saluran di bawah ini.
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow-sm">
                <div class="flex items-center gap-3 mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-futsal-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <h2 class="text-2xl font-bold text-futsal-primary">Kirim Pesan</h2>
                </div>

                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Depan</label>
                            <input type="text" placeholder="Masukkan nama depan" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Belakang</label>
                            <input type="text" placeholder="Masukkan nama belakang" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary bg-gray-50">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" placeholder="Masukkan Email Anda" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary bg-gray-50">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                        <input type="text" placeholder="Apa yang bisa kami bantu?" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary bg-gray-50">
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                        <textarea rows="5" placeholder="Ceritakan lebih lanjut tentang pertanyaan Anda..." class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary bg-gray-50"></textarea>
                    </div>

                    <button type="button" class="w-full bg-futsal-dark text-white font-bold py-3 rounded-lg hover:bg-green-900 transition shadow-lg shadow-green-900/20">
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <div class="lg:col-span-1 space-y-4">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-start gap-4">
                    <div class="text-futsal-primary mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Layanan Telepon</h3>
                        <p class="text-gray-500 text-sm mt-1">+62 21 4555 6789</p>
                        <p class="text-gray-400 text-xs">Sen - Ming: 09.00 - 18.00</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-start gap-4">
                    <div class="text-futsal-primary mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Layanan Email</h3>
                        <p class="text-gray-500 text-sm mt-1">support@futsalpoint.com</p>
                        <p class="text-gray-400 text-xs">Kami membalas dalam 24 jam</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-start gap-4">
                    <div class="text-futsal-primary mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Lokasi Kantor</h3>
                        <p class="text-gray-500 text-sm mt-1">Menara Futsal, Lantai 5<br>Jakarta Selatan</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-start gap-4">
                    <div class="text-futsal-primary mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Jam Operasional</h3>
                        <p class="text-gray-500 text-sm mt-1">Sen - Jum: 09.00 - 18.00<br>Sab - Ming: 10.00 - 16.00</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <h2 class="text-3xl font-bold text-futsal-dark text-center mb-12">Pertanyaan yang Sering Diajukan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="font-bold text-futsal-primary text-lg mb-3">Bagaimana cara memesan lapangan futsal?</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Cukup jelajahi lapangan yang tersedia, pilih tanggal dan waktu yang Anda inginkan, dan selesaikan proses pemesanan. Anda akan menerima konfirmasi instan.</p>
            </div>

            <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="font-bold text-futsal-accent text-lg mb-3">Bisakah saya membatalkan pesanan?</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Ya, Anda dapat membatalkan pesanan hingga 24 jam sebelum jadwal main untuk pengembalian dana penuh. Cek kebijakan pembatalan kami untuk detailnya.</p>
            </div>

            <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="font-bold text-futsal-primary text-lg mb-3">Apakah ada diskon grup?</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Kami menawarkan tarif khusus untuk pemesanan rutin dan grup besar. Hubungi kami untuk mendiskusikan harga khusus tim atau organisasi Anda.</p>
            </div>

            <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="font-bold text-futsal-accent text-lg mb-3">Bagaimana cara menjadi mitra lapangan?</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Jika Anda memiliki fasilitas futsal dan ingin bergabung dengan platform kami, hubungi tim kemitraan kami di partners@futsalpoint.com.</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="bg-[#104a30] rounded-xl p-10 text-center text-white shadow-lg">
                <div class="w-12 h-12 mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Pemain</h3>
                <p class="text-gray-300 text-xs mb-6 px-4">Butuh bantuan pemesanan, pembayaran, atau masalah akun?</p>
                <button class="border border-white text-white text-sm font-semibold px-6 py-2 rounded hover:bg-white hover:text-[#104a30] transition">Bantuan Pemain</button>
            </div>

            <div class="bg-[#a05a2c] rounded-xl p-10 text-center text-white shadow-lg">
                <div class="w-12 h-12 mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Pemilik Lapangan</h3>
                <p class="text-gray-300 text-xs mb-6 px-4">Tertarik mendaftarkan lapangan Anda atau butuh dukungan kemitraan?</p>
                <button class="border border-white text-white text-sm font-semibold px-6 py-2 rounded hover:bg-white hover:text-[#a05a2c] transition">Bermitra dengan Kami</button>
            </div>

            <div class="bg-gradient-to-br from-green-700 to-yellow-600 rounded-xl p-10 text-center text-white shadow-lg">
                <div class="w-12 h-12 mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Pertanyaan Umum</h3>
                <p class="text-gray-300 text-xs mb-6 px-4">Punya pertanyaan tentang platform kami atau ingin memberi masukan?</p>
                <button class="border border-white text-white text-sm font-semibold px-6 py-2 rounded hover:bg-white hover:text-green-700 transition">Hubungi Kami</button>
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