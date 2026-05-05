<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['email' => 'Silakan login sebagai admin.']);
        }

        // 2. Cek apakah role-nya 'admin'
        // (Asumsi kolom 'role' sudah ada di tabel users dari langkah sebelumnya)
        if (Auth::user()->role !== 'admin') {
            // Jika bukan admin, lempar ke halaman home atau error 403
            return redirect('/')->with('error', 'Anda tidak memiliki akses admin.');
        }

        // Jika lolos pengecekan, silakan masuk
        return $next($request);
    }
}