<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * 1. PROSES REGISTRASI
     */
    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6',
            'phone' => 'required|string|max:15',
            'otp_method' => 'required|in:whatsapp,email',
        ]);

        $otp = rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'member',
            'otp' => $otp,
        ]);

        session(['register_user_id' => $user->id]);
        session(['otp_method' => $request->otp_method]);

        // Kirim OTP via Email (Gmail SMTP)
        if ($request->otp_method === 'email') {
            try {
                Mail::to($user->email)->send(new OtpMail((string) $otp, $user->name));
                return redirect()->route('otp.verify')
                    ->with('success', 'Kode OTP telah dikirim ke email ' . $user->email . '. Silakan cek inbox atau folder spam.');
            } catch (\Exception $e) {
                Log::error('Gagal mengirim OTP email: ' . $e->getMessage());
                // Hapus user yang baru dibuat agar tidak ada akun tanpa verifikasi
                $user->delete();
                return redirect()->route('register')
                    ->with('error', 'Gagal mengirim email OTP. Pastikan konfigurasi SMTP sudah benar. Error: ' . $e->getMessage())
                    ->withInput();
            }
        }

        // Fallback: WhatsApp (belum diimplementasi, tampilkan kode sementara)
        return redirect()->route('otp.verify')
            ->with('info', 'Integrasi WhatsApp belum aktif. Gunakan kode ini untuk testing: ' . $otp);
    }

    /**
     * 2. PROSES LOGIN (TETAP SAMA)
     */
    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    /**
     * 3. VERIFIKASI OTP (DIUBAH: TIDAK LOGIN OTOMATIS)
     */
    public function verifyOtpProcess(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $userId = session('register_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('register')->with('error', 'Sesi kadaluarsa, silakan daftar ulang.');
        }

        if ($user->otp == $request->otp) {
            $user->otp = null;
            $user->save();
            
            // PERUBAHAN DI SINI:
            // Hapus Auth::login($user);
            session()->forget('register_user_id');

            // Arahkan ke halaman login dengan pesan sukses
            return redirect()->route('login')->with('success', 'Akun berhasil diaktifkan! Silakan masuk menggunakan email dan password Anda.');
        }

        return back()->with('error', 'Kode OTP salah, silakan coba lagi.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showOtpForm()
    {
        if (!session('register_user_id')) {
            return redirect()->route('register')->with('error', 'Silakan daftar terlebih dahulu.');
        }
        return view('verify-otp'); 
    }
}
