<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Biyufaz</title>
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
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .copy-btn:active { transform: scale(0.95); }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.4s ease forwards; }
        .fade-up-1 { animation-delay: 0.05s; opacity: 0; }
        .fade-up-2 { animation-delay: 0.1s; opacity: 0; }
        .fade-up-3 { animation-delay: 0.15s; opacity: 0; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 pb-[80px] md:pb-0">

    @if(isset($booking) && isset($amountToPay))

    {{-- ===== NAVBAR ===== --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <a href="{{ route('booking.history') }}" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </a>
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 bg-futsal-primary rounded-full flex items-center justify-center">
                            <span class="font-bold text-sm text-white">F</span>
                        </div>
                        <span class="font-bold text-gray-800">Pembayaran</span>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-3 py-1.5 rounded-full border border-amber-200 uppercase tracking-wider">
                    <i class="fa-solid fa-clock mr-1"></i> Menunggu Bayar
                </span>
            </div>
        </div>
    </nav>

    {{-- ===== KONTEN UTAMA ===== --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Notifikasi Sukses --}}
        <div class="bg-green-50 border border-green-200 rounded-2xl p-5 mb-6 flex items-start gap-4 fade-up">
            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fa-solid fa-check-circle text-lg"></i>
            </div>
            <div>
                <h3 class="font-bold text-green-800 text-sm">Pesanan Berhasil Dibuat!</h3>
                <p class="text-green-700 text-xs mt-1 leading-relaxed">
                    Lakukan pembayaran sesuai metode di bawah, lalu <strong>konfirmasi via WhatsApp</strong> agar admin memverifikasi pesanan Anda.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- ===== KOLOM KIRI: STRUK PESANAN ===== --}}
            <div class="lg:col-span-2 fade-up fade-up-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden lg:sticky lg:top-24">
                    
                    {{-- Header Struk --}}
                    <div class="bg-futsal-dark text-white p-5 text-center relative overflow-hidden">
                        <div class="absolute -top-6 -right-6 w-24 h-24 bg-futsal-primary rounded-full blur-2xl opacity-30"></div>
                        <p class="text-[10px] font-bold text-futsal-secondary uppercase tracking-[0.2em] mb-1 relative">Total Tagihan</p>
                        <p class="text-3xl font-black tracking-tight relative">
                            <span class="text-lg text-white/60">Rp</span> {{ number_format($amountToPay, 0, ',', '.') }}
                        </p>
                        <p class="text-[10px] text-white/40 mt-2 font-medium">{{ $booking->order_id ?? '-' }}</p>
                    </div>

                    {{-- Detail Pesanan --}}
                    <div class="p-5 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-xs">Pemesan</span>
                            <span class="font-semibold text-gray-800 text-xs">{{ $booking->customer_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-xs">WhatsApp</span>
                            <span class="font-semibold text-gray-800 text-xs">{{ $booking->customer_phone }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-xs">Tempat</span>
                            <span class="font-semibold text-gray-800 text-xs">{{ $booking->venue->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-xs">Tanggal Main</span>
                            <span class="font-semibold text-gray-800 text-xs">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="text-gray-400 text-xs">Jam Sewa</span>
                            <div class="text-right flex flex-wrap justify-end gap-1">
                                @if(is_array($booking->time_slots))
                                    @foreach($booking->time_slots as $slot)
                                        <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-[10px] font-bold">{{ $slot }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        
                        <div class="border-t border-dashed border-gray-200 pt-3 mt-3 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-400 text-xs">Total Sewa</span>
                                <span class="font-bold text-gray-800 text-xs">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-xs">Tipe Bayar</span>
                                <span class="font-bold text-xs px-2 py-0.5 rounded {{ $booking->payment_type === 'dp' ? 'text-orange-700 bg-orange-50' : 'text-green-700 bg-green-50' }}">
                                    {{ $booking->payment_type === 'dp' ? 'DP 50%' : 'LUNAS' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-xs">Status</span>
                                <span class="font-bold text-xs text-amber-700 bg-amber-50 px-2 py-0.5 rounded uppercase">
                                    {{ $booking->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== KOLOM KANAN: METODE PEMBAYARAN ===== --}}
            <div class="lg:col-span-3 space-y-4 fade-up fade-up-2">

                <h2 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-wallet text-futsal-primary"></i> Pilih Metode Pembayaran
                </h2>

                @if(isset($manualMethods) && $manualMethods->count() > 0)
                    @foreach($manualMethods as $method)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                        {{-- Header Metode --}}
                        <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                @if($method->logo == 'qris')
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" class="h-5" alt="QRIS">
                                @else
                                    <span class="text-[10px] font-black text-futsal-primary bg-futsal-light px-2 py-1 rounded uppercase">{{ $method->logo }}</span>
                                @endif
                                <span class="font-semibold text-gray-800 text-sm">{{ $method->name }}</span>
                            </div>
                        </div>

                        {{-- Isi Metode --}}
                        <div class="p-5">
                            @if($method->logo == 'qris')
                                {{-- QRIS --}}
                                <div class="text-center">
                                    <div class="inline-block bg-white p-3 rounded-xl border-2 border-dashed border-gray-200 mb-3">
                                        <img src="{{ asset('images/qris.jpg') }}" class="w-48 h-auto rounded-lg" alt="QRIS" onerror="this.src='https://placehold.co/200x200/f8fafc/94a3b8?text=QRIS'">
                                    </div>
                                    <p class="text-xs text-gray-500 mb-3">Scan QR menggunakan e-wallet atau mobile banking</p>
                                    <div class="flex items-center justify-center gap-3 text-[10px] font-semibold text-gray-400">
                                        <span>GoPay</span><span class="text-gray-200">•</span>
                                        <span>OVO</span><span class="text-gray-200">•</span>
                                        <span>DANA</span><span class="text-gray-200">•</span>
                                        <span>ShopeePay</span><span class="text-gray-200">•</span>
                                        <span>M-Banking</span>
                                    </div>
                                </div>
                            @else
                                {{-- Transfer Bank / E-Wallet --}}
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 mb-3">
                                    <div class="flex justify-between items-center mb-1.5">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nomor Rekening / Akun</span>
                                        <button onclick="copyToClipboard('{{ $method->account_number }}', this)" class="copy-btn text-[10px] font-semibold text-futsal-primary bg-futsal-light px-2 py-0.5 rounded hover:bg-green-100 transition border border-futsal-primary/20">
                                            <i class="fa-regular fa-copy mr-0.5"></i> Salin
                                        </button>
                                    </div>
                                    <p class="font-black text-gray-800 text-lg tabular-nums tracking-wider">{{ $method->account_number }}</p>
                                    <p class="text-xs text-gray-500 mt-1">a.n. <strong>{{ $method->account_name }}</strong></p>
                                </div>
                            @endif

                            {{-- Nominal --}}
                            <div class="bg-futsal-light rounded-xl p-4 border border-futsal-primary/10 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] font-bold text-futsal-primary uppercase tracking-wider block">Nominal Transfer</span>
                                    <span class="font-black text-futsal-dark text-xl tabular-nums">Rp {{ number_format($amountToPay, 0, ',', '.') }}</span>
                                </div>
                                <button onclick="copyToClipboard('{{ (int)$amountToPay }}', this)" class="copy-btn w-9 h-9 rounded-lg bg-white text-futsal-primary border border-futsal-primary/20 flex items-center justify-center hover:bg-futsal-primary hover:text-white transition">
                                    <i class="fa-regular fa-copy text-sm"></i>
                                </button>
                            </div>

                            @if($method->instructions)
                            <p class="text-[10px] text-gray-400 mt-3 leading-relaxed">
                                <i class="fa-solid fa-circle-info text-gray-300 mr-1"></i>{{ $method->instructions }}
                            </p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    {{-- Fallback --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                        <div class="w-14 h-14 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-wallet text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-700 mb-1 text-sm">Metode Pembayaran Belum Tersedia</h3>
                        <p class="text-gray-500 text-xs">Hubungi admin melalui WhatsApp untuk informasi pembayaran.</p>
                    </div>
                @endif

                {{-- ===== TOMBOL KONFIRMASI WA ===== --}}
                <div class="pt-2 fade-up fade-up-3">
                    <a href="https://wa.me/{{ env('ADMIN_WHATSAPP', '6285220450801') }}?text={{ urlencode('Halo Admin, saya ingin konfirmasi pembayaran:' . chr(10) . chr(10) . 'Order: ' . ($booking->order_id ?? '-') . chr(10) . 'Nama: ' . $booking->customer_name . chr(10) . 'Tanggal: ' . $booking->booking_date . chr(10) . 'Jam: ' . implode(', ', $booking->time_slots ?? []) . chr(10) . 'Bayar: Rp ' . number_format($amountToPay, 0, ',', '.') . chr(10) . chr(10) . 'Mohon dikonfirmasi. Terima kasih!') }}" 
                       target="_blank"
                       class="block w-full bg-[#25D366] hover:bg-[#1fba59] text-white font-bold py-4 rounded-2xl text-center transition-all shadow-lg shadow-green-500/20 active:scale-[0.98]">
                        <i class="fa-brands fa-whatsapp text-xl mr-2"></i>
                        Konfirmasi Pembayaran via WhatsApp
                    </a>
                    <p class="text-center text-[10px] text-gray-400 mt-3">
                        Setelah transfer, klik tombol di atas agar admin segera memverifikasi pesanan Anda.
                    </p>
                </div>

                {{-- Link ke Riwayat --}}
                <a href="{{ route('booking.history') }}" class="block w-full text-center text-xs font-semibold text-gray-500 hover:text-futsal-primary py-3 transition">
                    <i class="fa-solid fa-clock-rotate-left mr-1"></i> Lihat Riwayat Pesanan
                </a>
            </div>
        </div>
    </div>

    @else
    {{-- ===== ERROR STATE ===== --}}
    <div class="min-h-screen flex flex-col items-center justify-center p-6 text-center">
        <div class="w-20 h-20 bg-white rounded-2xl shadow-lg border border-gray-100 flex items-center justify-center mb-5">
            <i class="fa-solid fa-circle-exclamation text-3xl text-red-500"></i>
        </div>
        <h1 class="text-xl font-bold text-gray-800">Pesanan Tidak Ditemukan</h1>
        <p class="text-gray-500 text-sm mt-2 max-w-xs">Data pembayaran tidak tersedia. Silakan ulangi proses booking.</p>
        <a href="{{ url('/venues') }}" class="mt-6 bg-futsal-primary hover:bg-futsal-dark text-white font-bold px-8 py-3 rounded-full transition shadow-md">
            Kembali
        </a>
    </div>
    @endif

    <script>
        function copyToClipboard(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const orig = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Tersalin';
                btn.classList.add('bg-futsal-primary', 'text-white', 'border-futsal-primary');
                setTimeout(() => {
                    btn.innerHTML = orig;
                    btn.classList.remove('bg-futsal-primary', 'text-white', 'border-futsal-primary');
                }, 1500);
            });
        }

        // Auto redirect when paid
        @if(isset($booking))
        const bookingId = {{ $booking->id }};
        const checkStatus = setInterval(() => {
            fetch(`/api/booking/${bookingId}/status`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'paid' || data.status === 'confirmed') {
                        clearInterval(checkStatus);
                        // Redirect to success/ticket page
                        window.location.href = `/booking/${bookingId}/ticket`;
                    }
                })
                .catch(err => console.error('Error checking status:', err));
        }, 3000); // Check every 3 seconds
        @endif
    </script>

    {{-- MOBILE BOTTOM NAV --}}
    <div class="md:hidden fixed bottom-0 left-0 w-full bg-white shadow-[0_-4px_20px_rgba(0,0,0,0.1)] z-[100] border-t border-gray-100 flex justify-around items-center py-3 px-2">
        <a href="{{ url('/') }}" class="flex flex-col items-center gap-1 text-gray-500 hover:text-futsal-primary">
            <i class="fa-solid fa-house text-lg"></i>
            <span class="text-[10px] font-semibold">Beranda</span>
        </a>
        <a href="{{ url('/venues') }}" class="flex flex-col items-center gap-1 text-gray-500 hover:text-futsal-primary">
            <i class="fa-solid fa-map-location-dot text-lg"></i>
            <span class="text-[10px] font-semibold">Lapangan</span>
        </a>
        <a href="{{ url('/history') }}" class="flex flex-col items-center gap-1 text-gray-500 hover:text-futsal-primary">
            <i class="fa-solid fa-clock-rotate-left text-lg"></i>
            <span class="text-[10px] font-semibold">Riwayat</span>
        </a>
        @auth
        <a href="{{ url('/profile') }}" class="flex flex-col items-center gap-1 text-gray-500 hover:text-futsal-primary">
            <i class="fa-solid fa-user text-lg"></i>
            <span class="text-[10px] font-semibold">Profil</span>
        </a>
        @endauth
    </div>

</body>
</html>