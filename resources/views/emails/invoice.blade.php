<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $sale->payment_status === 'success' ? 'Invoice Lunas' : 'Proforma Invoice' }} - {{ $sale->payment_reference_id }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; background-color: #f9fafb; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #f3f4f6; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { color: #2563eb; margin: 0; font-size: 24px; }
        .status { text-align: center; margin-bottom: 30px; }
        .badge { background-color: #10b981; color: #fff; padding: 6px 12px; border-radius: 20px; font-weight: bold; font-size: 14px; text-transform: uppercase; }
        .badge.pending { background-color: #f59e0b; }
        .details { margin-bottom: 30px; }
        .details th { text-align: left; padding: 8px 0; color: #6b7280; width: 150px; font-weight: normal; }
        .details td { padding: 8px 0; font-weight: bold; }
        .items { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items th { background-color: #f3f4f6; padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb; }
        .items td { padding: 12px; border-bottom: 1px solid #e5e7eb; }
        .total-row td { font-weight: bold; font-size: 16px; border-top: 2px solid #e5e7eb; }
        .total-amount { color: #2563eb; text-align: right; }
        .footer { text-align: center; color: #6b7280; font-size: 14px; margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
        .note { background-color: #fffbeb; border: 1px solid #fde68a; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; color: #92400e; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>LKTech Invoice</h1>
        </div>
        
        <div class="status">
            @if($sale->payment_status === 'success')
                <span class="badge">Lunas / Terbayar</span>
            @else
                <span class="badge pending">Menunggu Pembayaran</span>
            @endif
        </div>

        <p>Halo <strong>{{ $sale->customer->name ?? 'Pelanggan' }}</strong>,</p>
        
        @if($sale->payment_status === 'success')
            <p>Terima kasih telah berbelanja di LKTech. Pembayaran Anda telah kami terima dengan detail sebagai berikut:</p>
        @else
            <p>Terima kasih telah memesan di LKTech. Berikut adalah tagihan sementara (Proforma Invoice) Anda. Pesanan akan diproses setelah pembayaran lunas.</p>
        @endif

        <table class="details">
            <tr>
                <th>Order ID</th>
                <td>{{ $sale->payment_reference_id ?? 'SALE-'.$sale->id }}</td>
            </tr>
            <tr>
                <th>Tanggal Pembayaran</th>
                <td>{{ now()->format('d F Y, H:i') }}</td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>{{ strtoupper($sale->payment_method ?? 'Transfer') }}</td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->saleDetails as $detail)
                <tr>
                    <td>{{ $detail->product->brand ?? 'Produk' }} {{ $detail->product->model_series ?? '' }}</td>
                    <td style="text-align: center;">{{ $detail->quantity }}</td>
                    <td style="text-align: right;">Rp {{ number_format($detail->price_at_transaction * $detail->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2" style="text-align: right;">Subtotal</td>
                    <td class="total-amount">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="note">
            <strong>Catatan Penting:</strong> Harga di atas belum termasuk ongkos kirim unit fisik. Silakan hubungi Admin kami via WhatsApp untuk konfirmasi pengiriman pesanan Anda.
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} LKTech. Semua hak dilindungi.</p>
            <p>Jika Anda memiliki pertanyaan, silakan hubungi kami via WhatsApp.</p>
        </div>
    </div>
</body>
</html>
