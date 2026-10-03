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
                <td style="width: 150px; vertical-align: top;"><strong>PIHAK PERTAMA (PENGELOLA)</strong></td>
                <td style="width: 10px; vertical-align: top;">:</td>
                <td><strong>LKTech Indonesia</strong>, diwakili oleh Mursanto selaku Owner/Pemilik, berkedudukan sebagai pengelola dana, pengada barang, promotor, penjamin teknis, dan penjual akhir kepada konsumen.</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">2.</td>
                <td style="vertical-align: top;"><strong>PIHAK KEDUA (INVESTOR)</strong></td>
                <td style="vertical-align: top;">:</td>
                <td><strong>{{ $investor->email === 'dataku.ak47@gmail.com' ? 'Arief Kurniawan' : $investor->name }}</strong><br>
                    Email: {{ $investor->email }}<br>
                    No. Telp: {{ $investor->phone ?? '-' }}<br>
                    berkedudukan sebagai penyedia modal yang disalurkan dalam bentuk aset inventori (laptop/device).
                </td>
            </tr>
        </table>

        <p>Kedua belah pihak telah sepakat mengikatkan diri dalam Perjanjian Kerja Sama (PKS) Kemitraan Inventori dengan syarat dan ketentuan sebagai berikut:</p>

        <h4>Pasal 1: Skema Bagi Hasil (Nisbah) & Perhitungan Profit</h4>
        <ol>
            <li>Laba Bersih (Nett Profit) per unit dihitung dari Harga Jual Akhir dikurangi Harga Modal Dasar dan Biaya Perbaikan Garansi (apabila ada klaim perbaikan hardware selama masa garansi toko).</li>
            <li>Nisbah pembagian Laba Bersih adalah {{ 100 - $investor->share_percentage }}% ({{ number_format(100 - $investor->share_percentage, 0) }} persen) untuk Pihak Pertama dan {{ number_format($investor->share_percentage, 0) }}% ({{ number_format($investor->share_percentage, 0) }} persen) untuk Pihak Kedua.</li>
            <li>Harga Modal Dasar, Harga Jual Akhir, dan alokasi unit bersifat transparan dan dapat dipantau langsung oleh Pihak Kedua melalui Dashboard Real-time LKTech.</li>
        </ol>

        <h4>Pasal 2: Masa Garansi Toko & Tanggung Jawab Bersih Perbaikan</h4>
        <ol>
            <li><strong>Garansi Mitra/Supplier:</strong> Garansi dari mitra pengada barang (supplier) adalah selama 1 (satu) minggu. Jika unit mengalami kerusakan pada minggu pertama, klaim dilakukan langsung ke mitra/supplier tanpa memotong profit investasi.</li>
            <li><strong>Garansi Consumer After-Sales:</strong> Pihak Pertama memberikan garansi hardware kepada konsumen selama 1 (satu) bulan (30 hari) sejak unit diterima/terjual.</li>
            <li><strong>Prinsip Tanggung Jawab Bersama (Anti-Gravity Risk Allocation):</strong>
                <ul>
                    <li>Apabila terjadi kerusakan hardware (termasuk namun tidak terbatas pada Keyboard, LCD, RAM, SSD, atau Mainboard) setelah masa garansi mitra habis (minggu ke-2 hingga hari ke-30), biaya perbaikan/penggantian komponen dialokasikan sebagai Biaya Operasional Garansi Unit.</li>
                    <li>Biaya tersebut dipotong dari Laba Kotor (Gross Profit) unit terkait terlebih dahulu sebelum sisa Laba Bersih dibagi sesuai nisbah {{ 100 - $investor->share_percentage }}:{{ number_format($investor->share_percentage, 0) }}.</li>
                    <li>Apabila biaya perbaikan melebihi estimasi laba unit tersebut, selisih biaya ditanggung bersama secara proporsional atau dipotong dari modal unit terkait atas kesepakatan kedua pihak.</li>
                </ul>
            </li>
        </ol>

        <h4>Pasal 3: Pencairan Dana & Return Modal (Payout SLA)</h4>
        <ol>
            <li>Pengembalian modal dasar beserta bagian keuntungan Pihak Kedua akan dikreditkan ke saldo akun/dashboard Pihak Kedua setelah unit dinyatakan Terjual Lunas dan Selesai Masa Garansi Hardware 1 Bulan (30 Hari).</li>
            <li>Penahanan dana selama 30 hari ini bertujuan untuk memastikan cash flow aman dan nilai profit yang dicairkan sudah benar-benar bersih (nett) dari risiko retur/klaim konsumen.</li>
            <li>Penarikan dana (payout) dari saldo Dashboard ke rekening bank Pihak Kedua dapat dilakukan sesuai dengan prosedur dan SLA pencairan yang berlaku di LKTech Indonesia.</li>
        </ol>

        <h4>Pasal 4: Hak Pengawasan & Transparansi</h4>
        <ol>
            <li>Pihak Pertama wajib memberikan dan menjaga akses akun Dashboard Investor kepada Pihak Kedua.</li>
            <li>Pihak Kedua berhak melihat secara real-time status aset, stok tersisa, harga modal terdaftar, status garansi yang berjalan, dan estimasi profit setiap saat.</li>
        </ol>

        <h4>Pasal 5: Penyelesaian Perselisihan</h4>
        <p>Segala bentuk perselisihan yang timbul dari pelaksanaan perjanjian ini akan diselesaikan secara musyawarah dan mufakat berdasarkan asas transparansi, keterbukaan, dan iktikad baik.</p>
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
