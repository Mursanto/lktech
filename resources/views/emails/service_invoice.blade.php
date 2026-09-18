<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Service Invoice - {{ $service->service_id }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; background-color: #f9fafb; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #f3f4f6; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { color: #2563eb; margin: 0; font-size: 24px; }
        .status { text-align: center; margin-bottom: 30px; }
        .badge { background-color: #10b981; color: #fff; padding: 6px 12px; border-radius: 20px; font-weight: bold; font-size: 14px; text-transform: uppercase; }
        .details { margin-bottom: 30px; }
        .details th { text-align: left; padding: 8px 0; color: #6b7280; width: 150px; font-weight: normal; }
        .details td { padding: 8px 0; font-weight: bold; }
        .footer { text-align: center; color: #6b7280; font-size: 14px; margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>LKTech Service Invoice</h1>
        </div>
        
        <div class="status">
            <span class="badge">{{ strtoupper($service->status) }}</span>
        </div>

        <p>Halo <strong>{{ $service->customer->name ?? 'Pelanggan' }}</strong>,</p>
        
        <p>Terima kasih telah mempercayakan service Anda di LKTech. Berikut adalah rincian service Anda:</p>

        <table class="details">
            <tr>
                <th>Service ID</th>
                <td>{{ $service->service_id }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ strtoupper($service->status) }}</td>
            </tr>
            <tr>
                <th>Total Biaya</th>
                <td>Rp {{ number_format($service->estimated_cost, 0, ',', '.') }}</td>
            </tr>
        </table>

        <p>Silakan temukan detail service lengkap pada lampiran PDF email ini.</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} LKTech. Semua hak dilindungi.</p>
            <p>Jika Anda memiliki pertanyaan, silakan hubungi kami via WhatsApp.</p>
        </div>
    </div>
</body>
</html>
