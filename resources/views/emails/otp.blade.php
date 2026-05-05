<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Anda</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f4f4; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #00382B 0%, #00684A 100%); padding: 40px 32px; text-align: center; }
        .header .logo-icon { width: 64px; height: 64px; background: rgba(255,255,255,0.15); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .header h1 { color: #ffffff; font-size: 26px; font-weight: 700; letter-spacing: -0.5px; }
        .header p { color: rgba(255,255,255,0.75); font-size: 14px; margin-top: 4px; }
        .body { padding: 40px 32px; }
        .greeting { font-size: 16px; color: #374151; margin-bottom: 16px; }
        .greeting strong { color: #00382B; }
        .description { font-size: 14px; color: #6B7280; line-height: 1.7; margin-bottom: 32px; }
        .otp-box { background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 2px dashed #00684A; border-radius: 12px; padding: 28px; text-align: center; margin-bottom: 32px; }
        .otp-box .label { font-size: 12px; color: #6B7280; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600; margin-bottom: 12px; }
        .otp-box .code { font-size: 48px; font-weight: 800; letter-spacing: 12px; color: #00382B; font-family: 'Courier New', monospace; }
        .otp-box .expiry { font-size: 12px; color: #9CA3AF; margin-top: 12px; }
        .warning { background: #FFF7ED; border-left: 4px solid #F97316; border-radius: 8px; padding: 16px; margin-bottom: 24px; }
        .warning p { font-size: 13px; color: #92400E; line-height: 1.6; }
        .warning strong { color: #C2410C; }
        .footer { background: #F9FAFB; border-top: 1px solid #E5E7EB; padding: 24px 32px; text-align: center; }
        .footer p { font-size: 12px; color: #9CA3AF; line-height: 1.8; }
        .footer a { color: #00684A; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header -->
        <div class="header">
            <div class="logo-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z" fill="white"/>
                </svg>
            </div>
            <h1>{{ config('app.name') }}</h1>
            <p>Verifikasi Akun Anda</p>
        </div>

        <!-- Body -->
        <div class="body">
            <p class="greeting">Halo, <strong>{{ $userName }}</strong>! 👋</p>
            <p class="description">
                Terima kasih telah mendaftar di <strong>{{ config('app.name') }}</strong>. 
                Gunakan kode OTP berikut untuk memverifikasi akun Anda dan mulai menikmati layanan kami.
            </p>

            <!-- OTP Code Box -->
            <div class="otp-box">
                <div class="label">Kode Verifikasi OTP</div>
                <div class="code">{{ $otpCode }}</div>
                <div class="expiry">⏱ Kode berlaku selama <strong>10 menit</strong></div>
            </div>

            <!-- Security Warning -->
            <div class="warning">
                <p>
                    <strong>⚠️ Peringatan Keamanan:</strong> Jangan bagikan kode OTP ini kepada siapapun, 
                    termasuk pihak yang mengaku sebagai tim {{ config('app.name') }}. 
                    Kami tidak pernah meminta kode OTP Anda.
                </p>
            </div>

            <p style="font-size: 14px; color: #6B7280; line-height: 1.7;">
                Jika Anda tidak merasa mendaftar di {{ config('app.name') }}, 
                abaikan email ini. Tidak ada tindakan lebih lanjut yang diperlukan.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                Email ini dikirim secara otomatis, mohon jangan membalas email ini.<br>
                &copy; {{ date('Y') }} <a href="#">{{ config('app.name') }}</a>. Semua hak dilindungi.
            </p>
        </div>
    </div>
</body>
</html>
