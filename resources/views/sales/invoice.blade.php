<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $company['name'] }}</title>
    <style>
        @page {
            margin: 20mm;
            size: A4;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .company-info {
            font-size: 11px;
            color: #666;
        }
        
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            color: #333;
        }
        
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .invoice-number {
            font-weight: bold;
        }
        
        .billing-info {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .products-table th {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        
        .products-table td {
            padding: 10px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        .products-table .specs {
            font-size: 10px;
            color: #666;
            line-height: 1.2;
        }
        
        .total-section {
            text-align: right;
            margin-bottom: 30px;
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
        }
        
        .grand-total {
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .warranty-section {
            margin-top: 40px;
            padding: 20px;
            background-color: #f8f9fa;
            border-left: 4px solid #2563eb;
        }
        
        .warranty-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #2563eb;
        }
        
        .warranty-list {
            list-style-type: decimal;
            padding-left: 20px;
        }
        
        .warranty-list li {
            margin-bottom: 5px;
            font-size: 11px;
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
            height: 40px;
            margin-bottom: 5px;
        }
        
        .signature-label {
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">{{ $company['name'] }}</div>
        <div class="company-info">
            {{ $company['address'] }}<br>
            Phone: {{ $company['phone'] }} | Email: {{ $company['email'] }}
        </div>
    </div>

    <!-- Invoice Title -->
    <div class="invoice-title">INVOICE</div>

    <!-- Invoice Information -->
    <div class="invoice-info">
        <div>
            <div class="section-title">Invoice Details</div>
            <div><strong>Invoice #:</strong> {{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div><strong>Date:</strong> {{ $sale->transaction_date->format('d F Y') }}</div>
            <div><strong>Sales Person:</strong> {{ $sale->user->name }}</div>
        </div>
        <div>
            <div class="section-title">Customer Information</div>
            <div><strong>Name:</strong> {{ $sale->customer_name }}</div>
            <div><strong>Payment Method:</strong> Cash</div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="section-title">Product Details</div>
    <table class="products-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Product</th>
                <th width="35%">Specifications</th>
                <th width="15%">Serial Number</th>
                <th width="10%">Condition</th>
                <th width="10%" style="text-align: right;">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleDetails as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $detail->product->brand }} {{ $detail->product->model_series }}</strong><br>
                    <small>{{ $detail->product->category->name }}</small>
                </td>
                <td class="specs">
                    <strong>Processor:</strong> {{ $detail->product->processor }}<br>
                    <strong>RAM:</strong> {{ $detail->product->ram }}<br>
                    <strong>Storage:</strong> {{ $detail->product->storage }}<br>
                    <strong>Screen:</strong> {{ $detail->product->screen_size }}"<br>
                    <strong>Battery:</strong> {{ $detail->product->battery_health }}% ({{ $detail->product->battery_runtime }}h)
                </td>
                <td>{{ $detail->product->serial_number }}</td>
                <td>{{ $detail->product->condition }}</td>
                <td style="text-align: right;">Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total Section -->
    <div class="total-section">
        <div class="total-row">
            <div class="total-label">Subtotal:</div>
            <div class="total-value">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</div>
        </div>
        <div class="total-row">
            <div class="total-label">Discount:</div>
            <div class="total-value">Rp 0</div>
        </div>
        <div class="total-row grand-total">
            <div class="total-label">TOTAL:</div>
            <div class="total-value">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Warranty Section -->
    <div class="warranty-section">
        <div class="warranty-title">Warranty Terms & Conditions</div>
        <ol class="warranty-list">
            @foreach($warranty_terms as $term)
            <li>{{ $term }}</li>
            @endforeach
        </ol>
        <p style="margin-top: 15px; font-size: 11px; font-style: italic;">
            This invoice serves as proof of purchase and warranty claim. Please keep this document for future reference.
        </p>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line"></div>
            <div class="signature-label">Customer Signature</div>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <div class="signature-label">{{ $sale->user->name }}<br>Sales Representative</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>{{ $company['name'] }} - Computer Sales & Service</div>
        <div>Thank you for your business!</div>
        <div>This is a computer-generated invoice and is valid without signature.</div>
    </div>
</body>
</html>
