<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking {{ $venue->name ?? 'Lapangan' }} - Biyufaz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        window.tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        futsal: {
                            dark: '#00382B',
                            primary: '#00684A',
                            accent: '#F9A825',
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .time-checkbox:checked + div {
            background-color: #1d4ed8;
            color: white;
            border-color: #1d4ed8;
            box-shadow: 0 4px 12px -2px rgba(29, 78, 216, 0.4);
            transform: scale(1.02);
        }
        .slot-booked {
            background-color: #fef2f2 !important;
            color: #dc2626 !important;
            border-color: #fecaca !important;
            cursor: not-allowed !important;
            opacity: 0.85;
        }
        .slot-booked .slot-time {
            text-decoration: line-through;
        }
        .slot-available {
            background-color: #f0fdf4;
            border-color: #bbf7d0;
        }
        .slot-available:hover {
            border-color: #00684A;
            box-shadow: 0 2px 8px rgba(0, 104, 74, 0.15);
        }
        /* Sembunyikan elemen penyimpanan data */
        #booking-data-bridge { display: none; }
        
        #submit-overlay {
            display: none;
            backdrop-filter: blur(4px);
            background-color: rgba(0, 56, 43, 0.7);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 pb-[100px] md:pb-10">

    <!-- Overlay Transisi saat Klik Pesan -->
    <div id="submit-overlay" class="fixed inset-0 z-[100] flex flex-col items-center justify-center text-white">
        <div class="w-12 h-12 border-4 border-white border-t-transparent rounded-full animate-spin mb-4"></div>
        <p class="font-bold tracking-widest text-sm uppercase">Menyiapkan Pesanan Anda...</p>
    </div>

    <!-- Data Bridge yang diperbaiki -->
    <div id="booking-data-bridge" 
         data-price="{{ $venue->price ?? 0 }}" 
         data-bookings='{!! json_encode($existingBookings ?? []) !!}'>
    </div>

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group" onclick="return safeNavigate(event, '{{ url('/') }}')">
                    <div class="w-9 h-9 bg-futsal-primary rounded-full flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                        <span class="font-bold text-xl text-white">F</span>
                    </div>
                    <span class="font-bold text-xl text-futsal-dark tracking-tight">Biyufaz</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="text-left">
                <a href="{{ url('/venues') }}" onclick="return safeNavigate(event, '{{ url('/venues') }}')" class="text-gray-500 hover:text-futsal-primary text-sm mb-2 inline-flex items-center gap-2 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Lapangan
                </a>
                <h1 class="text-3xl font-extrabold text-futsal-dark tracking-tight">Konfirmasi Booking</h1>
            </div>
            <div class="hidden sm:block">
                <span class="bg-futsal-light text-futsal-primary px-4 py-2 rounded-full text-xs font-bold border border-futsal-primary/20">
                    <i class="fa-solid fa-bolt mr-1"></i> Reservasi Otomatis
                </span>
            </div>
        </div>

        @if($errors->any() || session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm" role="alert">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <i class="fa-solid fa-triangle-exclamation"></i> Terdapat Kesalahan:
                </div>
                <ul class="list-disc list-inside text-sm">
                    @if(session('error'))
                        <li>{{ session('error') }}</li>
                    @endif
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="booking-form" action="{{ Route::has('booking.store') ? route('booking.store') : '#' }}" method="POST" onsubmit="return handleFormSubmit(event)">
            @csrf
            <input type="hidden" name="venue_id" value="{{ $venue->id ?? '' }}">
            <input type="hidden" name="total_price" id="input-total-price" value="0">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6 text-left">
                    <!-- Detail Lapangan -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col sm:flex-row gap-6 items-start">
                        <div class="w-full sm:w-32 h-48 sm:h-32 rounded-2xl overflow-hidden shadow-inner flex-shrink-0">
                            <img id="main_court_image" src="{{ asset('storage/' . ($venue->courts->first()->image ?? $venue->image)) }}?v={{ time() }}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/400x400?text=Lapangan'">
                        </div>
                        <div class="flex-1 w-full">
                            <h2 class="text-xl font-bold text-gray-900 leading-tight">{{ $venue->name ?? 'Nama Lapangan' }}</h2>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($venue->name . ' ' . $venue->address) }}" target="_blank" class="text-gray-400 text-sm mt-1 flex items-start gap-2 hover:text-futsal-primary transition-colors group/address">
                                <i class="fa-solid fa-map-pin text-futsal-primary mt-1 group-hover/address:scale-110 transition-transform"></i> <span class="underline-offset-4 group-hover/address:underline">{{ $venue->address ?? 'Alamat Lapangan' }}</span>
                            </a>
                            <div class="flex items-center mt-3 mb-4 text-futsal-primary font-black text-xl">
                                Rp {{ number_format($venue->price ?? 0, 0, ',', '.') }} <span class="text-gray-400 text-xs font-normal ml-1 tracking-widest">/ JAM</span>
                            </div>
                            
                            @if(isset($venue->latitude) && isset($venue->longitude))
                                <div id="bookingMap" class="w-full h-32 rounded-xl z-0 border border-gray-200 mt-2" style="z-index: 1;"></div>
                            @endif
                        </div>
                    </div>

                    <!-- Input Data Pemesan (Sembunyikan jika Admin) -->
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <div class="bg-green-50 p-8 rounded-3xl border border-green-200 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-xl">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-green-800 text-lg">Mode Pantau Admin</h3>
                                <p class="text-green-600 text-sm italic">Anda sedang memantau ketersediaan slot. Fitur booking dinonaktifkan untuk akun admin.</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 space-y-6">
                            <h3 class="font-bold text-gray-800 text-lg flex items-center gap-3 italic">
                                <span class="w-8 h-8 bg-slate-900 text-white rounded-lg flex items-center justify-center text-xs not-italic font-bold">1</span>
                                Data Pemesan
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap / Tim</label>
                                    <input type="text" name="customer_name" required value="{{ auth()->user()->name ?? '' }}" placeholder="Cth: Biyufaz FC" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-5 py-3 text-sm focus:bg-white focus:border-futsal-primary outline-none transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nomor WhatsApp</label>
                                    <input type="text" name="customer_phone" required value="{{ auth()->user()->phone ?? '' }}" placeholder="08xxxxxxxx" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-5 py-3 text-sm focus:bg-white focus:border-futsal-primary outline-none transition-all">
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Pilih Tanggal & Lapangan -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 text-lg flex items-center gap-3 mb-6 italic">
                            <span class="w-8 h-8 bg-slate-900 text-white rounded-lg flex items-center justify-center text-xs not-italic font-bold">2</span>
                            Tanggal Permainan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2 text-left">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Pilih Tanggal</label>
                                <input type="date" name="booking_date" id="booking_date" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" onchange="fetchAvailableSlots()"
                                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-5 py-3 text-sm focus:bg-white focus:border-futsal-primary outline-none cursor-pointer">
                            </div>
                            <div class="space-y-4 text-left md:col-span-2 mt-2">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Pilih Lapangan / Court</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="court_selection_cards">
                                    @foreach($venue->courts as $index => $court)
                                        <label class="cursor-pointer group relative block h-full">
                                            <input type="radio" name="court_id" id="court_type_{{ $court->id }}" value="{{ $court->id }}" class="peer hidden" {{ $index == 0 ? 'checked' : '' }} onchange="updateSelectedCourtUI(); fetchAvailableSlots();">
                                            <div class="border-2 border-gray-100 rounded-2xl overflow-hidden transition-all duration-300 peer-checked:border-futsal-primary peer-checked:ring-4 peer-checked:ring-futsal-primary/20 bg-white h-full shadow-sm hover:shadow-md">
                                                <div class="w-full relative overflow-hidden bg-gray-100 aspect-[4/3] sm:aspect-video lg:aspect-[16/10]">
                                                    <img src="{{ asset('storage/' . ($court->image ?? $venue->image)) }}?v={{ time() }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://placehold.co/400x200?text={{ urlencode($court->name) }}'">
                                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                                                    <div class="absolute bottom-3 left-4 right-4">
                                                        <h4 class="text-white font-bold text-sm tracking-wide truncate shadow-sm">{{ $court->name }}</h4>
                                                        <p class="text-white/90 text-[10px] font-medium tracking-wider flex items-center gap-1 mt-0.5">
                                                            <i class="fa-solid fa-layer-group text-[9px]"></i> {{ $court->type }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Checkmark Badge -->
                                            <div class="absolute -top-2 -right-2 bg-futsal-primary text-white w-7 h-7 rounded-full flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-all duration-300 transform scale-0 peer-checked:scale-100 shadow-lg border-2 border-white z-10">
                                                <i class="fa-solid fa-check text-xs"></i>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <!-- Hidden input to bridge the value to fetchAvailableSlots if it relies on getElementById('court_type') -->
                                <input type="hidden" id="court_type" value="{{ $venue->courts->first()->id ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Pilih Jam -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="font-bold text-gray-800 text-lg flex items-center gap-3 italic">
                                <span class="w-8 h-8 bg-slate-900 text-white rounded-lg flex items-center justify-center text-xs not-italic font-bold">3</span>
                                Pilih Slot Jam
                            </h3>
                            <div class="flex flex-wrap gap-3 text-[10px] font-bold uppercase">
                                <div class="flex items-center gap-1.5 text-green-700"><span class="w-3 h-3 rounded-sm bg-green-100 border border-green-300"></span> Kosong</div>
                                <div class="flex items-center gap-1.5 text-blue-700"><span class="w-3 h-3 rounded-sm bg-blue-600"></span> Dipilih</div>
                                <div class="flex items-center gap-1.5 text-red-500"><span class="w-3 h-3 rounded-sm bg-red-100 border border-red-300"></span> Terisi</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3" id="slots-container">
                            <!-- Slots akan di-render oleh JavaScript -->
                            <div class="col-span-full text-center text-gray-400 py-4">
                                <p>Pilih tanggal untuk melihat slot yang tersedia.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan: Checkout -->
                <div class="lg:col-span-1">
                    <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl sticky top-24 border border-white/5 text-left">
                        <h3 class="text-white font-black text-xl uppercase italic tracking-tighter mb-8 flex justify-between items-center">
                            Checkout
                            <i class="fa-solid fa-receipt text-futsal-secondary/40"></i>
                        </h3>
                        
                        <div class="space-y-4 mb-8 bg-white/5 p-6 rounded-3xl border border-white/10">
                            <div class="flex justify-between items-center text-white/50 text-[10px] font-bold uppercase tracking-widest">
                                <span>Durasi</span>
                                <span class="text-futsal-secondary font-black text-sm tracking-normal italic" id="summary-duration">0 Jam</span>
                            </div>
                            <div class="flex justify-between items-center text-white/50 text-[10px] font-bold uppercase tracking-widest">
                                <span>Total Sewa</span>
                                <span class="text-white font-black text-sm tracking-normal italic" id="display-total-price">Rp 0</span>
                            </div>
                        </div>

                        <div class="space-y-4 mb-8">
                            <label class="block text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-4">Opsi Pembayaran</label>
                            
                            <label class="flex items-center gap-4 p-4 bg-white/5 border border-white/10 rounded-2xl cursor-pointer hover:bg-white/10 transition-all has-[:checked]:border-futsal-primary group">
                                <input type="radio" name="payment_option" value="full" checked onchange="updateTotal()" class="w-4 h-4 text-futsal-primary focus:ring-0 bg-transparent border-white/30">
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-white uppercase tracking-tighter">Lunas (100%)</p>
                                    <p class="text-[9px] text-white/40 font-medium tracking-tight">Otomatis Terkonfirmasi</p>
                                </div>
                                <i class="fa-solid fa-bolt text-yellow-500 text-xs"></i>
                            </label>

                            <label class="flex items-center gap-4 p-4 bg-white/5 border border-white/10 rounded-2xl cursor-pointer hover:bg-white/10 transition-all has-[:checked]:border-futsal-primary group">
                                <input type="radio" name="payment_option" value="dp" onchange="updateTotal()" class="w-4 h-4 text-futsal-primary focus:ring-0 bg-transparent border-white/30">
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-white uppercase tracking-tighter">DP (50%)</p>
                                    <p class="text-[9px] text-white/40 font-medium tracking-tight">Sisa di tempat</p>
                                </div>
                                <i class="fa-solid fa-wallet text-futsal-primary text-xs"></i>
                            </label>
                        </div>

                        <div class="bg-futsal-primary p-6 rounded-3xl mb-8 shadow-lg shadow-futsal-primary/20 relative overflow-hidden">
                            <p class="text-[10px] text-white/70 uppercase font-black mb-1 tracking-widest relative z-10">Harus Bayar</p>
                            <h4 class="text-2xl font-black text-white tracking-tight relative z-10" id="display-to-pay">Rp 0</h4>
                            <div class="absolute -right-2 -bottom-2 text-white/10 text-4xl font-black italic select-none">QRIS</div>
                        </div>

                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <div class="mt-8 p-4 bg-white/5 border border-white/10 rounded-2xl text-center">
                                <p class="text-white/40 text-[10px] uppercase font-bold tracking-[0.2em] mb-2">Aksi Dibatasi</p>
                                <a href="{{ route('admin.dashboard') }}" class="block w-full bg-white/10 hover:bg-white/20 text-white py-3 rounded-xl text-xs font-bold transition">
                                    Kembali ke Dashboard
                                </a>
                            </div>
                        @else
                            <button type="submit" id="btn-checkout" disabled class="group w-full bg-white/10 text-white/20 font-black py-5 rounded-2xl shadow-lg transition-all transform cursor-not-allowed hover:scale-[1.01] active:scale-95 duration-300 uppercase tracking-widest text-xs flex items-center justify-center gap-3">
                                <span id="btn-text">Pilih Jam Dahulu</span>
                                <i class="fa-solid fa-chevron-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        @endif

                        <div class="mt-8 flex items-center gap-3 justify-center opacity-20">
                            <i class="fa-solid fa-shield-halved text-xs text-white"></i>
                            <span class="text-[9px] font-bold uppercase tracking-[0.3em] text-white">Sistem Keamanan Biyufaz</span>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script>
        // Logika Pengambilan Data Aman
        const dataBridge = document.getElementById('booking-data-bridge');
        
        const rawPrice = dataBridge.getAttribute('data-price');
        const defaultPricePerHour = (rawPrice && !rawPrice.includes('@{{')) ? parseInt(rawPrice) : 0;
        
        // Menyimpan harga per slot
        let slotPrices = {};

        function updateSelectedCourtUI() {
            const selectedRadio = document.querySelector('input[name="court_id"]:checked');
            if (selectedRadio) {
                document.getElementById('court_type').value = selectedRadio.value;
            }
        }

        // Fungsi Navigasi Aman untuk Mencegah Error Preview
        function safeNavigate(e, url) {
            if (url.includes('@{{') || url.includes('url(')) {
                e.preventDefault();
                alert("Navigasi ke '" + url + "' hanya berfungsi di server Laravel asli.");
                return false;
            }
            return true;
        }

        // Fungsi Submit Aman
        function handleFormSubmit(e) {
            const form = document.getElementById('booking-form');
            const action = form.getAttribute('action');
            const overlay = document.getElementById('submit-overlay');
            
            // Tampilkan transisi visual
            overlay.style.display = 'flex';
            
            // Cek jika rute belum dirender (Mode Preview)
            if (action === '#' || action.includes('@{{') || action.includes('route(')) {
                e.preventDefault();
                setTimeout(() => {
                    overlay.style.display = 'none';
                    alert("Simulasi Berhasil! Di server Laravel, Anda akan langsung diarahkan ke halaman QRIS otomatis.");
                }, 1500);
                return false;
            }
            
            return true;
        }

        async function fetchAvailableSlots() {
            const selectedDate = document.getElementById('booking_date').value;
            const venueId = document.querySelector('input[name="venue_id"]').value;
            const courtId = document.getElementById('court_type').value;
            const slotsContainer = document.getElementById('slots-container');

            if (!selectedDate || !venueId) return;

            // Tampilkan loading
            slotsContainer.innerHTML = '<div class="col-span-full text-center text-gray-400 py-4"><div class="w-6 h-6 border-2 border-futsal-primary border-t-transparent rounded-full animate-spin mx-auto"></div><p>Mencari slot...</p></div>';

            try {
                const response = await fetch(`/api/venues/${venueId}/availability?date=${selectedDate}&court_id=${courtId}`, {
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) {
                    throw new Error(`Server returned status ${response.status}`);
                }

                const data = await response.json();
                
                // Update basic price & image dynamically based on court if needed
                if(data.courts && data.selected_court) {
                    const currentCourt = data.courts.find(c => c.id == data.selected_court);
                    if(currentCourt) {
                        dataBridge.setAttribute('data-price', currentCourt.price);
                        
                        // Update UI Court Image
                        const courtImageEl = document.getElementById('main_court_image');
                        if (courtImageEl) {
                            const defaultVenueImg = '{{ asset("storage/" . $venue->image) }}?v=' + new Date().getTime();
                            courtImageEl.src = currentCourt.image ? ('/storage/' + currentCourt.image + '?v=' + new Date().getTime()) : defaultVenueImg;
                        }
                    }
                }
                
                renderSlots(data.available_slots);

            } catch (error) {
                console.error('Error fetching slots:', error);
                slotsContainer.innerHTML = '<div class="col-span-full text-center text-red-500 py-4"><p>Gagal memuat slot. Coba lagi nanti.</p></div>';
            }
        }

        function renderSlots(slots) {
            const slotsContainer = document.getElementById('slots-container');
            slotsContainer.innerHTML = '';
            slotPrices = {};

            const rawPrice = dataBridge.getAttribute('data-price');
            const defaultPricePerHour = (rawPrice && !rawPrice.includes('@{{')) ? parseInt(rawPrice) : 0;

            if (!slots || slots.length === 0) {
                slotsContainer.innerHTML = '<div class="col-span-full text-center text-gray-400 py-4"><p>Tidak ada slot yang tersedia pada tanggal ini.</p></div>';
                return;
            }

            let availableCount = 0;
            let bookedCount = 0;

            slots.forEach(slotData => {
                const time = typeof slotData === 'string' ? slotData : slotData.time;
                const price = typeof slotData === 'string' ? defaultPricePerHour : slotData.price;
                const status = slotData.status || 'available';
                const isBooked = status === 'booked';
                
                if (isBooked) bookedCount++;
                else availableCount++;

                slotPrices[time] = price;

                const label = document.createElement('label');
                label.className = isBooked ? 'select-none cursor-not-allowed' : 'cursor-pointer group select-none';
                
                const input = document.createElement('input');
                input.type = 'checkbox';
                input.name = 'time_slots[]';
                input.className = 'time-checkbox hidden';
                input.value = time;
                input.dataset.price = price;
                
                if (isBooked) {
                    input.disabled = true;
                } else {
                    input.onchange = updateTotal;
                }

                const div = document.createElement('div');
                if (isBooked) {
                    div.className = 'border-2 rounded-2xl py-3 text-center transition-all duration-300 shadow-sm slot-booked';
                    div.innerHTML = `
                        <span class="slot-time block text-xs font-black tracking-widest text-red-400">${time}</span>
                        <span class="block text-[9px] font-bold mt-1 text-red-400"><i class="fa-solid fa-lock text-[8px] mr-0.5"></i> Terisi</span>
                    `;
                } else {
                    div.className = 'border-2 rounded-2xl py-3 text-center transition-all duration-300 shadow-sm slot-available group-hover:shadow-md';
                    div.innerHTML = `
                        <span class="slot-time block text-xs font-black tracking-widest text-green-800">${time}</span>
                        <span class="block text-[10px] text-green-600 font-bold mt-1">Rp ${parseInt(price).toLocaleString('id-ID')}</span>
                    `;
                }

                label.appendChild(input);
                label.appendChild(div);
                slotsContainer.appendChild(label);
            });

            // Tambah info ringkasan ketersediaan
            const summaryDiv = document.createElement('div');
            summaryDiv.className = 'col-span-full mt-2 flex items-center justify-center gap-4 text-[10px] font-bold text-gray-500';
            summaryDiv.innerHTML = `
                <span class="text-green-600"><i class="fa-solid fa-circle-check mr-1"></i>${availableCount} Tersedia</span>
                <span class="text-red-400"><i class="fa-solid fa-circle-xmark mr-1"></i>${bookedCount} Terisi</span>
            `;
            slotsContainer.appendChild(summaryDiv);

            updateTotal();
        }

        function updateTotal() {
            const checkedCheckboxes = document.querySelectorAll('.time-checkbox:checked');
            const checkedCount = checkedCheckboxes.length;
            const paymentOptionEl = document.querySelector('input[name="payment_option"]:checked');
            const paymentOption = paymentOptionEl ? paymentOptionEl.value : 'full';
            
            // Hitung total dari harga masing-masing slot
            let total = 0;
            checkedCheckboxes.forEach(cb => {
                total += parseInt(cb.dataset.price) || 0;
            });

            const toPay = paymentOption === 'dp' ? (total * 0.5) : total;

            document.getElementById('summary-duration').innerText = checkedCount + ' Jam';
            document.getElementById('display-total-price').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('display-to-pay').innerText = 'Rp ' + toPay.toLocaleString('id-ID');
            document.getElementById('input-total-price').value = total;

            const btnCheckout = document.getElementById('btn-checkout');
            const btnText = document.getElementById('btn-text');
            
            if (checkedCount > 0) {
                btnCheckout.disabled = false;
                btnCheckout.classList.remove('bg-white/10', 'text-white/20', 'cursor-not-allowed');
                btnCheckout.classList.add('bg-futsal-primary', 'text-white', 'shadow-futsal-primary/30');
                btnText.innerText = 'PROSES PEMBAYARAN';
            } else {
                btnCheckout.disabled = true;
                btnCheckout.classList.add('bg-white/10', 'text-white/20', 'cursor-not-allowed');
                btnCheckout.classList.remove('bg-futsal-primary', 'text-white', 'shadow-futsal-primary/30');
                btnText.innerText = 'Pilih Jam Dahulu';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchAvailableSlots();
            
            // Initialize mini-map if venue has coordinates
            @if(isset($venue->latitude) && isset($venue->longitude))
                const lat = {{ $venue->latitude }};
                const lng = {{ $venue->longitude }};
                const map = L.map('bookingMap').setView([lat, lng], 15);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);
                
                L.marker([lat, lng]).addTo(map)
                    .bindPopup('<b>{{ $venue->name }}</b>')
                    .openPopup();
            @endif
        });
    </script>

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