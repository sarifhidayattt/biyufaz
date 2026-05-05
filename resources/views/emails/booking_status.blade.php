<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background-color: #00684A; color: white; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 12px; color: #888; margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px; }
        .details-table { w-full; border-collapse: collapse; margin-top: 15px; }
        .details-table th, .details-table td { padding: 8px; border-bottom: 1px solid #eee; text-align: left; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Biyufaz Futsal</h2>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $booking->customer_name }}</strong>,</p>
            <p>{{ $statusMessage }}</p>
            
            <h3>Detail Pesanan (#{{ $booking->id }})</h3>
            <table class="details-table" style="width: 100%;">
                <tr>
                    <th>Lapangan</th>
                    <td>{{ $booking->venue->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Main</th>
                    <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Jam</th>
                    <td>{{ is_array($booking->time_slots) ? implode(', ', $booking->time_slots) : $booking->time_slots }}</td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Status Saat Ini</th>
                    <td><strong>{{ strtoupper($booking->status) }}</strong></td>
                </tr>
            </table>

            <p style="margin-top: 20px;">
                Jika Anda memiliki pertanyaan, silakan hubungi admin kami. Terima kasih telah menggunakan Biyufaz!
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Biyufaz Arena Management.
        </div>
    </div>
</body>
</html>
