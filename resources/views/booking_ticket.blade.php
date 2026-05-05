<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket - {{ $booking->order_id }} | Biyufaz</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }

        /* Ticket perforation effect */
        .ticket-cut {
            position: relative;
        }
        .ticket-cut::before,
        .ticket-cut::after {
            content: '';
            position: absolute;
            width: 28px;
            height: 28px;
            background: #F1F5F9;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            z: 10;
        }
        .ticket-cut::before { left: -14px; }
        .ticket-cut::after { right: -14px; }

        .ticket-cut-line {
            border-left: 3px dashed #e2e8f0;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
        }

        /* Holographic effect */
        .holographic {
            background: linear-gradient(135deg, 
                rgba(0,168,107,0.08) 0%, 
                rgba(0,104,74,0.05) 25%, 
                rgba(0,168,107,0.1) 50%, 
                rgba(0,56,43,0.05) 75%, 
                rgba(0,168,107,0.08) 100%);
            background-size: 200% 200%;
            animation: shimmer 4s ease infinite;
        }

        @keyframes shimmer {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .fade-up { animation: fadeUp 0.6s ease forwards; }
        .scale-in { animation: scaleIn 0.5s ease forwards; animation-delay: 0.2s; opacity: 0; }

        /* Confetti animation for success */
        @keyframes confetti-fall {
            0% { transform: translateY(-100px) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
        }
        .confetti {
            position: fixed;
            top: -10px;
            animation: confetti-fall 3s ease-in-out forwards;
            z-index: 100;
            pointer-events: none;
        }

        /* Print styles */
        @media print {
            body { background: white !important; }
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            .ticket-container { 
                box-shadow: none !important; 
                border: 2px solid #e2e8f0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
            .ticket-cut::before,
            .ticket-cut::after {
                background: white;
                border: 1px solid #e2e8f0;
            }
        }
    </style>
</head>
<body class="bg-slate-100 text-gray-800 pb-[80px] md:pb-0 min-h-screen">

    {{-- Confetti Effect --}}
    <div id="confetti-container" class="no-print"></div>

    {{-- ===== NAVBAR ===== --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50 no-print">
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
                        <span class="font-bold text-gray-800">E-Tiket</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="window.print()" class="text-[10px] font-bold text-futsal-primary bg-futsal-light px-4 py-2 rounded-full border border-futsal-primary/20 hover:bg-futsal-primary hover:text-white transition-all">
                        <i class="fa-solid fa-print mr-1"></i> Cetak
                    </button>
                    <button onclick="shareTicket()" class="text-[10px] font-bold text-slate-500 bg-slate-100 px-4 py-2 rounded-full border border-slate-200 hover:bg-slate-200 transition-all">
                        <i class="fa-solid fa-share-nodes mr-1"></i> Bagikan
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- ===== KONTEN UTAMA ===== --}}
    <div class="max-w-lg mx-auto px-4 sm:px-6 py-8">

        {{-- Status Confirmed Banner --}}
        <div class="bg-green-50 border border-green-200 rounded-2xl p-4 mb-6 flex items-center gap-3 fade-up no-print">
            <div class="w-10 h-10 bg-green-500 text-white rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-green-500/30">
                <i class="fa-solid fa-check text-lg"></i>
            </div>
            <div>
                <h3 class="font-bold text-green-800 text-sm">Pembayaran Dikonfirmasi!</h3>
                <p class="text-green-600 text-[11px] mt-0.5">Tunjukkan tiket ini saat datang ke lapangan.</p>
            </div>
        </div>

        {{-- ===== TICKET CARD ===== --}}
        <div class="ticket-container scale-in">
            
            {{-- TICKET TOP SECTION --}}
            <div class="bg-white rounded-t-3xl shadow-xl overflow-hidden border border-slate-200 border-b-0">
                
                {{-- Header with gradient --}}
                <div class="bg-gradient-to-br from-futsal-dark via-futsal-primary to-futsal-secondary p-6 text-white relative overflow-hidden">
                    {{-- Background pattern --}}
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/20 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                        <svg class="absolute right-4 bottom-4 w-16 h-16 text-white/5" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                    </div>

                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                    <span class="font-black text-sm">F</span>
                                </div>
                                <span class="font-black text-sm tracking-wider uppercase">Biyufaz</span>
                            </div>
                            <span class="text-[9px] font-black bg-white/20 px-3 py-1 rounded-full backdrop-blur-sm uppercase tracking-widest">
                                E-Tiket
                            </span>
                        </div>

                        <h2 class="text-2xl font-black tracking-tight leading-tight">{{ $booking->venue->name ?? 'Venue' }}</h2>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode(($booking->venue->name ?? 'Venue') . ' ' . ($booking->venue->address ?? '')) }}" target="_blank" class="text-white/70 text-xs mt-1 font-medium hover:text-white hover:underline underline-offset-4 transition-all block">
                            {{ $booking->venue->address ?? '' }}
                        </a>
                    </div>
                </div>

                {{-- Booking details --}}
                <div class="p-6 holographic">
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Main</p>
                            <p class="font-bold text-slate-800 text-sm">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l') }}</p>
                            <p class="font-black text-futsal-primary text-lg leading-tight">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Lapangan</p>
                            <p class="font-bold text-slate-800 text-sm">{{ $booking->court->name ?? $booking->court_type }}</p>
                            <p class="font-semibold text-futsal-secondary text-xs">{{ $booking->court->type ?? '' }}</p>
                        </div>
                    </div>

                    <div class="mb-5">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Jam Sewa</p>
                        <div class="flex flex-wrap gap-2">
                            @if(is_array($booking->time_slots))
                                @foreach($booking->time_slots as $slot)
                                    <span class="bg-futsal-dark text-white px-3 py-1.5 rounded-lg text-xs font-black shadow-sm">
                                        <i class="fa-regular fa-clock mr-1 text-futsal-secondary"></i>{{ $slot }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Pemesan</p>
                            <p class="font-bold text-slate-800 text-sm">{{ $booking->customer_name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">WhatsApp</p>
                            <p class="font-bold text-slate-800 text-sm">{{ $booking->customer_phone }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TICKET DIVIDER (Perforation effect) --}}
            <div class="ticket-cut relative bg-white border-l border-r border-slate-200">
                <div class="border-b-2 border-dashed border-slate-200 mx-5"></div>
            </div>

            {{-- TICKET BOTTOM SECTION (QR + Summary) --}}
            <div class="bg-white rounded-b-3xl shadow-xl overflow-hidden border border-slate-200 border-t-0">
                <div class="p-6">
                    <div class="flex items-start gap-5">
                        {{-- QR Code --}}
                        <div class="flex-shrink-0">
                            <div class="bg-white p-2 rounded-xl border-2 border-slate-100 shadow-sm">
                                <img 
                                    src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode(url('/booking/' . $booking->id . '/ticket')) }}" 
                                    alt="QR Code Tiket" 
                                    class="w-[100px] h-[100px]"
                                    id="qr-code"
                                >
                            </div>
                            <p class="text-[8px] text-slate-400 text-center mt-2 font-bold">SCAN UNTUK VERIFIKASI</p>
                        </div>

                        {{-- Summary --}}
                        <div class="flex-1 space-y-3">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Order ID</p>
                                <p class="font-black text-slate-800 text-xs font-mono">{{ $booking->order_id }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Total Bayar</p>
                                <p class="font-black text-futsal-primary text-xl tabular-nums">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-[10px] font-black px-3 py-1 rounded-full">
                                    <i class="fa-solid fa-circle-check"></i> LUNAS
                                </span>
                                <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-500 text-[10px] font-bold px-3 py-1 rounded-full uppercase">
                                    {{ $booking->payment_type === 'dp' ? 'DP 50%' : 'Full' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer badge --}}
                <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 flex items-center justify-between">
                    <p class="text-[9px] text-slate-400 font-bold">
                        <i class="fa-solid fa-shield-halved mr-1"></i>
                        Tiket ini berlaku untuk tanggal & jam yang tertera
                    </p>
                    <p class="text-[9px] text-slate-300 font-bold font-mono">
                        #{{ $booking->id }}
                    </p>
                </div>
            </div>
        </div>

        {{-- ===== ACTION BUTTONS ===== --}}
        <div class="mt-6 space-y-3 no-print">
            {{-- Download / Screenshot --}}
            <button onclick="window.print()" class="block w-full bg-futsal-primary hover:bg-futsal-dark text-white font-bold py-4 rounded-2xl text-center transition-all shadow-lg shadow-futsal-primary/20 active:scale-[0.98] text-sm">
                <i class="fa-solid fa-download mr-2"></i> Simpan / Cetak Tiket
            </button>

            {{-- Kembali ke riwayat --}}
            <a href="{{ route('booking.history') }}" class="block w-full text-center text-xs font-semibold text-gray-500 hover:text-futsal-primary py-3 transition">
                <i class="fa-solid fa-clock-rotate-left mr-1"></i> Kembali ke Riwayat Pesanan
            </a>
        </div>

        {{-- Important notes --}}
        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-2xl p-4 no-print">
            <h4 class="font-bold text-amber-800 text-xs flex items-center gap-2 mb-2">
                <i class="fa-solid fa-triangle-exclamation"></i> Penting
            </h4>
            <ul class="text-[11px] text-amber-700 space-y-1.5 leading-relaxed">
                <li class="flex items-start gap-2">
                    <i class="fa-solid fa-check text-amber-500 mt-0.5 text-[9px]"></i>
                    Tunjukkan e-tiket ini (atau screenshot) saat tiba di lokasi
                </li>
                <li class="flex items-start gap-2">
                    <i class="fa-solid fa-check text-amber-500 mt-0.5 text-[9px]"></i>
                    Datang minimal <strong>10 menit</strong> sebelum jadwal bermain
                </li>
                <li class="flex items-start gap-2">
                    <i class="fa-solid fa-check text-amber-500 mt-0.5 text-[9px]"></i>
                    Tiket hanya berlaku untuk tanggal dan jam yang tertera
                </li>
            </ul>
        </div>
    </div>

    {{-- MOBILE BOTTOM NAV --}}
    <div class="md:hidden fixed bottom-0 left-0 w-full bg-white shadow-[0_-4px_20px_rgba(0,0,0,0.1)] z-[100] border-t border-gray-100 flex justify-around items-center py-3 px-2 no-print">
        <a href="{{ url('/') }}" class="flex flex-col items-center gap-1 text-gray-500 hover:text-futsal-primary">
            <i class="fa-solid fa-house text-lg"></i>
            <span class="text-[10px] font-semibold">Beranda</span>
        </a>
        <a href="{{ url('/venues') }}" class="flex flex-col items-center gap-1 text-gray-500 hover:text-futsal-primary">
            <i class="fa-solid fa-map-location-dot text-lg"></i>
            <span class="text-[10px] font-semibold">Lapangan</span>
        </a>
        <a href="{{ url('/history') }}" class="flex flex-col items-center gap-1 text-futsal-primary">
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

    <script>
        // Confetti effect on page load
        document.addEventListener('DOMContentLoaded', function() {
            const colors = ['#00A86B', '#00684A', '#FFD700', '#FF6B6B', '#4ECDC4', '#45B7D1'];
            const container = document.getElementById('confetti-container');
            
            for (let i = 0; i < 30; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + 'vw';
                    confetti.style.width = Math.random() * 8 + 4 + 'px';
                    confetti.style.height = confetti.style.width;
                    confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
                    confetti.style.animationDuration = Math.random() * 2 + 2 + 's';
                    confetti.style.animationDelay = Math.random() * 0.5 + 's';
                    container.appendChild(confetti);

                    setTimeout(() => confetti.remove(), 4000);
                }, i * 50);
            }
        });

        // Share ticket function
        function shareTicket() {
            const ticketUrl = window.location.href;
            const text = `🎫 E-Tiket Biyufaz\n📍 {{ $booking->venue->name ?? 'Venue' }}\n📅 {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}\n⏰ {{ implode(', ', $booking->time_slots ?? []) }}\n\n🔗 ${ticketUrl}`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'E-Tiket Biyufaz',
                    text: text,
                    url: ticketUrl
                }).catch(err => {
                    // User cancelled sharing
                });
            } else {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Link tiket berhasil disalin!');
                });
            }
        }
    </script>

</body>
</html>
