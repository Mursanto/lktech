<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Penjualan
        </h2>
    </x-slot>

    <style>
        @media print {
            /* 1. Pengaturan Kertas */
            @page {
                size: auto;
                margin: 10mm;
            }

            /* 2. Sembunyikan SEMUA elemen website secara default */
            body * {
                visibility: hidden;
            }

            /* 3. Tampilkan HANYA kontainer invoice dan isinya */
            #printable-invoice, #printable-invoice * {
                visibility: visible;
            }

            /* 4. Posisikan invoice di ujung paling atas & penuhi lebar kertas */
            #printable-invoice {
                position: absolute;
                left: 0;
                top: 0;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* 5. Pastikan warna background (seperti badge LUNAS & belang-belang tabel) tercetak */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* WAJIB: Hilangkan bayangan kartu agar bersih saat dicetak */
            .card, .card-invoice, #printable-invoice .shadow-md {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important; /* border tipis agar rapi */
                margin: 0 !important;
                padding: 0 !important;
            }
            #printable-invoice .rounded-xl {
                border-radius: 0 !important;
            }

            /* WAJIB: Sembunyikan semua elemen navigasi dan tombol */
            .no-print, 
            button, 
            .btn, 
            a.btn, 
            .sidebar, 
            .navbar,
            header {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }

            /* 8. Pastikan garis tabel halus namun jelas */
            table th, table td {
                border-color: #d1d5db !important;
            }

            /* 9. Paksa Layout Desktop pada Kertas (mencegah fallback ke mobile view yang bertumpuk) */
            .md\:flex-row { flex-direction: row !important; }
            .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
            .md\:mt-0 { margin-top: 0 !important; }
            .md\:text-right { text-align: right !important; text-align: -webkit-right !important; }
            
            /* 10. Pertahankan Display Type & Spacing */
            .flex { display: flex !important; }
            .grid { display: grid !important; }
            .justify-between { justify-content: space-between !important; }
            
            /* 11. Pastikan Garis Pembatas (Border) Tetap Terlihat Tegas */
            .border-b { 
                border-bottom-width: 1px !important; 
                border-bottom-style: solid !important; 
                border-color: #e5e7eb !important; 
            }
        }
    </style>

    <div id="printable-invoice" class="py-4 flex flex-col w-full">
        <div class="max-w-4xl mx-auto w-full sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
                <div class="p-4 md:p-6">
                    <!-- Classic Invoice Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start mb-4 border-b border-gray-200 pb-3">
                        <!-- Company Info -->
                        <div class="flex items-start">
                            <img src="{{ asset('images/LKtech.png') }}" alt="LK Tech Logo" class="h-10 w-auto mr-3">
                            <div class="text-xs text-gray-700">
                                <div class="font-extrabold text-sm text-gray-900 uppercase tracking-widest mb-0.5">LK Tech TN SEREAL</div>
                                <div class="leading-tight text-gray-600">
                                    Villa Mutiara 1 Sektor 2 BLOK i-18 No.03<br>
                                    Mekarwangi, Tanah Sereal, Bogor 16168<br>
                                    Telp: 0856-7354-046<br>
                                    Website: <a href="https://lktech.online/" class="text-blue-600 hover:underline">https://lktech.online/</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Invoice Title -->
                        <div class="mt-2 md:mt-0 text-left md:text-right">
                            <h2 class="text-2xl font-extrabold text-gray-900 uppercase tracking-widest mb-1">Invoice</h2>
                        </div>
                    </div>

                    <!-- Invoice Details & Bill To (2-Column Grid) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Customer Information (Bill To) -->
                        <div class="bg-slate-50 p-3 rounded border border-slate-200">
                            <h3 class="font-bold text-slate-800 mb-1.5 uppercase text-[10px] tracking-widest border-b border-slate-200 pb-1">Ditagihkan Kepada</h3>
                            <div class="text-xs text-slate-700 space-y-1">
                                <div class="font-bold text-sm text-slate-900">{{ $sale->customer->name ?? 'Pelanggan Umum' }}</div>
                                
                                @if($sale->customer && $sale->customer->phone)
                                <div><strong class="text-slate-800">Telp:</strong> {{ $sale->customer->phone }}</div>
                                @endif
                                
                                @if($sale->customer && $sale->customer->email)
                                <div><strong class="text-slate-800">Email:</strong> {{ $sale->customer->email }}</div>
                                @endif
                                
                                @if($sale->customer && $sale->customer->address)
                                <div class="pt-1 leading-tight">
                                    <strong class="text-slate-800 block">Alamat:</strong>
                                    {{ $sale->customer->address }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Invoice Metadata -->
                        <div class="bg-slate-50 p-3 rounded border border-slate-200">
                            <h3 class="font-bold text-slate-800 mb-1.5 uppercase text-[10px] tracking-widest border-b border-slate-200 pb-1">Detail Faktur</h3>
                            <div class="text-xs text-slate-700 space-y-1.5">
                                <div class="flex justify-between items-center border-b border-slate-200/60 pb-1">
                                    <span class="font-medium">No. Faktur:</span>
                                    <span class="font-bold text-slate-900">{{ $sale->invoice_no ?? str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-slate-200/60 pb-1">
                                    <span class="font-medium">Tanggal:</span>
                                    <span class="text-slate-900">{{ $sale->transaction_date->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-slate-200/60 pb-1">
                                    <span class="font-medium">Sales:</span>
                                    <span class="text-slate-900">{{ $sale->user->name }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-0.5">
                                    <span class="font-medium">Status:</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-800 border border-green-200">
                                        ✓ LUNAS
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="mt-2">
                        <table style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f9fafb;">
                                    <th style="width: 50%; padding: 4px 8px; text-align: left; font-size: 8pt; font-weight: 700; color: #374151; border: 1px solid #e5e7eb; border-bottom: 2px solid #d1d5db;">PRODUK</th>
                                    <th style="width: 25%; padding: 4px 8px; text-align: left; font-size: 8pt; font-weight: 700; color: #374151; border: 1px solid #e5e7eb; border-bottom: 2px solid #d1d5db;">NOMOR SERI</th>
                                    <th style="width: 25%; padding: 4px 8px; text-align: right; font-size: 8pt; font-weight: 700; color: #374151; border: 1px solid #e5e7eb; border-bottom: 2px solid #d1d5db;">HARGA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->saleDetails as $detail)
                                <tr style="background-color: #ffffff;" class="hover:bg-gray-50">                                     <td style="width: 50%; padding: 4px 8px; vertical-align: top; border-bottom: 1px solid #e5e7eb; font-size: 8pt;">
                                        <div>
                                            <div class="font-bold text-gray-800 flex items-center gap-1.5 flex-wrap">
                                                {{ $detail->product->brand }} {{ $detail->product->model_series ?? '' }}
                                                {{-- Badge Tipe Stok di Laporan --}}
                                                @if(($detail->product->tipe_stok ?? 'ready_stock') === 'open_order')
                                                    <span style="display:inline-block; padding: 1px 5px; border-radius: 3px; font-size: 7pt; font-weight: 700; background-color: #fff7ed; color: #c2410c; border: 1px solid #fed7aa;">Pre-Order</span>
                                                @else
                                                    <span style="display:inline-block; padding: 1px 5px; border-radius: 3px; font-size: 7pt; font-weight: 700; background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;">Ready</span>
                                                @endif
                                            </div>
                                            <div class="text-[10px] text-gray-500">{{ $detail->product->category->name ?? 'Umum' }}</div>
                                            @if((!empty($detail->product->processor) && $detail->product->processor != '-') || 
                                                (!empty($detail->product->ram) && $detail->product->ram != '-') || 
                                                (!empty($detail->product->storage) && $detail->product->storage != '-'))
                                                <div class="text-[9px] text-gray-600 mt-0.5 bg-gray-50 px-1 rounded inline-block leading-tight">
                                                    @if(!empty($detail->product->processor) && $detail->product->processor != '-') Proc: {{ $detail->product->processor }} @endif
                                                    @if(!empty($detail->product->ram) && $detail->product->ram != '-') | RAM: {{ $detail->product->ram }} @endif
                                                    @if(!empty($detail->product->storage) && $detail->product->storage != '-') | Storage: {{ $detail->product->storage }} @endif
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="width: 25%; padding: 4px 8px; vertical-align: top; border-bottom: 1px solid #e5e7eb; font-size: 8pt; white-space: nowrap;">
                                        <div>{{ $detail->serial_number ?? $detail->product->serial_number ?? '-' }}</div>
                                        @if($detail->manual_sn)
                                        <div class="text-[10px] text-gray-600 mt-0.5">SN/Key: {{ $detail->manual_sn }}</div>
                                        @endif
                                    </td>
                                    <td style="width: 25%; padding: 4px 8px; vertical-align: top; border-bottom: 1px solid #e5e7eb; font-size: 8pt; text-align: right; font-weight: 600;">
                                        Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="background-color: #f3f4f6;">
                                    <td colspan="2" style="padding: 6px 8px; text-align: right; font-weight: 700; font-size: 9pt; color: #111827; border-bottom: 1px solid #e5e7eb;">TOTAL BAYAR</td>
                                    <td style="padding: 6px 8px; text-align: right; font-weight: 700; font-size: 9pt; color: #111827; border-bottom: 1px solid #e5e7eb;">
                                        Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Section -->
                    <div class="mt-3 pt-2 border-t border-gray-200 flex justify-between items-end">
                        <div class="footer w-2/3">
                            <h4 class="font-semibold text-gray-900 text-[10px] mb-0.5">Ketentuan Garansi</h4>
                            <div class="text-gray-600 text-[9px]" style="line-height: 1.2;">
                                <div>1. Garansi 1 bln hardware. Segel utuh wajib.</div>
                                <div>2. Retur 7 hari jika produk masih baik. Batal jika jatuh/air.</div>
                            </div>
                        </div>
                        <div class="w-1/3 text-right text-gray-700 font-medium text-[9px] italic">
                            Terima kasih telah berbelanja di LKtech!
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="no-print mt-6 flex justify-center gap-2">
                        <a href="{{ route('sales.index') }}" class="px-3 py-1.5 bg-gray-300 hover:bg-gray-400 text-gray-800 text-xs font-bold rounded flex items-center shadow-sm">
                            <i class='bx bx-left-arrow-alt text-base mr-1'></i> Kembali
                        </a>
                        @role('Admin')
                        <a href="{{ route('sales.edit', $sale->id) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded flex items-center shadow-sm">
                            <i class='bx bx-edit text-sm mr-1'></i> Edit
                        </a>
                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Data stok akan dikembalikan.')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded flex items-center shadow-sm">
                                <i class='bx bx-trash text-sm mr-1'></i> Hapus
                            </button>
                        </form>
                        @endrole
                        <button onclick="window.print()" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded flex items-center shadow-sm">
                            <i class='bx bx-printer text-sm mr-1'></i> Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
