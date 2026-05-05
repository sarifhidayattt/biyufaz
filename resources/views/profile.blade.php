<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Saya - Biyufaz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        futsal: {
                            dark: '#064e3b',      /* Emerald 900 - Hijau Gelap Mewah */
                            primary: '#10b981',   /* Emerald 500 - Hijau Utama */
                            secondary: '#34d399', /* Emerald 400 - Hijau Muda */
                            light: '#ecfdf5',     /* Emerald 50 - Background Terang */
                            accent: '#065f46',    /* Emerald 800 - Aksen Gelap */
                            surface: '#f8fafc',   /* Slate 50 - Background Halaman */
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'glow': '0 0 15px rgba(16, 185, 129, 0.3)',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-futsal-surface text-slate-600 antialiased selection:bg-futsal-primary selection:text-white pb-[72px] md:pb-0">

    <!-- NAVBAR PREMIUM -->
    <nav class="bg-white/90 backdrop-blur-lg border-b border-slate-200 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 bg-gradient-to-br from-futsal-primary to-futsal-accent rounded-xl flex items-center justify-center text-white shadow-lg shadow-futsal-primary/30 group-hover:scale-105 transition-transform duration-300">
                        <span class="font-bold text-lg">B</span>
                    </div>
                    <span class="font-bold text-xl text-slate-800 tracking-tight">Biyufaz</span>
                </a>
                <a href="{{ url('/') }}" class="text-sm font-semibold text-slate-500 hover:text-futsal-primary transition-colors flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-futsal-light">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </nav>

    <!-- HEADER BACKGROUND DENGAN POLA HALUS -->
    <div class="relative h-72 bg-futsal-dark overflow-hidden">
        <!-- Gradient Mesh -->
        <div class="absolute inset-0 bg-gradient-to-br from-futsal-dark via-futsal-accent to-black opacity-90"></div>
        
        <!-- Elemen Dekoratif -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-futsal-primary/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-futsal-secondary/10 rounded-full blur-3xl translate-y-1/3 -translate-x-1/4"></div>
        
        <!-- Pola Grid -->
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative h-full flex flex-col justify-center pb-12">
            <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">Pengaturan Akun</h1>
            <p class="text-futsal-secondary text-base font-medium max-w-lg">Kelola informasi profil, keamanan, dan preferensi akun Anda dalam satu tempat.</p>
        </div>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-28 pb-24 relative z-10">
        
        @if(session('success'))
        <div class="mb-8 bg-white border-l-4 border-futsal-primary px-6 py-4 rounded-r-xl shadow-soft flex items-center gap-4 animate-fade-in-up">
            <div class="w-10 h-10 bg-futsal-light rounded-full flex items-center justify-center text-futsal-primary shrink-0">
                <i class="fa-solid fa-check text-lg"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800">Berhasil Diperbarui!</p>
                <p class="text-sm text-slate-500">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
            
            <!-- SIDEBAR KIRI: KARTU PROFIL -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Kartu Identitas -->
                <div class="bg-white rounded-3xl shadow-soft border border-slate-100 overflow-hidden group">
                    <div class="p-8 text-center bg-gradient-to-b from-white to-slate-50/50">
                        <div class="relative inline-block mb-5">
                            <div class="w-32 h-32 bg-slate-100 rounded-full p-1 ring-4 ring-white shadow-xl mx-auto">
                                <div class="w-full h-full rounded-full bg-gradient-to-br from-futsal-primary to-futsal-secondary flex items-center justify-center text-5xl font-bold text-white uppercase overflow-hidden">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="absolute bottom-2 right-2 bg-green-500 w-7 h-7 rounded-full border-4 border-white shadow-sm" title="Status: Aktif"></div>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-slate-800 mb-1">{{ $user->name }}</h2>
                        <p class="text-sm text-slate-500 font-medium mb-5">{{ $user->email }}</p>
                        
                        <div class="flex justify-center gap-2">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold bg-futsal-light text-futsal-dark border border-futsal-primary/10 uppercase tracking-wider">
                                <i class="fa-solid fa-user-shield"></i> {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Statistik Mini -->
                    <div class="grid grid-cols-2 divide-x divide-slate-100 border-t border-slate-100 bg-white">
                        <div class="p-4 text-center hover:bg-slate-50 transition-colors cursor-default">
                            <span class="block text-2xl font-black text-slate-800">0</span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Booking</span>
                        </div>
                        <div class="p-4 text-center hover:bg-slate-50 transition-colors cursor-default">
                            <span class="block text-2xl font-black text-futsal-primary">-</span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Poin</span>
                        </div>
                    </div>

                    <div class="p-6 border-t border-slate-100">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-3 text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 font-bold py-3.5 rounded-xl transition-all duration-200 text-sm group-hover:shadow-md">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar Akun
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Kartu Bantuan -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-3xl -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-4 backdrop-blur-sm">
                            <i class="fa-solid fa-headset text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Butuh Bantuan?</h3>
                        <p class="text-slate-300 text-sm mb-6 leading-relaxed opacity-90">Jika Anda mengalami kendala teknis atau ingin mengubah data sensitif, hubungi tim kami.</p>
                        <a href="https://wa.me/" class="w-full text-center text-sm font-bold text-slate-900 bg-white hover:bg-slate-100 px-6 py-3 rounded-xl inline-block transition-colors shadow-lg">
                            Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- KONTEN KANAN: FORMULIR -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-3xl shadow-soft border border-slate-100 overflow-hidden">
                    <!-- Header Form -->
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="font-bold text-xl text-slate-800">Edit Informasi</h3>
                            <p class="text-sm text-slate-500 mt-1">Perbarui data diri dan preferensi Anda.</p>
                        </div>
                        <span class="text-xs font-bold text-futsal-primary bg-futsal-light px-4 py-2 rounded-full border border-futsal-primary/10">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Mode Edit
                        </span>
                    </div>

                    <div class="p-8 lg:p-10">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            
                            <!-- Bagian 1: Data Diri -->
                            <div class="mb-10">
                                <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                                    <i class="fa-regular fa-id-card"></i> Data Pribadi
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Nama Lengkap -->
                                    <div class="col-span-1 md:col-span-2 group">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2 group-focus-within:text-futsal-primary transition-colors">Nama Lengkap</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-futsal-primary transition-colors">
                                                <i class="fa-regular fa-user text-lg"></i>
                                            </span>
                                            <input type="text" name="name" value="{{ $user->name }}" 
                                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:border-futsal-primary focus:ring-4 focus:ring-futsal-primary/10 outline-none transition-all placeholder-slate-400" placeholder="Masukkan nama lengkap">
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="group">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2 group-focus-within:text-futsal-primary transition-colors">Alamat Email</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-futsal-primary transition-colors">
                                                <i class="fa-regular fa-envelope text-lg"></i>
                                            </span>
                                            <input type="email" name="email" value="{{ $user->email }}" 
                                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:border-futsal-primary focus:ring-4 focus:ring-futsal-primary/10 outline-none transition-all placeholder-slate-400">
                                        </div>
                                    </div>

                                    <!-- No HP -->
                                    <div class="group">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2 group-focus-within:text-futsal-primary transition-colors">No. WhatsApp</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-futsal-primary transition-colors">
                                                <i class="fa-brands fa-whatsapp text-lg"></i>
                                            </span>
                                            <input type="number" name="phone" value="{{ $user->phone }}" 
                                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:border-futsal-primary focus:ring-4 focus:ring-futsal-primary/10 outline-none transition-all placeholder-slate-400">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Separator -->
                            <div class="border-t border-slate-100 mb-10"></div>

                            <!-- Bagian 2: Keamanan -->
                            <div class="mb-8">
                                <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                                    <i class="fa-solid fa-lock"></i> Keamanan Akun
                                </h4>
                                <div class="bg-futsal-light/50 rounded-2xl p-8 border border-futsal-primary/10 hover:border-futsal-primary/30 transition-colors">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Password Baru</label>
                                            <input type="password" name="password" placeholder="Kosongkan jika tidak diganti" 
                                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:border-futsal-primary focus:ring-4 focus:ring-futsal-primary/10 outline-none transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru" 
                                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:border-futsal-primary focus:ring-4 focus:ring-futsal-primary/10 outline-none transition-all">
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-4 flex items-center gap-2">
                                        <i class="fa-solid fa-circle-info"></i> Password minimal 8 karakter.
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex items-center justify-end gap-4 pt-4">
                                <a href="{{ url('/') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-all">
                                    Batal
                                </a>
                                <button type="submit" class="bg-gradient-to-r from-futsal-primary to-futsal-secondary hover:to-futsal-primary text-white font-bold py-3.5 px-10 rounded-xl shadow-lg shadow-futsal-primary/30 transition-all transform hover:-translate-y-1 active:translate-y-0 active:scale-95 flex items-center gap-2">
                                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

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