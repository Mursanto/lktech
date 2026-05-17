<x-app-layout>
    <style>
        @media screen {
            body { background-color: #f3f4f6; }
            #printable-invoice {
                max-width: 210mm; /* Lebar kertas A4 */
                min-height: 297mm; /* Tinggi kertas A4 */
                margin: 40px auto; /* Posisikan di tengah layar */
                background: white;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                padding: 15mm; /* Samakan dengan margin print */
                border-radius: 8px;
            }
            /* Sembunyikan navbar/sidebar bawaan layout jika perlu */
            nav, header { display: none !important; }
            .min-h-screen { min-height: 0 !important; background: transparent !important; }
        }
        
        @media print {
            /* Reset kertas ke A4 dan hilangkan header/footer browser */
            @page { size: A4 portrait; margin: 0; }
            body { background: white; margin: 0; padding: 0; }
            
            /* Sembunyikan semua elemen web, tampilkan hanya area print */
            body * { visibility: hidden; }
            #printable-invoice, #printable-invoice * { visibility: visible; }
            
            /* Atur posisi kontainer print agar memenuhi kertas */
            #printable-invoice {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 15mm !important;
                box-sizing: border-box;
            }
            .no-print { display: none !important; }
        }
    </style>

    <div id="printable-invoice" class="bg-white">
        <div style="border: 1px solid #374151; padding: 25px; border-radius: 4px; font-family: sans-serif;">
            
            <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #d1d5db; padding-bottom: 15px; margin-bottom: 20px;">
                
                <div style="display: flex; align-items: flex-start; width: 60%;">
                    <img src="{{ asset('images/LKtech.png') }}" alt="Logo LKTech" style="max-height: 55px; width: auto; margin-right: 15px; display: block;">
                    <div>
                        <div style="font-weight: bold; font-size: 14pt; color: #1e3a8a; margin-bottom: 3px;">LK Tech TN SEREAL</div>
                        <div style="font-size: 8.5pt; color: #374151; line-height: 1.4;">
                            Villa Mutiara 1 Sektor 2 BLOK i-18 No.03, RT.03/RW.12<br>
                            Mekarwangi, Tanah Sereal, Kota Bogor, Jawa Barat 16168<br>
                            Telepon: 0856-7354-046
                        </div>
                    </div>
                </div>
                
                <div style="text-align: right; font-size: 9pt; width: 35%;">
                    <div style="margin-bottom: 5px;"><strong>No. Servis:</strong> {{ $service->service_number ?? 'SRV-000000' }}</div>
                    <div style="margin-bottom: 5px;"><strong>Tanggal:</strong> {{ isset($service->created_at) ? $service->created_at->format('d M Y, H:i') : date('d M Y') }}</div>
                    <div><strong>Teknisi:</strong> {{ $service->technician->name ?? 'Staff User' }}</div>
                </div>
            </div>

            <div style="text-align: center; font-weight: 900; font-size: 16pt; margin-bottom: 25px; letter-spacing: 2px;">
                TANDA TERIMA SERVIS
            </div>

            <table style="width: 100%; table-layout: fixed; font-size: 9pt; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="width: 33.33%; padding-right: 10px; vertical-align: top;">
                        <div style="font-size: 7.5pt; font-weight: bold; color: #4b5563; margin-bottom: 3px;">PELANGGAN</div>
                        <div style="color: #111827;">{{ $service->customer->name ?? 'Asep Ahmad' }}</div>
                    </td>
                    <td style="width: 33.33%; padding-right: 10px; vertical-align: top;">
                        <div style="font-size: 7.5pt; font-weight: bold; color: #4b5563; margin-bottom: 3px;">KONTAK / EMAIL</div>
                        <div style="color: #111827;">{{ $service->customer->phone ?? '-' }}</div>
                        <div style="color: #111827;">{{ $service->customer->email ?? '-' }}</div>
                    </td>
                    <td style="width: 33.33%; vertical-align: top;">
                        <div style="font-size: 7.5pt; font-weight: bold; color: #4b5563; margin-bottom: 3px;">ALAMAT</div>
                        <div style="color: #111827; word-wrap: break-word; white-space: normal;">{{ $service->customer->address ?? '-' }}</div>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; table-layout: fixed; font-size: 9pt; border-collapse: collapse; margin-bottom: 40px;">
                <thead>
                    <tr style="background-color: #f9fafb;">
                        <th style="width: 33.33%; text-align: left; padding: 10px 8px; border-top: 1px solid #d1d5db; border-bottom: 2px solid #d1d5db; font-size: 8.5pt;">MODEL & SERIAL NUMBER</th>
                        <th style="width: 33.33%; text-align: left; padding: 10px 8px; border-top: 1px solid #d1d5db; border-bottom: 2px solid #d1d5db; font-size: 8.5pt;">KELENGKAPAN</th>
                        <th style="width: 33.33%; text-align: left; padding: 10px 8px; border-top: 1px solid #d1d5db; border-bottom: 2px solid #d1d5db; font-size: 8.5pt;">KELUHAN / KENDALA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 12px 8px; vertical-align: top; border-bottom: 1px solid #e5e7eb;">
                            <div style="font-weight: bold; color: #111827;">{{ $service->device_name ?? 'ASUS XXX' }}</div>
                            <div style="font-size: 8pt; color: #4b5563; margin-top: 4px;">SN: {{ $service->serial_number ?? 'AS12234' }}</div>
                        </td>
                        <td style="padding: 12px 8px; vertical-align: top; border-bottom: 1px solid #e5e7eb; color: #111827;">
                            {{ $service->completeness ?? 'Unit laptop saja tanpa casan' }}
                        </td>
                        <td style="padding: 12px 8px; vertical-align: top; border-bottom: 1px solid #e5e7eb; color: #111827;">
                            {{ $service->complaint ?? 'Lemot masuk windows kadang suka error' }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div style="display: flex; justify-content: space-between; margin-top: 60px; padding: 0 40px;">
                <div style="text-align: center;">
                    <div style="border-bottom: 1px solid #111827; width: 180px; margin-bottom: 8px;"></div>
                    <div style="font-size: 9pt; color: #374151;">( Pelanggan )</div>
                </div>
                <div style="text-align: center;">
                    <div style="border-bottom: 1px solid #111827; width: 180px; margin-bottom: 8px;"></div>
                    <div style="font-size: 9pt; color: #374151;">( Teknisi/Staff )</div>
                </div>
            </div>

            <div style="text-align: center; font-size: 7.5pt; color: #6b7280; margin-top: 40px; font-style: italic;">
                Harap membawa tanda terima ini saat pengambilan unit. Terima kasih.
            </div>

        </div>         
        <div class="no-print" style="margin-top: 25px; text-align: center;">
            <a href="{{ route('services.index') }}" style="background-color: #9ca3af; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; margin-right: 10px; font-weight: bold;">Kembali</a>
            <button onclick="window.print()" style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer; font-weight: bold;">Cetak Tanda Terima</button>
        </div>
    </div>
    
    <script>
        // Otomatis memunculkan dialog print saat halaman selesai dimuat
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500); // Jeda setengah detik agar font/gambar termuat sempurna
        };
    </script>
</x-app-layout>
