<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Kata Sandi - FutsalPoint</title>
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
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-futsal-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-futsal-dark text-center mb-2">Lupa Kata Sandi?</h1>
        <p class="text-gray-500 text-center text-sm mb-8">Masukkan email yang terdaftar, kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>

        <!-- Menampilkan Pesan Session -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-sm text-center">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-center text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST"> 
            @csrf
            
            <div class="mb-6">
                <label for="email" class="block text-gray-800 font-medium mb-2 text-sm">Email</label>
                <input type="email" id="email" name="email" required placeholder="Masukkan Email Anda" value="{{ old('email') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary focus:ring-1 focus:ring-futsal-primary transition bg-white text-gray-800">
            </div>

            <button type="submit" 
                class="w-full bg-futsal-dark text-white font-bold py-3 rounded-lg hover:bg-green-800 transition shadow-md">
                Kirim Tautan Reset
            </button>

            <div class="mt-6 text-center text-sm text-gray-600">
                Teringat kata sandi Anda? 
                <a href="{{ url('/login') }}" class="text-futsal-primary font-bold hover:underline">Masuk</a>
            </div>
        </form>
    </div>

</body>
</html>
