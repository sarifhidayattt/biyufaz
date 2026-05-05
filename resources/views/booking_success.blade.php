<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Berhasil!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-2xl shadow-xl text-center max-w-md w-full">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Booking Berhasil!</h1>
        <p class="text-gray-500 mb-8">Terima kasih <b>{{ $booking->customer_name }}</b>. Pesanan Anda telah kami terima.</p>
        
        <div class="bg-gray-50 p-4 rounded-lg text-left mb-8 space-y-2 border border-gray-100">
            <p class="text-sm text-gray-500">Lapangan: <b class="text-gray-800">{{ $booking->venue->name }}</b></p>
            <p class="text-sm text-gray-500">Tanggal: <b class="text-gray-800">{{ $booking->booking_date }}</b></p>
            <p class="text-sm text-gray-500">Jam: <b class="text-gray-800">{{ implode(', ', $booking->time_slots) }}</b></p>
            <p class="text-sm text-gray-500">Total: <b class="text-green-600 text-lg">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</b></p>
        </div>

        <a href="{{ url('/') }}" class="block w-full bg-green-700 text-white font-bold py-3 rounded-lg hover:bg-green-800 transition">Kembali ke Beranda</a>
    </div>
</body>
</html>