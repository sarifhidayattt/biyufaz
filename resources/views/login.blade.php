<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - FutsalPoint</title>
    <!-- Script Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        if (typeof tailwind !== 'undefined') {
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            futsal: {
                                dark: '#00382B',
                                primary: '#00684A',
                                accent: '#D97706',    
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
<body class="bg-gray-100 h-screen w-full flex items-center justify-center">

    <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-lg border border-gray-100 mx-4">
        
        <div class="flex flex-col items-center mb-6">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-futsal-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-futsal-dark text-center mb-2">Selamat Datang Kembali</h1>
        <p class="text-gray-500 text-center text-sm mb-8">Masuk untuk memesan lapangan futsal</p>

        <!-- Menampilkan Pesan Session -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-sm text-center">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4 text-sm text-center">
                ℹ️ {{ session('info') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm text-center">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Menampilkan Error Login -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-center text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- FORM LOGIN MENGARAH KE LOGIN PROCESS -->
        <form action="{{ route('login.process') }}" method="POST"> 
            @csrf
            
            <div class="mb-5">
                <label for="email" class="block text-gray-800 font-medium mb-2 text-sm">Email</label>
                <input type="email" id="email" name="email" required placeholder="Masukkan Email" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary focus:ring-1 focus:ring-futsal-primary transition bg-white text-gray-800">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-800 font-medium mb-2 text-sm">Kata Sandi</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan Kata Sandi" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary focus:ring-1 focus:ring-futsal-primary transition bg-white text-gray-800">
                <div class="flex justify-end mt-2">
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-futsal-primary hover:underline">Lupa Sandi?</a>
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-futsal-dark text-white font-bold py-3 rounded-lg hover:bg-green-800 transition shadow-md">
                Masuk
            </button>

            <div class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ url('/register') }}" class="text-futsal-primary font-bold hover:underline">Daftar</a>
            </div>
        </form>
    </div>

    <a href="{{ url('/') }}" class="absolute top-6 left-6 text-gray-500 hover:text-futsal-dark flex items-center gap-2 text-sm font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Beranda
    </a>

</body>
</html>