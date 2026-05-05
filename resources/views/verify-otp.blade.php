<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi OTP - Biyufaz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md text-center">
        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">
            🔐
        </div>
        
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Verifikasi Akun</h2>
        <p class="text-gray-500 text-sm mb-6">Masukkan kode OTP yang telah kami kirimkan.</p>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 text-blue-700 p-3 rounded-lg mb-4 text-sm">
                ℹ️ {{ session('info') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif


        <form action="{{ route('otp.process') }}" method="POST">
            @csrf
            <div class="mb-6">
                <input type="text" name="otp" placeholder="123456" maxlength="6"
                    class="w-full text-center text-3xl font-bold tracking-widest py-3 border-b-2 border-gray-300 focus:border-green-600 focus:outline-none transition-colors"
                    required autofocus>
            </div>

            <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-3 rounded-xl transition shadow-lg">
                Verifikasi
            </button>
        </form>

        <p class="mt-6 text-xs text-gray-400">
            Tidak menerima kode? <a href="#" class="text-green-600 font-bold hover:underline">Kirim Ulang</a>
        </p>
    </div>

</body>
</html>