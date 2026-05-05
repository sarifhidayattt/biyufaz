<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetController extends Controller
{
    /**
     * Menampilkan form input email untuk lupa kata sandi.
     */
    public function requestForm()
    {
        return view('forgot-password');
    }

    /**
     * Mengirim link reset password ke email.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:pengguna,email',
        ]);

        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Link reset kata sandi telah dikirim ke email Anda.');
        }

        return back()->withInput($request->only('email'))
                     ->withErrors(['email' => 'Gagal mengirim link reset kata sandi.']);
    }

    /**
     * Menampilkan form reset kata sandi berdasarkan token.
     */
    public function resetForm(Request $request, $token = null)
    {
        return view('reset-password', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Memperbarui kata sandi di database.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:pengguna,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Kata sandi berhasil diatur ulang. Silakan masuk dengan kata sandi baru Anda.');
        }

        return back()->withInput($request->only('email'))
                     ->withErrors(['email' => trans($status)]);
    }
}
