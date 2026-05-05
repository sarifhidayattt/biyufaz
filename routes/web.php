<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Models\Venue;
use App\Http\Controllers\Admin\PaymentMethodController; 


// ==========================================
// 1. HALAMAN PUBLIK (Bisa diakses siapa saja)
// ==========================================

Route::get('/', function () {
    $venues = Venue::all();
    return view('welcome', compact('venues'));
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

// --- PERBAIKAN DI SINI ---
// 1. Menggunakan Controller untuk daftar lapangan
Route::get('/venues', [BookingController::class, 'index'])->name('venues.index');

// API untuk mengambil slot waktu
Route::get('/api/venues/{id}/availability', [BookingController::class, 'getAvailableSlots'])->name('api.venues.availability');
Route::get('/api/booking/{id}/status', [BookingController::class, 'checkStatus'])->name('api.booking.status');



// ==========================================
// 2. HALAMAN AUTH
// ==========================================

Route::get('/login', function () {
    return view('login');
})->name('login'); 

Route::get('/register', function () {
    return view('register'); 
})->name('register'); // Tambahkan name agar route('register') bekerja

Route::post('/register-process', [AuthController::class, 'registerProcess'])->name('register.process');
Route::post('/login-process', [AuthController::class, 'loginProcess'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('otp.verify');
Route::post('/verify-otp', [AuthController::class, 'verifyOtpProcess'])->name('otp.process');

// Password Reset Routes
use App\Http\Controllers\PasswordResetController;
Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetForm'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'updatePassword'])->middleware('guest')->name('password.update');


// ==========================================
// 3. AREA KHUSUS MEMBER
// ==========================================

// Route booking show dibuat publik agar user bisa lihat form sebelum login (opsional)
Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.show');

Route::middleware(['auth'])->group(function () {
    
    // Booking Flow (aksi yang membutuhkan autentikasi)
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    
    // Pembayaran & Sukses
    Route::get('/booking/payment/{id}', [BookingController::class, 'payment'])->name('booking.payment');
    Route::get('/booking/success/{id}', [BookingController::class, 'success'])->name('booking.success');
    Route::get('/booking/{id}/ticket', [BookingController::class, 'ticket'])->name('booking.ticket');

    // Riwayat & Pembatalan Booking
    Route::get('/history', [BookingController::class, 'history'])->name('booking.history');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

    // Profil User
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ==========================================
// 4. AREA ADMIN (Hanya Admin)
// ==========================================

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Update Status Booking
    Route::post('/booking/update/{id}', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
    
    // Fitur Kelola Lapangan (Semua Venue)
    Route::get('/venues', [AdminController::class, 'venuesIndex'])->name('admin.venues.index');
    
    // Fitur Tambah Lapangan (GOR)
    Route::get('/venue/create', [AdminController::class, 'createVenue'])->name('admin.venue.create');
    Route::post('/venue/store', [AdminController::class, 'storeVenue'])->name('admin.venue.store');
    Route::get('/venue/{id}/edit', [AdminController::class, 'editVenue'])->name('admin.venue.edit');
    Route::put('/venue/{id}/update', [AdminController::class, 'updateVenue'])->name('admin.venue.update');

    // Fitur Kelola Lapangan Spesifik
    Route::get('/venue/{id}/courts', [AdminController::class, 'manageCourts'])->name('admin.venue.courts');
    Route::post('/venue/{id}/courts', [AdminController::class, 'storeCourt'])->name('admin.venue.courts.store');
    Route::put('/courts/{id}/update', [AdminController::class, 'updateCourt'])->name('admin.courts.update');
    Route::delete('/courts/{id}', [AdminController::class, 'deleteCourt'])->name('admin.courts.delete');

    // Fitur Kelola Jam & Harga (Per Lapangan)
    Route::get('/courts/{id}/timeslots', [AdminController::class, 'manageTimeSlots'])->name('admin.courts.timeslots');
    Route::put('/courts/{id}/hours', [AdminController::class, 'updateCourtHours'])->name('admin.courts.hours.update');
    Route::put('/courts/{id}/bulk-price', [AdminController::class, 'bulkUpdatePrice'])->name('admin.courts.bulk-price');
    Route::post('/courts/{id}/timeslots', [AdminController::class, 'storeTimeSlot'])->name('admin.courts.timeslots.store');
    Route::put('/timeslots/{id}', [AdminController::class, 'updateTimeSlot'])->name('admin.timeslots.update');
    Route::delete('/timeslots/{id}', [AdminController::class, 'deleteTimeSlot'])->name('admin.timeslots.delete');

    // Metode Pembayaran
    Route::resource('payment-methods', PaymentMethodController::class)->names('admin.payment_methods')->except(['show']);

    // Laporan & Export
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/reports/export', [AdminController::class, 'exportReports'])->name('admin.reports.export');
});

