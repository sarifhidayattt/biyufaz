<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Ulang Kata Sandi - FutsalPoint</title>
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
<body class="bg-gray-100 h-screen w-full flex items-center justify-center py-10">

    <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-lg border border-gray-100 mx-4">
        
        <div class="flex flex-col items-center mb-6">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-futsal-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-futsal-dark text-center mb-2">Kata Sandi Baru</h1>
        <p class="text-gray-500 text-center text-sm mb-8">Silakan masukkan kata sandi baru untuk akun Anda.</p>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-center text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST"> 
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-5">
                <label for="email" class="block text-gray-800 font-medium mb-2 text-sm">Email</label>
                <input type="email" id="email" name="email" required value="{{ $email ?? old('email') }}" readonly
                    class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-3 focus:outline-none text-gray-500 cursor-not-allowed">
            </div>

            <div class="mb-5">
                <label for="password" class="block text-gray-800 font-medium mb-2 text-sm">Kata Sandi Baru</label>
                <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary focus:ring-1 focus:ring-futsal-primary transition bg-white text-gray-800">
            </div>

            <div class="mb-8">
                <label for="password_confirmation" class="block text-gray-800 font-medium mb-2 text-sm">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi kata sandi baru" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-futsal-primary focus:ring-1 focus:ring-futsal-primary transition bg-white text-gray-800">
            </div>

            <button type="submit" 
                class="w-full bg-futsal-dark text-white font-bold py-3 rounded-lg hover:bg-green-800 transition shadow-md">
                Simpan Kata Sandi
            </button>
        </form>
    </div>

</body>
</html>
