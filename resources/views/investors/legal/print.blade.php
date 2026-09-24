<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perjanjian Kerja Sama LKTech - {{ $investor->name }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; line-height: 1.6; color: #000; max-width: 800px; margin: 0 auto; padding: 40px; }
        h1, h2, h3, h4 { text-align: center; }
        .header { margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .content { margin-bottom: 40px; }
        .signature-area { margin-top: 50px; display: flex; justify-content: space-between; }
        .signature-box { width: 45%; text-align: center; }
        .signature-line { margin-top: 80px; border-top: 1px solid #000; padding-top: 5px; font-weight: bold; }
        .stamp { 
            color: #10b981; border: 2px solid #10b981; border-radius: 50%; padding: 20px; 
            display: inline-block; transform: rotate(-15deg); margin-top: -20px; opacity: 0.8;
            font-family: sans-serif; font-size: 14px; font-weight: bold; text-align: center; line-height: 1.2;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer;">Cetak/Simpan PDF</button>
    </div>

    <div class="header">
        <h2>PERJANJIAN KERJA SAMA (PKS)<br>KEMITRAAN INVENTORI</h2>
        <p style="text-align: center;">No. Dokumen: LKTECH-INV-{{ str_pad($investor->id, 4, '0', STR_PAD_LEFT) }}-{{ now()->format('Y') }}</p>
    </div>

    <div class="content">
        <p>Pada hari ini, <strong>{{ \Carbon\Carbon::parse($investor->pks_agreed_at ?? now())->isoFormat('dddd, D MMMM YYYY') }}</strong>, kami yang bertanda tangan di bawah ini:</p>
        
        <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
            <tr>
                <td style="width: 20px; vertical-align: top;">1.</td>
                <td style="width: 150px; vertical-align: top;"><strong>Nama Lembaga</strong></td>
                <td style="width: 10px; vertical-align: top;">:</td>
                <td><strong>LKTech Indonesia</strong><br>Selanjutnya disebut sebagai <strong>PIHAK PERTAMA (PENGELOLA)</strong></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">2.</td>
                <td style="vertical-align: top;"><strong>Nama Lengkap</strong></td>
                <td style="vertical-align: top;">:</td>
                <td><strong>{{ $investor->name }}</strong><br>
                    Email: {{ $investor->email }}<br>
                    No. Telp: {{ $investor->phone ?? '-' }}<br>
                    Selanjutnya disebut sebagai <strong>PIHAK KEDUA (INVESTOR)</strong>
                </td>
            </tr>
        </table>

        <p>Kedua belah pihak telah sepakat mengikatkan diri dalam Perjanjian Kerja Sama (PKS) Kemitraan Inventori dengan syarat dan ketentuan sebagai berikut:</p>

        <h4>Pasal 1: Skema Bagi Hasil (Nisbah)</h4>
        <ol>
            <li>Keuntungan bersih (Nett Profit) per unit dihitung berdasarkan Harga Jual Akhir dikurangi Harga Modal Dasar.</li>
            <li>Nisbah pembagian keuntungan bersih adalah {{ 100 - $investor->share_percentage }}% untuk Pihak Pertama dan {{ number_format($investor->share_percentage, 0) }}% untuk Pihak Kedua.</li>
            <li>Harga Jual Akhir dan Harga Modal Dasar bersifat final dan dapat diawasi secara langsung oleh Pihak Kedua melalui Dashboard Real-time LKTech.</li>
        </ol>

        <h4>Pasal 2: Pencairan Dana dan Return Modal</h4>
        <ol>
            <li>Modal beserta keuntungan bagian Pihak Kedua akan dicairkan/dikreditkan ke saldo akun Pihak Kedua secara otomatis saat status barang telah "Terjual/Lunas".</li>
            <li>Waktu penarikan (payout) dana ke rekening bank Pihak Kedua dapat dilakukan sesuai dengan kebijakan SLA pencairan dari Pihak Pertama.</li>
        </ol>

        <h4>Pasal 3: Hak Pengawasan dan Transparansi</h4>
        <ol>
            <li>Pihak Pertama wajib memberikan akses sistem Dashboard Investor kepada Pihak Kedua.</li>
            <li>Pihak Kedua berhak melihat secara real-time status aset, stok tersisa, harga modal terdaftar, dan estimasi profit setiap saat.</li>
        </ol>

        <h4>Pasal 4: Ketentuan Garansi dan Jaminan Fisik</h4>
        <ol>
            <li>Pihak Pertama bertanggung jawab atas keamanan fisik inventori dari kerusakan, kehilangan, atau cacat sebelum barang terjual.</li>
            <li>Segala bentuk klaim garansi dari konsumen (after-sales) akan ditangani penuh oleh Pihak Pertama tanpa mengurangi nilai return Pihak Kedua.</li>
        </ol>
    </div>

    <div class="signature-area">
        <div class="signature-box">
            <p><strong>PIHAK PERTAMA</strong></p>
            <p>LKTech Indonesia</p>
            <div style="height: 100px;"></div>
            <div class="signature-line">Manajemen LKTech</div>
        </div>
        <div class="signature-box">
            <p><strong>PIHAK KEDUA</strong></p>
            <p>{{ $investor->name }}</p>
            
            @if($investor->pks_agreed_at)
            <div style="height: 100px; display: flex; align-items: center; justify-content: center;">
                <div class="stamp">
                    DISETUJUI SECARA DIGITAL<br>
                    <span style="font-size: 10px; font-weight: normal;">{{ \Carbon\Carbon::parse($investor->pks_agreed_at)->format('d/m/Y H:i:s') }}</span><br>
                    <span style="font-size: 10px; font-weight: normal;">IP: {{ $investor->pks_agreed_ip }}</span>
                </div>
            </div>
            @else
            <div style="height: 100px;"></div>
            @endif
            
            <div class="signature-line">{{ $investor->name }}</div>
        </div>
    </div>
</body>
</html>
