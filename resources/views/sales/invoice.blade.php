<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $company['name'] ?? 'LK TECH' }}</title>
    <style>
        @page {
            margin: 25mm 20mm;
            size: A4;
        }
        
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #111827; /* Tailwind gray-900 */
        }

        .container {
            width: 100%;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header-logo {
            width: 50%;
            vertical-align: top;
        }

        .header-logo img {
            max-height: 50px;
            float: left;
            margin-right: 15px;
        }

        .company-name {
            font-size: 13pt;
            font-weight: 800;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }

        .company-details {
            font-size: 9pt;
            color: #4b5563; /* Tailwind gray-600 */
            line-height: 1.3;
        }

        .company-details a {
            color: #2563eb;
            text-decoration: none;
        }

        .header-title {
            width: 50%;
            text-align: right;
            vertical-align: top;
        }

        .invoice-title {
            font-size: 24pt;
            font-weight: 800;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 5px;
        }

        /* 2-Column Details */
        .details-table {
            width: 100%;
            margin-bottom: 25px;
            border-spacing: 15px 0;
            margin-left: -15px;
            margin-right: -15px;
        }

        .details-box {
            width: 50%;
            background-color: #f8fafc; /* Tailwind slate-50 */
            border: 1px solid #e2e8f0; /* Tailwind slate-200 */
            border-radius: 4px;
            padding: 12px;
            vertical-align: top;
        }

        .box-title {
            font-size: 8pt;
            font-weight: 700;
            color: #1e293b; /* Tailwind slate-800 */
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 8px;
        }

        .box-content {
            font-size: 10pt;
            color: #334155; /* Tailwind slate-700 */
        }
        
        .box-content strong {
            color: #0f172a; /* Tailwind slate-900 */
        }

        .meta-row {
            width: 100%;
            border-bottom: 1px solid #f1f5f9;
            padding: 4px 0;
        }
        
        .meta-label {
            display: inline-block;
            width: 45%;
            font-weight: 500;
        }

        .meta-value {
            display: inline-block;
            width: 54%;
            text-align: right;
            font-weight: 700;
            color: #0f172a;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: 700;
        }
        .status-lunas {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .status-pending {
            background-color: #fef9c3;
            color: #854d0e;
            border: 1px solid #fef08a;
        }

        /* Products Table */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .products-table th {
            background-color: #f9fafb;
            padding: 8px 10px;
            text-align: left;
            font-size: 9pt;
            font-weight: 700;
            color: #374151;
            border: 1px solid #e5e7eb;
            border-bottom: 2px solid #d1d5db;
        }

        .products-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
            font-size: 10pt;
        }

        .product-name {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .product-category {
            font-size: 8pt;
            color: #6b7280;
        }

        .product-specs {
            font-size: 8pt;
            color: #4b5563;
            background-color: #f9fafb;
            padding: 3px 5px;
            border-radius: 3px;
            margin-top: 5px;
            display: inline-block;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7pt;
            font-weight: 700;
            margin-left: 5px;
        }
        .badge-ready { background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-po { background-color: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }

        .total-row td {
            background-color: #f3f4f6;
            padding: 10px;
            font-weight: 800;
            font-size: 11pt;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Footer */
        .footer-table {
            width: 100%;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
        
        .footer-terms {
            width: 60%;
            vertical-align: bottom;
        }

        .footer-greeting {
            width: 40%;
            text-align: right;
            vertical-align: bottom;
            font-size: 9pt;
            font-style: italic;
            color: #4b5563;
            font-weight: 500;
            white-space: nowrap;
        }

        .terms-title {
            font-size: 9pt;
            font-weight: 700;
            color: #111827;
            margin-bottom: 3px;
        }

        .terms-content {
            font-size: 8pt;
            color: #4b5563;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    <!-- DOMPDF absolute paths for images -->
                    <img src="{{ public_path('images/LKtech.png') }}" alt="LK Tech Logo" onerror="this.style.display='none'">
                    <div>
                        <div class="company-name">LK Tech TN SEREAL</div>
                        <div class="company-details">
                            Villa Mutiara 1 Sektor 2 BLOK i-18 No.03<br>
                            Mekarwangi, Tanah Sereal, Bogor 16168<br>
                            Telp: 0856-7354-046<br>
                            Website: <a href="https://lktech.online/">https://lktech.online/</a>
                        </div>
                    </div>
                </td>
                <td class="header-title">
                    <div class="invoice-title">INVOICE</div>
                </td>
            </tr>
        </table>

        <!-- 2-Column Details -->
        <table class="details-table">
            <tr>
                <!-- Bill To -->
                <td class="details-box" style="margin-right: 7.5px;">
                    <div class="box-title">Ditagihkan Kepada</div>
                    <div class="box-content">
                        <div style="font-size: 11pt; font-weight: 700; color: #0f172a; margin-bottom: 5px;">
                            {{ $sale->customer->name ?? $sale->customer_name ?? 'Pelanggan Umum' }}
                        </div>
                        
                        @if(($sale->customer && $sale->customer->phone) || !empty($sale->phone))
                        <div style="margin-bottom: 2px;"><strong>Telp:</strong> {{ $sale->customer->phone ?? $sale->phone }}</div>
                        @endif
                        
                        @if(($sale->customer && $sale->customer->email) || !empty($sale->email))
                        <div style="margin-bottom: 2px;"><strong>Email:</strong> {{ $sale->customer->email ?? $sale->email }}</div>
                        @endif
                        
                        @if(($sale->customer && $sale->customer->address) || !empty($sale->address))
                        <div style="margin-top: 5px;">
                            <strong>Alamat:</strong><br>
                            {{ $sale->customer->address ?? $sale->address }}
                        </div>
                        @endif
                    </div>
                </td>
                
                <td style="width: 15px;"></td> <!-- Spacer -->

                <!-- Invoice Meta -->
                <td class="details-box" style="margin-left: 7.5px;">
                    <div class="box-title">Detail Faktur</div>
                    <div class="box-content">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 45%; padding: 4px 0; border-bottom: 1px solid #f1f5f9; font-weight: 500; vertical-align: top;">No. Faktur:</td>
                                <td style="width: 55%; padding: 4px 0; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: 700; color: #0f172a; vertical-align: top;">
                                    {{ $sale->invoice_no ?? str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 45%; padding: 4px 0; border-bottom: 1px solid #f1f5f9; font-weight: 500; vertical-align: top;">Tanggal:</td>
                                <td style="width: 55%; padding: 4px 0; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: 700; color: #0f172a; vertical-align: top;">
                                    {{ $sale->transaction_date ? $sale->transaction_date->format('d M Y, H:i') : date('d M Y, H:i') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 45%; padding: 4px 0; border-bottom: 1px solid #f1f5f9; font-weight: 500; vertical-align: top;">Sales:</td>
                                <td style="width: 55%; padding: 4px 0; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: 700; color: #0f172a; vertical-align: top;">
                                    {{ $sale->user->name ?? 'Admin User' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 45%; padding: 4px 0; font-weight: 500; vertical-align: middle;">Status:</td>
                                <td style="width: 55%; padding: 4px 0; text-align: right; font-weight: 700; color: #0f172a; vertical-align: middle;">
                                    @if($sale->isPaid())
                                        <span class="status-badge status-lunas">LUNAS</span>
                                    @else
                                        <span class="status-badge status-pending">PENDING</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Products Table -->
        <table class="products-table">
            <thead>
                <tr>
                    <th style="width: 50%;">PRODUK</th>
                    <th style="width: 25%;">NOMOR SERI</th>
                    <th style="width: 25%; text-align: right;">HARGA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->saleDetails as $detail)
                <tr>
                    <td>
                        <div class="product-name">
                            {{ $detail->product->brand ?? '' }} {{ $detail->product->model_series ?? '' }}
                            @if(($detail->product->tipe_stok ?? 'ready_stock') === 'open_order')
                                <span class="badge badge-po">Pre-Order</span>
                            @else
                                <span class="badge badge-ready">Ready</span>
                            @endif
                        </div>
                        <div class="product-category">{{ $detail->product->category->name ?? 'Umum' }}</div>
                        
                        @if((!empty($detail->product->processor) && $detail->product->processor != '-') || 
                            (!empty($detail->product->ram) && $detail->product->ram != '-') || 
                            (!empty($detail->product->storage) && $detail->product->storage != '-'))
                            <div class="product-specs">
                                @if(!empty($detail->product->processor) && $detail->product->processor != '-') Proc: {{ $detail->product->processor }} @endif
                                @if(!empty($detail->product->ram) && $detail->product->ram != '-') | RAM: {{ $detail->product->ram }} @endif
                                @if(!empty($detail->product->storage) && $detail->product->storage != '-') | Storage: {{ $detail->product->storage }} @endif
                            </div>
                        @endif
                    </td>
                    <td>
                        <div>{{ $detail->serial_number ?? $detail->product->serial_number ?? '-' }}</div>
                        @if($detail->manual_sn)
                        <div style="font-size: 8pt; color: #4b5563; margin-top: 4px;">SN/Key: {{ $detail->manual_sn }}</div>
                        @endif
                    </td>
                    <td style="text-align: right; font-weight: 700;">
                        Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
                
                <!-- Total Row -->
                <tr class="total-row">
                    <td colspan="2" style="text-align: right; border-left: 1px solid #e5e7eb;">TOTAL BAYAR</td>
                    <td style="text-align: right; border-right: 1px solid #e5e7eb;">
                        Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <table class="footer-table">
            <tr>
                <td class="footer-terms">
                    <div class="terms-title">Ketentuan Garansi</div>
                    <div class="terms-content">
                        <div>1. Garansi 2 mgg hardware. Segel utuh wajib.</div>
                        <div>2. Retur 7 hari jika produk masih baik. Batal jika jatuh/air.</div>
                        <div>3. Preorder estimasi pengirman 1-2 Minggu</div>
                    </div>
                </td>
                <td class="footer-greeting">
                    Terima kasih telah berbelanja di LKTech!
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
