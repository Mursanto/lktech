<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
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
            margin: 20px 0;
        }
        
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .invoice-details {
            flex: 1;
        }
        
        .billing-details {
            flex: 1;
            text-align: right;
        }
        
        .section-title {
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .info-row {
            margin-bottom: 5px;
            font-size: 11px;
        }
        
        .info-label {
            font-weight: bold;
            color: #666;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .products-table th {
            background-color: #1e3a8a;
            color: white;
            text-align: left;
            padding: 10px;
            font-size: 11px;
        }
        
        .products-table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }
        
        .products-table .text-right {
            text-align: right;
        }
        
        .products-table .text-center {
            text-align: center;
        }
        
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        
        .total-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 5px;
        }
        
        .total-label {
            min-width: 150px;
            text-align: right;
            padding-right: 20px;
            font-weight: bold;
            font-size: 11px;
        }
        
        .total-value {
            min-width: 120px;
            text-align: right;
            font-weight: bold;
            font-size: 11px;
        }
        
        .grand-total {
            border-top: 2px solid #1e3a8a;
            padding-top: 5px;
            font-size: 14px;
            color: #1e3a8a;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .signature-section {
            margin-top: 50px;
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
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->

    <div class="content">
        <table class="info-table">
            <tr>
                <th width="30%">Kasir</th>
                <td width="70%">{{ $sale->user->name ?? 'System' }}</td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Produk</th>
                    <th width="15%">Qty</th>
                    <th width="20%">Harga</th>
                    <th width="25%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->saleDetails as $index => $detail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $detail->product->brand }} {{ $detail->product->model_series }}</td>
                    <td class="text-center">{{ $detail->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}</td>
                    <td class="text-right highlight">Rp {{ number_format($detail->quantity * $detail->price_at_transaction, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="info-table">
            <tr>
                <th width="60%">Total Quantity</th>
                <td class="text-right" colspan="3">{{ $sale->saleDetails->sum('quantity') }}</td>
            </tr>
            <tr>
                <th width="60%">Total Harga</th>
                <td class="text-right" colspan="3">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th width="60%">Total Profit</th>
                <td class="text-right" colspan="3">Rp {{ number_format($sale->profit_amount, 0, ',', '.') }}</td>
            </tr>
        </table>
        <div class="footer">
            <strong>Terms & Conditions:</strong><br>
            1. Payment must be made within 30 days from invoice date.<br>
            2. All prices are in Indonesian Rupiah (IDR).<br>
            3. Goods sold are not returnable.<br>
            4. This invoice is considered valid after payment is received.<br><br>
            <strong>Thank you for your business!</strong>
        </div>
    </div>
</body>
</html>
