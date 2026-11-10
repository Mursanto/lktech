<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $sale->payment_status === 'success' ? 'Invoice Lunas' : 'Proforma Invoice' }} - {{ $sale->payment_reference_id }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.5; background-color: #f9fafb; padding: 15px; margin: 0; }
        .container { max-width: 580px; margin: 0 auto; background: #fff; padding: 22px 24px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #f3f4f6; padding-bottom: 12px; margin-bottom: 14px; }
        .header h1 { color: #2563eb; margin: 0; font-size: 18px; font-weight: 800; letter-spacing: -0.2px; }
        .status { text-align: center; margin-bottom: 16px; }
        .badge { background-color: #10b981; color: #fff; padding: 3px 10px; border-radius: 12px; font-weight: bold; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; }
        .badge.pending { background-color: #f59e0b; }
        .greeting { font-size: 13px; margin: 0 0 10px 0; }
        .details { width: 100%; border-collapse: collapse; margin-bottom: 16px; font-size: 13px; }
        .details th { text-align: left; padding: 3px 0; color: #6b7280; width: 160px; font-weight: normal; vertical-align: top; }
        .details td { padding: 3px 0; font-weight: bold; color: #111827; vertical-align: top; }
        .items { width: 100%; border-collapse: collapse; margin-bottom: 18px; font-size: 12px; }
        .items th { background-color: #f3f4f6; padding: 7px 8px; text-align: left; border-bottom: 2px solid #e5e7eb; font-size: 11px; font-weight: 700; color: #374151; }
        .items td { padding: 7px 8px; border-bottom: 1px solid #e5e7eb; font-size: 12px; color: #1f2937; }
        .total-row td { font-weight: bold; font-size: 13px; border-top: 2px solid #e5e7eb; }
        .total-amount { color: #2563eb; text-align: right; white-space: nowrap; font-weight: bold; font-size: 14px; }
        .footer { text-align: center; color: #6b7280; font-size: 12px; margin-top: 20px; border-top: 1px solid #e5e7eb; padding-top: 15px; }
        .note { background-color: #fffbeb; border: 1px solid #fde68a; padding: 10px 12px; border-radius: 6px; margin-bottom: 16px; font-size: 12px; color: #92400e; line-height: 1.4; }
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

        <p class="greeting">Halo <strong>{{ $sale->customer->name ?? 'Pelanggan' }}</strong>,</p>
        
        @if($sale->payment_status === 'success')
            <p class="greeting">Terima kasih telah berbelanja di LKTech. Pembayaran Anda telah kami terima dengan detail sebagai berikut:</p>
        @else
            <p class="greeting">Terima kasih telah memesan di LKTech. Berikut adalah tagihan sementara (Proforma Invoice) Anda. Pesanan akan diproses setelah pembayaran lunas.</p>
        @endif

        <table class="details">
            <tr>
                <th>Order ID</th>
                <td>{{ $sale->payment_reference_id ?? 'SALE-' . $sale->id . '-' . ($sale->created_at ? $sale->created_at->timestamp : time()) }}</td>
            </tr>
            <tr>
                <th>Tanggal Pembayaran</th>
                <td>{{ $sale->transaction_date ? $sale->transaction_date->translatedFormat('d F Y, H:i') : now()->translatedFormat('d F Y, H:i') }}</td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>{{ $sale->payment_method === 'qris' ? 'QRIS' : ucfirst($sale->payment_method ?? 'Transfer') }}</td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th style="width: 42%;">Produk</th>
                    <th style="width: 10%; text-align: center;">Qty</th>
                    <th style="width: 24%; text-align: right;">Harga Satuan</th>
                    <th style="width: 24%; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subtotal = 0;
                @endphp
                @foreach($sale->saleDetails as $detail)
                @php
                    $qty = $detail->quantity ?? 1;
                    $unitPrice = $detail->price_at_transaction ?? 0;
                    $lineTotal = $unitPrice * $qty;
                    $subtotal += $lineTotal;
                @endphp
                <tr>
                    <td style="width: 42%;">{{ $detail->product->brand ?? 'Produk' }} {{ $detail->product->model_series ?? '' }}</td>
                    <td style="width: 10%; text-align: center;">{{ $qty }}</td>
                    <td style="width: 24%; text-align: right; white-space: nowrap;">Rp {{ number_format($unitPrice, 0, ',', '.') }}</td>
                    <td style="width: 24%; text-align: right; white-space: nowrap; font-weight: 600;">Rp {{ number_format($lineTotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach

                @php
                    $finalSubtotal = $sale->subtotal > 0 ? $sale->subtotal : ($subtotal > 0 ? $subtotal : ($sale->total_amount + ($sale->discount ?? 0)));
                @endphp

                <tr class="subtotal-row" style="font-weight: 600;">
                    <td colspan="3" style="text-align: right; border-top: 2px solid #e5e7eb; padding: 7px 8px; color: #4b5563; font-size: 12px;">Subtotal</td>
                    <td class="total-amount" style="border-top: 2px solid #e5e7eb; padding: 7px 8px; color: #374151; font-size: 12px;">Rp {{ number_format($finalSubtotal, 0, ',', '.') }}</td>
                </tr>
                @if($sale->discount > 0)
                <tr class="discount-row" style="font-weight: 600; color: #6b7280;">
                    <td colspan="3" style="text-align: right; padding: 5px 8px; font-size: 12px;">Diskon / Potongan</td>
                    <td class="total-amount" style="color: #ef4444; padding: 5px 8px; font-size: 12px;">-Rp {{ number_format($sale->discount, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td colspan="3" style="text-align: right; padding: 8px 8px; font-size: 13px; font-weight: bold; color: #111827;">Total Bayar</td>
                    <td class="total-amount" style="padding: 8px 8px; font-size: 14px; font-weight: bold; color: #2563eb;">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="note">
            <strong>Catatan Penting:</strong> Harga di atas belum termasuk ongkos kirim unit fisik. Silakan hubungi Admin kami via WhatsApp untuk konfirmasi pengiriman pesanan Anda.
        </div>

        <div class="footer">
            <p style="margin: 0 0 4px 0;">&copy; {{ date('Y') }} LKTech. Semua hak dilindungi.</p>
            <p style="margin: 0;">Jika Anda memiliki pertanyaan, silakan hubungi kami via WhatsApp.</p>
        </div>
    </div>
</body>
</html>
