<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $sale->invoice_number ?? 'INV-' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page {
            margin: 20mm;
            size: A4;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 5px;
        }
        
        .company-info {
            font-size: 11px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 20px 0 10px 0;
        }
        
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .info-section {
            width: 48%;
        }
        
        .info-label {
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 5px;
        }
        
        .info-value {
            margin-bottom: 10px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .items-table th {
            background-color: #1e3a8a;
            color: white;
            text-align: left;
            padding: 10px;
            font-weight: bold;
            border: 1px solid #1e3a8a;
        }
        
        .items-table td {
            padding: 8px 10px;
            border: 1px solid #ddd;
        }
        
        .items-table .text-right {
            text-align: right;
        }
        
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        
        .total-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 5px;
        }
        
        .total-label {
            width: 150px;
            text-align: right;
            padding-right: 20px;
            font-weight: bold;
        }
        
        .total-value {
            width: 120px;
            text-align: right;
            font-weight: bold;
        }
        
        .grand-total {
            border-top: 2px solid #1e3a8a;
            padding-top: 5px;
            font-size: 14px;
            color: #1e3a8a;
        }
        
        .footer {
            margin-top: 40px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
        
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            width: 200px;
            text-align: center;
        }
        
        .signature-line {
            border-bottom: 1px solid #333;
            margin-bottom: 5px;
            height: 40px;
        }
        
        .signature-title {
            font-size: 11px;
            color: #666;
        }
        
        .no-print {
            display: block;
            margin: 20px 0;
            text-align: center;
        }
        
        .print-button {
            background-color: #1e3a8a;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin: 0 5px;
        }
        
        .print-button:hover {
            background-color: #2563eb;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .no-print {
                display: none !important;
            }
            
            .invoice-container {
                margin: 0;
                padding: 0;
                max-width: 100%;
            }
            
            .header {
                margin-bottom: 20px;
            }
            
            .footer {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="flex items-start justify-between">
                <div class="text-left">
                    <div class="logo">LK Tech TN SEREAL</div>
                    <div class="company-info">
                        Alamat: Villa Mutiara 1 Sektor 2 BLOK i-18 No.03, RT.03/RW.12,<br>
                        Mekarwangi, Tanah Sereal, Kota Bogor, Jawa Barat 16168<br>
                        Telepon: 0856-7354-046<br>
                        Website: <a href="https://lktech.online/" style="color: #1e3a8a; text-decoration: none;">https://lktech.online/</a>
                    </div>
                </div>
                <div class="text-right">
                    <img src="{{ asset('images/lktech-logo.png') }}" alt="LK Tech Logo" class="h-16 w-auto">
                </div>
            </div>
        </div>

        <!-- Invoice Title -->
        <div class="invoice-title">FAKTUR PENJUALAN</div>

        <!-- Invoice Information -->
        <div class="invoice-info">
            <div class="info-section">
                <div class="info-label">Nomor Faktur</div>
                <div class="info-value">{{ $sale->invoice_number ?? 'FAK-' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</div>
                
                <div class="info-label">Tanggal Transaksi</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($sale->transaction_date)->format('d F Y') }}</div>
                
                <div class="info-label">Metode Pembayaran</div>
                <div class="info-value">{{ ucfirst($sale->payment_method ?? 'Tunai') }}</div>
            </div>
            
            <div class="info-section">
                <div class="info-label">Nama Pelanggan</div>
                <div class="info-value">{{ $sale->customer_name ?? 'Pelanggan Umum' }}</div>
                
                <div class="info-label">Telepon</div>
                <div class="info-value">{{ $sale->customer_phone ?? '-' }}</div>
                
                <div class="info-label">Email</div>
                <div class="info-value">{{ $sale->customer_email ?? '-' }}</div>
            </div>
        </div>

        <!-- Items Table (Merged Columns with Conditional Specs) -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%">Produk</th>
                    <th style="width: 25%">Nomor Seri</th>
                    <th style="width: 25%" class="text-right">Harga</th>
                </tr>
            </thead>
            <tbody>
                @if($sale->saleDetails && $sale->saleDetails->count() > 0)
                    @php $totalAmount = 0; @endphp
                    @foreach($sale->saleDetails as $index => $detail)
                        @php $totalAmount += $detail->price_at_transaction; @endphp
                        <tr>
                            <td style="width: 50%">
                                <div>
                                    <div style="font-weight: bold;">{{ $detail->product->brand }} {{ $detail->product->model_series ?? '' }}</div>
                                    <div style="color: #666; font-size: 11px;">{{ $detail->product->category->name ?? 'Barang Umum' }}</div>
                                    
                                    {{-- Tampilkan Spek HANYA jika isi datanya valid (bukan strip atau kosong) --}}
                                    @if((!empty($detail->product->processor) && $detail->product->processor != '-') || 
                                        (!empty($detail->product->ram) && $detail->product->ram != '-') || 
                                        (!empty($detail->product->storage) && $detail->product->storage != '-'))
                                        <div style="font-size: 10px; color: #666; margin-top: 2px; background: #f9fafb; padding: 2px 4px; border-radius: 3px; display: inline-block;">
                                            @if(!empty($detail->product->processor) && $detail->product->processor != '-') Proc: {{ $detail->product->processor }} @endif
                                            @if(!empty($detail->product->ram) && $detail->product->ram != '-') | RAM: {{ $detail->product->ram }} @endif
                                            @if(!empty($detail->product->storage) && $detail->product->storage != '-') | Storage: {{ $detail->product->storage }} @endif
                                        </div>
                                    @endif

                                    {{-- Serial Number di bawahnya --}}
                                    <div style="font-size: 10px; font-family: monospace; color: #1e40af; margin-top: 2px;">
                                        SN / Batch: {{ $detail->serial_number ?? $detail->product->serial_number ?? 'BATCH-xxx' }}
                                    </div>
                                </div>
                            </td>
                            <td style="width: 25%">
                                <div>{{ $detail->serial_number ?? $detail->product->serial_number ?? '-' }}</div>
                                @if($detail->manual_sn)
                                <div style="font-size: 10px; color: #4b5563; margin-top: 2px;">SN/Key: {{ $detail->manual_sn }}</div>
                                @endif
                            </td>
                            <td style="width: 25%" class="text-right">Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @else
                    @php $totalAmount = $sale->total_amount ?? 0; @endphp
                    <tr>
                        <td style="width: 50%">
                            <div>
                                <div style="font-weight: bold;">{{ $sale->product->brand ?? '' }} {{ $sale->product->model_series ?? '' }}</div>
                                <div style="color: #666; font-size: 11px;">{{ $sale->product->category->name ?? 'Barang Umum' }}</div>
                                
                                {{-- Tampilkan Spek HANYA jika isi datanya valid (bukan strip atau kosong) --}}
                                @if((!empty($sale->product->processor) && $sale->product->processor != '-') || 
                                    (!empty($sale->product->ram) && $sale->product->ram != '-') || 
                                    (!empty($sale->product->storage) && $sale->product->storage != '-'))
                                    <div style="font-size: 10px; color: #666; margin-top: 2px; background: #f9fafb; padding: 2px 4px; border-radius: 3px; display: inline-block;">
                                        @if(!empty($sale->product->processor) && $sale->product->processor != '-') Proc: {{ $sale->product->processor }} @endif
                                        @if(!empty($sale->product->ram) && $sale->product->ram != '-') | RAM: {{ $sale->product->ram }} @endif
                                        @if(!empty($sale->product->storage) && $sale->product->storage != '-') | Storage: {{ $sale->product->storage }} @endif
                                    </div>
                                @endif

                                {{-- Serial Number di bawahnya --}}
                                <div style="font-size: 10px; font-family: monospace; color: #1e40af; margin-top: 2px;">
                                    SN / Batch: {{ $sale->product->serial_number ?? 'BATCH-xxx' }}
                                </div>
                            </div>
                        </td>
                        <td style="width: 25%">
                            <div>{{ $sale->product->serial_number ?? '-' }}</div>
                            @if($sale->manual_sn)
                            <div style="font-size: 10px; color: #4b5563; margin-top: 2px;">SN/Key: {{ $sale->manual_sn }}</div>
                            @endif
                        </td>
                        <td style="width: 25%" class="text-right">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Subtotal:</div>
                <div class="total-value">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
            </div>
            @if($sale->tax_amount > 0)
            <div class="total-row">
                <div class="total-label">PPN (11%):</div>
                <div class="total-value">Rp {{ number_format($sale->tax_amount, 0, ',', '.') }}</div>
            </div>
            @endif
            @if($sale->discount_amount > 0)
            <div class="total-row">
                <div class="total-label">Diskon:</div>
                <div class="total-value">-Rp {{ number_format($sale->discount_amount, 0, ',', '.') }}</div>
            </div>
            @endif
            <div class="total-row grand-total">
                <div class="total-label">TOTAL PEMBAYARAN:</div>
                <div class="total-value">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Garansi Produk:</strong> Semua produk bergaransi 1 tahun untuk kerusakan hardware (bukan karena human error)</p>
            <p><strong>Kebijakan Pengembalian:</strong> Pengembalian produk dapat dilakukan dalam 7 hari dengan kondisi produk masih baik</p>
            <p><strong>Terima kasih telah berbelanja di LKtech TN SEREAL!</strong></p>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-title">Penjual</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-title">Pembeli</div>
            </div>
        </div>

        <!-- Print Controls (No Print Class) -->
        <div class="no-print print:hidden">
            <button onclick="window.print()" class="print-button">Cetak Faktur</button>
            <button onclick="window.close()" class="print-button">Tutup</button>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
        
        // Close window after printing
        window.onafterprint = function() {
            setTimeout(function() {
                window.close();
            }, 1000);
        };
    </script>
</body>
</html>
