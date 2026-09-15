<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page { margin: 10mm; size: A4; }

        * { box-sizing: border-box; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #1f2937;
            margin: 0;
            padding: 0;
            background: white;
        }

        .invoice-wrap {
            max-width: 760px;
            margin: 0 auto;
            padding: 16px;
            background: white;
        }

        /* Header */
        .inv-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }
        .company-left { display: flex; align-items: flex-start; gap: 10px; }
        .company-left img { height: 40px; width: auto; }
        .company-name { font-size: 13px; font-weight: 900; text-transform: uppercase; letter-spacing: .08em; color: #111827; margin-bottom: 2px; }
        .company-detail { font-size: 10px; color: #4b5563; line-height: 1.4; }
        .company-detail a { color: #2563eb; text-decoration: none; }
        .inv-title { font-size: 22px; font-weight: 900; color: #111827; text-transform: uppercase; letter-spacing: .1em; }

        /* 2-col grid */
        .info-grid { display: flex; gap: 12px; margin-bottom: 12px; }
        .info-box { flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px; padding: 8px 10px; }
        .info-box-title { font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: .07em; color: #475569; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; margin-bottom: 6px; }
        .info-row { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 3px; margin-bottom: 3px; font-size: 10px; }
        .info-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .info-row .lbl { font-weight: 600; color: #374151; }
        .info-row .val { font-weight: 700; color: #111827; }
        .customer-name { font-size: 13px; font-weight: 800; color: #111827; margin-bottom: 4px; }
        .customer-detail { font-size: 10px; color: #374151; margin-bottom: 2px; }

        /* Badges */
        .badge { display: inline-block; padding: 1px 6px; border-radius: 3px; font-size: 9px; font-weight: 800; border: 1px solid; }
        .badge-success  { background: #dcfce7; color: #166534; border-color: #bbf7d0; }
        .badge-pending  { background: #fef9c3; color: #854d0e; border-color: #fde68a; }
        .badge-failed   { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }
        .badge-selesai  { background: #dcfce7; color: #166534; border-color: #bbf7d0; }
        .badge-diproses { background: #dbeafe; color: #1e40af; border-color: #bfdbfe; }
        .badge-batal    { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }
        .badge-menunggu { background: #ffedd5; color: #c2410c; border-color: #fed7aa; }

        /* Product table */
        .prod-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; table-layout: fixed; }
        .prod-table thead tr { background: #f9fafb; }
        .prod-table th { padding: 5px 8px; text-align: left; font-size: 8px; font-weight: 800; color: #374151; text-transform: uppercase; letter-spacing: .06em; border: 1px solid #e5e7eb; border-bottom: 2px solid #d1d5db; }
        .prod-table th.right { text-align: right; }
        .prod-table td { padding: 5px 8px; vertical-align: top; border-bottom: 1px solid #e5e7eb; font-size: 10px; }
        .prod-table td.right { text-align: right; font-weight: 700; }
        .prod-name { font-weight: 700; color: #111827; }
        .prod-cat  { font-size: 9px; color: #6b7280; }
        .prod-spec { font-size: 9px; color: #4b5563; background: #f9fafb; padding: 1px 4px; border-radius: 3px; display: inline-block; margin-top: 2px; line-height: 1.3; }
        .prod-sn   { font-size: 9px; font-family: monospace; color: #1e40af; margin-top: 2px; }
        .badge-preorder { display:inline-block; padding:1px 5px; border-radius:3px; font-size:7px; font-weight:700; background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; margin-left:4px; }
        .badge-ready    { display:inline-block; padding:1px 5px; border-radius:3px; font-size:7px; font-weight:700; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; margin-left:4px; }
        .total-tr td { padding: 6px 8px; font-weight: 800; font-size: 11px; color: #111827; background: #f3f4f6; border-bottom: 1px solid #e5e7eb; }

        /* Footer */
        .inv-footer { display: flex; justify-content: space-between; align-items: flex-end; border-top: 1px solid #e5e7eb; padding-top: 8px; margin-top: 8px; }
        .warranty-title { font-size: 10px; font-weight: 700; color: #111827; margin-bottom: 3px; }
        .warranty-item  { font-size: 9px; color: #4b5563; line-height: 1.5; }
        .thankyou { font-size: 9px; color: #374151; font-style: italic; text-align: right; }

        /* Signature */
        .sig-section { display: flex; justify-content: space-between; margin-top: 30px; }
        .sig-box { width: 200px; text-align: center; }
        .sig-line { border-bottom: 1px solid #374151; height: 40px; margin-bottom: 4px; }
        .sig-label { font-size: 10px; color: #4b5563; }

        /* Controls */
        .no-print { text-align: center; margin: 20px 0; }
        .no-print button { background: #1e3a8a; color: white; padding: 8px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 13px; margin: 0 4px; }
        .no-print button:hover { background: #2563eb; }

        @media print {
            .no-print { display: none !important; }
            body { margin: 0; padding: 0; }
            .invoice-wrap { padding: 0; }
        }
    </style>
</head>
<body>
<div class="invoice-wrap">

    {{-- HEADER --}}
    <div class="inv-header">
        <div class="company-left">
            <img src="{{ asset('images/LKtech.png') }}" alt="LK Tech Logo">
            <div>
                <div class="company-name">LK Tech TN SEREAL</div>
                <div class="company-detail">
                    Villa Mutiara 1 Sektor 2 BLOK i-18 No.03<br>
                    Mekarwangi, Tanah Sereal, Bogor 16168<br>
                    Telp: 0856-7354-046<br>
                    Website: <a href="https://lktech.online/">https://lktech.online/</a>
                </div>
            </div>
        </div>
        <div class="inv-title">Invoice</div>
    </div>

    {{-- 2-COLUMN INFO --}}
    <div class="info-grid">
        {{-- Ditagihkan Kepada --}}
        <div class="info-box">
            <div class="info-box-title">Ditagihkan Kepada</div>
            <div class="customer-name">{{ $sale->customer->name ?? 'Pelanggan Umum' }}</div>
            @if($sale->customer && $sale->customer->address)
            <div class="customer-detail" style="margin-top:4px;">
                <strong>Alamat:</strong><br>{{ $sale->customer->address }}
            </div>
            @endif
        </div>

        {{-- Detail Faktur --}}
        <div class="info-box">
            <div class="info-box-title">Detail Faktur</div>
            <table style="width:100%; border-collapse:collapse; font-size:9pt; line-height:1.4;">
                <tr>
                    <td style="width:110px; font-weight:600; padding:2px 0;">No. Faktur</td>
                    <td style="width:15px; text-align:center;">:</td>
                    <td style="text-align:right; font-weight:700;">{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td style="font-weight:600; padding:2px 0;">Tanggal</td>
                    <td style="text-align:center;">:</td>
                    <td style="text-align:right;">{{ \Carbon\Carbon::parse($sale->transaction_date)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td style="font-weight:600; padding:2px 0;">Metode Pembayaran</td>
                    <td style="text-align:center;">:</td>
                    <td style="text-align:right;">{{ $sale->payment_method === 'qris' ? 'QRIS' : ucfirst($sale->payment_method ?? 'Cash') }}</td>
                </tr>
                <tr>
                    <td style="font-weight:600; padding:2px 0;">Status Pembayaran</td>
                    <td style="text-align:center;">:</td>
                    <td style="text-align:right;">
                        @php $ps = $sale->payment_status; @endphp
                        <span class="badge {{ $ps==='success'?'badge-success':($ps==='failed'?'badge-failed':'badge-pending') }}">
                            {{ strtoupper($ps==='success'?'LUNAS':($ps==='failed'?'BATAL':'PENDING')) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- PRODUCT TABLE --}}
    <table class="prod-table">
        <thead>
            <tr>
                <th style="width:50%">Produk</th>
                <th style="width:25%">Nomor Seri</th>
                <th style="width:25%" class="right">Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleDetails as $detail)
            <tr style="background:#fff;">
                <td style="width:50%">
                    <div class="prod-name">
                        {{ $detail->product->brand }} {{ $detail->product->model_series ?? '' }}
                        @if(($detail->product->tipe_stok ?? 'ready_stock') === 'open_order')
                            <span class="badge-preorder">Pre-Order</span>
                        @else
                            <span class="badge-ready">Ready</span>
                        @endif
                    </div>
                    <div class="prod-cat">{{ $detail->product->category->name ?? 'Umum' }}</div>
                    @if((!empty($detail->product->processor) && $detail->product->processor != '-') ||
                        (!empty($detail->product->ram) && $detail->product->ram != '-') ||
                        (!empty($detail->product->storage) && $detail->product->storage != '-'))
                    <div class="prod-spec">
                        @if(!empty($detail->product->processor) && $detail->product->processor != '-')Proc: {{ $detail->product->processor }}@endif
                        @if(!empty($detail->product->ram) && $detail->product->ram != '-') | RAM: {{ $detail->product->ram }}@endif
                        @if(!empty($detail->product->storage) && $detail->product->storage != '-') | Storage: {{ $detail->product->storage }}@endif
                    </div>
                    @endif
                </td>
                <td style="width:25%">
                    <div>{{ $detail->serial_number ?? $detail->product->serial_number ?? '-' }}</div>
                    @if($detail->manual_sn)
                    <div class="prod-sn">SN/Key: {{ $detail->manual_sn }}</div>
                    @endif
                </td>
                <td style="width:25%" class="right">
                    Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
            <tr class="total-tr">
                <td colspan="2" style="text-align:right; border-bottom:1px solid #eee;">SUBTOTAL</td>
                <td style="text-align:right; border-bottom:1px solid #eee;">Rp {{ number_format($sale->subtotal > 0 ? $sale->subtotal : $sale->total_amount, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-tr">
                <td colspan="2" style="text-align:right; border-bottom:1px solid #eee; font-weight:normal; color:#4b5563;">Diskon / Potongan</td>
                <td style="text-align:right; border-bottom:1px solid #eee; font-weight:normal; color:#4b5563;">-Rp{{ number_format($sale->discount ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-tr">
                <td colspan="2" style="text-align:right;">TOTAL BAYAR</td>
                <td style="text-align:right;">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="inv-footer">
        <div style="width:66%">
            <div class="warranty-title">Ketentuan Garansi</div>
            <div class="warranty-item">1. Garansi 2 mgg hardware sejak pembelian. Segel utuh wajib.</div>
            <div class="warranty-item">2. Garansi Lifetime software (OS & MS Word) s.d tidak di-uninstall.</div>
            <div class="warranty-item">3. Batal jika cacat fisik (jatuh/kena air/modifikasi).</div>
        </div>
        <div class="thankyou" style="width:33%; display: flex; flex-direction: column; justify-content: flex-end; text-align: right;">
            <div style="font-style: italic; margin-bottom: 4px;">Terima kasih telah berbelanja di LKtech!</div>
            <div style="font-weight: bold; color: #1f2937; line-height: 1.2;">Struk ini berfungsi sebagai Bukti Pemesanan dan/atau Pembelian</div>
        </div>
    </div>


    {{-- PRINT CONTROLS --}}
    <div class="no-print">
        <button onclick="window.print()">🖨 Cetak</button>
        <button onclick="window.close()">✕ Tutup</button>
    </div>

</div>
<script>
    window.onload = function() {
        setTimeout(function() { window.print(); }, 400);
    };
    window.onafterprint = function() {
        setTimeout(function() { window.close(); }, 800);
    };
</script>
</body>
</html>
