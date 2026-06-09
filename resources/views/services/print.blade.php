<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima Servis - {{ $service->service_number ?? 'SRV-' . str_pad($service->id, 6, '0', STR_PAD_LEFT) }}</title>
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
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 5px;
            text-align: left;
        }
        
        .company-info {
            font-size: 11px;
            color: #666;
            margin-bottom: 10px;
            text-align: left;
        }
        
        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 20px 0 10px 0;
            text-align: center;
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
            <div style="text-align: left;">
                <div class="logo">LK Tech TN SEREAL</div>
                <div class="company-info">
                    Alamat: Villa Mutiara 1 Sektor 2 BLOK i-18 No.03, RT.03/RW.12,<br>
                    Mekarwangi, Tanah Sereal, Kota Bogor, Jawa Barat 16168<br>
                    Telepon: 0856-7354-046<br>
                    Website: <a href="https://lktech.online/" style="color: #1e3a8a; text-decoration: none;">https://lktech.online/</a>
                </div>
            </div>
            <div style="text-align: right;">
                <img src="{{ asset('images/LKtech.png') }}" alt="LK Tech Logo" style="height: 64px; width: auto;">
            </div>
        </div>

        <!-- Invoice Title -->
        <div class="invoice-title">TANDA TERIMA SERVIS</div>

        <!-- Invoice Information -->
        <div class="invoice-info">
            <div class="info-section">
                <div class="info-label">DITAGIHKAN KEPADA</div>
                <div class="info-value" style="font-weight: bold;">{{ $service->customer->name ?? 'Pelanggan Umum' }}</div>
                
                <div class="info-label">Telepon</div>
                <div class="info-value">{{ $service->customer->phone ?? '-' }}</div>
                
                <div class="info-label">Alamat</div>
                <div class="info-value">{{ $service->customer->address ?? '-' }}</div>
            </div>
            
            <div class="info-section">
                <div class="info-label">DETAIL LAYANAN</div>
                <div class="info-value"><strong>No. Servis:</strong> {{ $service->service_number ?? 'SRV-' . str_pad($service->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="info-value"><strong>Tanggal Masuk:</strong> {{ isset($service->created_at) ? $service->created_at->format('d M Y, H:i') : date('d M Y') }}</div>
                <div class="info-value"><strong>Teknisi:</strong> {{ $service->technician->name ?? 'Staff User' }}</div>
                <div class="info-value"><strong>Status:</strong> 
                    <span style="font-size: 10px; font-weight: bold; color: white; padding: 2px 6px; border-radius: 4px; background-color: {{ $service->status == 'done' ? '#10b981' : ($service->status == 'process' ? '#3b82f6' : '#ef4444') }}">
                        {{ strtoupper($service->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%">Deskripsi Item</th>
                    <th style="width: 25%">Keterangan</th>
                    <th style="width: 25%" class="text-right">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($service->items as $index => $item)
                <!-- Device Separator -->
                <tr style="background-color: #f3f4f6;">
                    <td colspan="3" style="padding: 6px 10px; border-bottom: 1px solid #e5e7eb;">
                        <span style="font-weight: bold; color: #111827;">Perangkat {{ $index + 1 }}: {{ $item->device_name }}</span> 
                        <span style="font-size: 10px; color: #4b5563;">- SN: {{ $item->serial_number ?: 'Tidak Ada' }}</span>
                    </td>
                </tr>
                
                <!-- Biaya Jasa -->
                <tr>
                    <td style="width: 50%">
                        <div style="font-weight: bold;">Jasa Perbaikan / Instalasi</div>
                        <div style="color: #666; font-size: 11px; margin-top: 2px;">{{ $item->complaint ?: '-' }}</div>
                    </td>
                    <td style="width: 25%">
                        <div style="color: #666; font-size: 11px;">Kelengkapan: {{ $item->equipment_details ?: '-' }}</div>
                    </td>
                    <td style="width: 25%" class="text-right">Rp {{ number_format($item->service_charge, 0, ',', '.') }}</td>
                </tr>

                <!-- Spareparts -->
                @foreach($item->spareparts ?? [] as $part)
                <tr>
                    <td style="width: 50%">
                        <div style="font-weight: normal; color: #4b5563; padding-left: 10px;">• Suku Cadang</div>
                    </td>
                    <td style="width: 25%">
                        <div>{{ $part['name'] }}</div>
                    </td>
                    <td style="width: 25%" class="text-right">Rp {{ number_format($part['price'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
                
                <!-- Subtotal Perangkat -->
                @php 
                    $itemTotal = $item->service_charge + collect($item->spareparts)->sum('price');
                @endphp
                <tr>
                    <td colspan="2" class="text-right" style="padding: 6px 10px; font-weight: bold; font-size: 11px; color: #666; border-bottom: 2px solid #ddd;">
                        Subtotal Perangkat {{ $index + 1 }}
                    </td>
                    <td class="text-right" style="padding: 6px 10px; font-weight: bold; color: #333; border-bottom: 2px solid #ddd;">
                        Rp {{ number_format($itemTotal, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
                
                <!-- Catatan Teknisi Keseluruhan -->
                @if($service->notes)
                <tr>
                    <td colspan="3" style="padding: 10px;">
                        <span style="font-weight: bold; font-size: 10px; color: #666; text-transform: uppercase;">Catatan Teknisi:</span>
                        <div style="font-style: italic; color: #333; margin-top: 2px;">{{ $service->notes }}</div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-row grand-total">
                <div class="total-label">GRAND TOTAL:</div>
                <div class="total-value">Rp {{ number_format($service->estimated_cost, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="text-align: left; margin-bottom: 5px;"><strong>Ketentuan Layanan & Garansi:</strong></p>
            <ol style="text-align: left; margin-top: 0; padding-left: 20px; font-size: 10px;">
                <li>Garansi servis 1 bulan untuk kerusakan yang sama.</li>
                <li>Segel utuh wajib. Batal jika jatuh/terkena air/human error.</li>
                <li>Perangkat yang tidak diambil > 3 bulan di luar tanggung jawab kami.</li>
            </ol>
            <p style="margin-top: 20px;"><strong>Terima kasih telah mempercayakan servis Anda di LKtech!</strong></p>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-title">Teknisi</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-title">Pelanggan</div>
            </div>
        </div>

        <!-- Print Controls (No Print Class) -->
        <div class="no-print">
            <button onclick="window.print()" class="print-button">Cetak Tanda Terima</button>
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
