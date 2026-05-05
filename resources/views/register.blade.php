<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Akun - FutsalPoint</title>
    <!-- Script Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Konfigurasi tema kustom
        // Pastikan ini dijalankan setelah script CDN di atas
        if (typeof tailwind !== 'undefined') {
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            futsal: {
                                dark: '#00382B',
                                primary: '#00684A',
                            }
                        },
                        fontFamily: {
                            sans: ['Poppins', 'sans-serif'],
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen w-full flex items-center justify-center py-10">

    <div class="bg-white w-full max-w-lg p-8 rounded-2xl shadow-lg border border-gray-100 mx-4">
        
        <div class="flex flex-col items-center mb-6">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-2">
                <!-- Ikon Bola -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-futsal-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-futsal-dark text-center mb-2">Buat Akun</h1>
        <p class="text-gray-500 text-center text-sm mb-8">Bergabung dengan komunitas futsal kami hari ini</p>

        <!-- Menampilkan Pesan Session -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4 text-sm">
                ℹ️ {{ session('info') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Menampilkan Error Validasi -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm">
                <strong class="font-bold">Oops!</strong>
                <ul class="list-disc pl-4 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM MENGARAH KE REGISTER PROCESS -->
        <form action="{{ route('register.process') }}" method="POST" class="space-y-5" autocomplete="off">
            @csrf
            
            <div>
                <label for="name" class="block text-gray-800 font-medium mb-2 text-sm">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap" 
                    autocomplete="new-password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary focus:ring-1 focus:ring-futsal-primary transition bg-white text-gray-800">
            </div>

            <div>
                <label for="email" class="block text-gray-800 font-medium mb-2 text-sm">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary focus:ring-1 focus:ring-futsal-primary transition bg-white text-gray-800">
            </div>

            <div>
                <label for="phone" class="block text-gray-800 font-medium mb-2 text-sm">Nomor Telepon</label>
                <input type="number" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="Masukkan nomor telepon" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary focus:ring-1 focus:ring-futsal-primary transition bg-white text-gray-800">
            </div>

            <div>
                <label for="password" class="block text-gray-800 font-medium mb-2 text-sm">Kata Sandi</label>
                <input type="password" id="password" name="password" required placeholder="Buat kata sandi" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary focus:ring-1 focus:ring-futsal-primary transition bg-white text-gray-800">
            </div>

            <div>
                <label class="block text-gray-800 font-medium mb-2 text-sm">Kirim Kode OTP Melalui</label>
                <div class="flex gap-6 mt-2">
                    <label class="flex items-center space-x-2 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="radio" name="otp_method" value="whatsapp" class="peer h-4 w-4 cursor-pointer appearance-none rounded-full border border-gray-300 checked:border-futsal-primary checked:bg-futsal-primary transition-all" checked>
                            <div class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 peer-checked:opacity-100 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5" viewBox="0 0 20 20" fill="currentColor">
                                    <circle cx="10" cy="10" r="6" />
                                </svg>
                            </div>
                        </div>
                        <span class="text-gray-700 text-sm group-hover:text-futsal-primary transition">Nomor Telepon (WA)</span>
                    </label>

                    <label class="flex items-center space-x-2 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="radio" name="otp_method" value="email" class="peer h-4 w-4 cursor-pointer appearance-none rounded-full border border-gray-300 checked:border-futsal-primary checked:bg-futsal-primary transition-all">
                            <div class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 peer-checked:opacity-100 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5" viewBox="0 0 20 20" fill="currentColor">
                                    <circle cx="10" cy="10" r="6" />
                                </svg>
                            </div>
                        </div>
                        <span class="text-gray-700 text-sm group-hover:text-futsal-primary transition">Email (Gmail)</span>
                    </label>
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-futsal-dark text-white font-bold py-3 rounded-lg hover:bg-green-800 transition shadow-md mt-4">
                Buat Akun
            </button>

            <div class="mt-6 text-center text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ url('/login') }}" class="text-futsal-primary font-bold hover:underline">Masuk</a>
            </div>
        </form>
    </div>

</body>
</html>
