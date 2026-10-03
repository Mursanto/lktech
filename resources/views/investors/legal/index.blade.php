<x-app-layout>
    <x-slot name="header">
        <h2 class="text-base font-bold text-natural-900 tracking-tight leading-none truncate">Perjanjian & Legalitas PKS</h2>
        <p class="text-natural-500 text-[10px] mt-1 truncate">Syarat dan ketentuan Perjanjian Kerja Sama LKTech - Investor</p>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-4">
        @if(session('success'))
        <div class="p-3 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-sm flex items-center gap-2 font-medium">
            <i class='bx bx-check-circle text-lg'></i>
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="p-3 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm flex items-center gap-2 font-medium">
            <i class='bx bx-error-circle text-lg'></i>
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl border border-natural-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-natural-100 flex justify-between items-center bg-natural-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i class='bx bx-file-blank text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-natural-800">Perjanjian Kerja Sama (PKS)</h3>
                        <p class="text-[10px] text-natural-500">Versi Dokumen: v1.0.0</p>
                    </div>
                </div>
                
                @if($investor->pks_agreed_at)
                <a href="{{ route('investor.legal.export') }}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm flex items-center gap-2">
                    <i class='bx bx-printer'></i> Cetak/PDF
                </a>
                @endif
            </div>
            
            <div class="p-5 md:p-8 bg-white border-b border-natural-100 text-sm text-natural-700 leading-relaxed max-h-[500px] overflow-y-auto custom-scrollbar">
                <h4 class="text-center font-bold text-lg text-natural-900 mb-6 uppercase tracking-wider">Perjanjian Kerja Sama Investasi Inventory</h4>
                
                <p class="mb-4">Pada hari ini, disepakati Perjanjian Kerja Sama Investasi antara pihak-pihak di bawah ini:</p>
                <div class="mb-6 space-y-2 pl-4 border-l-2 border-brand-200">
                    <p><strong>1. PIHAK PERTAMA (PENGELOLA):</strong><br> LKTech Indonesia, diwakili oleh Mursanto selaku Owner/Pemilik, berkedudukan sebagai pengelola dana, pengada barang, promotor, penjamin teknis, dan penjual akhir kepada konsumen.</p>
                    <p><strong>2. PIHAK KEDUA (INVESTOR/PEMODAL):</strong><br> <strong>{{ $investor->email === 'dataku.ak47@gmail.com' ? 'Arief Kurniawan' : $investor->name }}</strong> (email: {{ $investor->email }}), berkedudukan sebagai penyedia modal yang disalurkan dalam bentuk aset inventori (laptop/device).</p>
                </div>
                
                <p class="mb-4 font-bold text-natural-900">Pasal 1: Skema Bagi Hasil (Nisbah) & Perhitungan Profit</p>
                <ul class="list-decimal pl-5 mb-6 space-y-1">
                    <li>Laba Bersih (Nett Profit) per unit dihitung dari Harga Jual Akhir dikurangi Harga Modal Dasar dan Biaya Perbaikan Garansi (apabila ada klaim perbaikan hardware selama masa garansi toko).</li>
                    <li>Nisbah pembagian Laba Bersih adalah <strong>{{ 100 - $investor->share_percentage }}% ({{ number_format(100 - $investor->share_percentage, 0) }} persen) untuk Pihak Pertama</strong> dan <strong>{{ number_format($investor->share_percentage, 0) }}% ({{ number_format($investor->share_percentage, 0) }} persen) untuk Pihak Kedua</strong>.</li>
                    <li>Harga Modal Dasar, Harga Jual Akhir, dan alokasi unit bersifat transparan dan dapat dipantau langsung oleh Pihak Kedua melalui Dashboard Real-time LKTech.</li>
                </ul>

                <p class="mb-4 font-bold text-natural-900">Pasal 2: Masa Garansi Toko & Tanggung Jawab Bersih Perbaikan</p>
                <ul class="list-decimal pl-5 mb-6 space-y-1">
                    <li><strong>Garansi Mitra/Supplier:</strong> Garansi dari mitra pengada barang (supplier) adalah selama 1 (satu) minggu. Jika unit mengalami kerusakan pada minggu pertama, klaim dilakukan langsung ke mitra/supplier tanpa memotong profit investasi.</li>
                    <li><strong>Garansi Consumer After-Sales:</strong> Pihak Pertama memberikan garansi hardware kepada konsumen selama 1 (satu) bulan (30 hari) sejak unit diterima/terjual.</li>
                    <li><strong>Prinsip Tanggung Jawab Bersama (Anti-Gravity Risk Allocation):</strong>
                        <ul class="list-disc pl-5 mt-1 space-y-1">
                            <li>Apabila terjadi kerusakan hardware (termasuk namun tidak terbatas pada Keyboard, LCD, RAM, SSD, atau Mainboard) setelah masa garansi mitra habis (minggu ke-2 hingga hari ke-30), biaya perbaikan/penggantian komponen dialokasikan sebagai Biaya Operasional Garansi Unit.</li>
                            <li>Biaya tersebut dipotong dari Laba Kotor (Gross Profit) unit terkait terlebih dahulu sebelum sisa Laba Bersih dibagi sesuai nisbah {{ 100 - $investor->share_percentage }}:{{ number_format($investor->share_percentage, 0) }}.</li>
                            <li>Apabila biaya perbaikan melebihi estimasi laba unit tersebut, selisih biaya ditanggung bersama secara proporsional atau dipotong dari modal unit terkait atas kesepakatan kedua pihak.</li>
                        </ul>
                    </li>
                </ul>

                <p class="mb-4 font-bold text-natural-900">Pasal 3: Pencairan Dana & Return Modal (Payout SLA)</p>
                <ul class="list-decimal pl-5 mb-6 space-y-1">
                    <li>Pengembalian modal dasar beserta bagian keuntungan Pihak Kedua akan dikreditkan ke saldo akun/dashboard Pihak Kedua setelah unit dinyatakan Terjual Lunas dan Selesai Masa Garansi Hardware 1 Bulan (30 Hari).</li>
                    <li>Penahanan dana selama 30 hari ini bertujuan untuk memastikan cash flow aman dan nilai profit yang dicairkan sudah benar-benar bersih (nett) dari risiko retur/klaim konsumen.</li>
                    <li>Penarikan dana (payout) dari saldo Dashboard ke rekening bank Pihak Kedua dapat dilakukan sesuai dengan prosedur dan SLA pencairan yang berlaku di LKTech Indonesia.</li>
                </ul>

                <p class="mb-4 font-bold text-natural-900">Pasal 4: Hak Pengawasan & Transparansi</p>
                <ul class="list-decimal pl-5 mb-6 space-y-1">
                    <li>Pihak Pertama wajib memberikan dan menjaga akses akun Dashboard Investor kepada Pihak Kedua.</li>
                    <li>Pihak Kedua berhak melihat secara real-time status aset, stok tersisa, harga modal terdaftar, status garansi yang berjalan, dan estimasi profit setiap saat.</li>
                </ul>

                <p class="mb-4 font-bold text-natural-900">Pasal 5: Penyelesaian Perselisihan</p>
                <p class="mb-6 pl-5">Segala bentuk perselisihan yang timbul dari pelaksanaan perjanjian ini akan diselesaikan secara musyawarah dan mufakat berdasarkan asas transparansi, keterbukaan, dan iktikad baik.</p>
            </div>
            
            <div class="px-5 md:px-8 py-5 bg-natural-50/50">
                @if(!$investor->pks_agreed_at)
                <form method="POST" action="{{ route('investor.legal.agree') }}" x-data="{ checked: false }">
                    @csrf
                    <label class="flex items-start gap-3 cursor-pointer group mb-4">
                        <div class="pt-0.5">
                            <input type="checkbox" x-model="checked" required class="w-4 h-4 text-brand-600 rounded border-natural-300 focus:ring-brand-500 cursor-pointer">
                        </div>
                        <span class="text-sm text-natural-700 font-medium group-hover:text-natural-900 transition-colors">
                            Saya telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan investasi (PKS) yang tertera di atas tanpa paksaan dari pihak mana pun.
                        </span>
                    </label>
                    <div class="flex justify-end">
                        <button type="submit" :disabled="!checked" :class="!checked ? 'bg-natural-300 cursor-not-allowed' : 'bg-brand-600 hover:bg-brand-700 shadow-sm shadow-brand-500/20'" class="px-6 py-2.5 text-white font-bold rounded-lg text-sm transition-all flex items-center gap-2">
                            <i class='bx bx-check-shield'></i> Setujui Perjanjian
                        </button>
                    </div>
                </form>
                @else
                <div class="flex items-center gap-4 bg-emerald-50 border border-emerald-100 p-4 rounded-xl">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-emerald-600 shrink-0 shadow-sm border border-emerald-100">
                        <i class='bx bx-check-shield text-2xl'></i>
                    </div>
                    <div>
                        <p class="text-emerald-800 font-bold text-sm mb-0.5">Disetujui Secara Digital</p>
                        <p class="text-emerald-600 text-xs">
                            Anda telah menyetujui PKS ini pada: <strong class="font-bold">{{ \Carbon\Carbon::parse($investor->pks_agreed_at)->format('d F Y H:i:s') }}</strong>. 
                            <br>Tercatat dari IP Address: {{ $investor->pks_agreed_ip }}
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
