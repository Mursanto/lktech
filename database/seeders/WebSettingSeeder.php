<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\WebSetting::firstOrCreate(
            ['id' => 1],
            [
                'nama_toko' => 'LKTech TN SEREAL',
                'deskripsi_footer' => 'Penyedia layanan IT terpercaya: Penjualan laptop second berkualitas, servis & maintenance profesional, serta persewaan perangkat IT untuk kebutuhan acara dan instansi Anda.',
                'alamat' => 'Villa Mutiara 1 Sektor 2 BLOK i-18 No.03<br>Tanah Sereal, Bogor 16168',
                'email' => 'sales@lktech.online',
                'telepon' => '+62 856-7354-046',
                'jam_operasional' => 'Senin - Sabtu: 09:00 - 17:00',
                'maps_iframe' => '<iframe src="https://maps.google.com/maps?q=LKtech+TN+SEREAL,+Tanah+Sereal,+Bogor&t=&z=15&ie=UTF8&iwloc=&output=embed" class="w-full h-40 md:h-48 rounded-lg shadow-sm border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'facebook_url' => 'https://www.facebook.com/marketplace/profile/1147601792/?ref=permalink&tab=listings&mibextid=dXMIcH',
                'instagram_url' => '#',
                'tiktok_url' => '#',
                'tentang_kami' => '<h2 class="text-2xl font-bold text-gray-900 mb-4 font-montserrat">Kisah Kami</h2>
                <p class="mb-4">
                    LKTech adalah sebuah usaha mikro yang bergerak di bidang penjualan laptop bekas berkualitas premium. Kami tidak sekadar menjual perangkat, tetapi juga mengutamakan layanan purna jual (after sales) serta menerapkan proses quality control yang ketat.
                </p>',
                'kebijakan_garansi' => '<h2 class="text-2xl font-bold text-gray-900 mb-4 font-montserrat">Masa Berlaku Garansi</h2>
                <p class="mb-6">
                    Kami memberikan garansi mesin selama 1 (satu) bulan dan garansi perangkat lunak (software) selama 1 (satu) minggu, terhitung sejak tanggal pembelian yang tercantum pada nota.
                </p>'
            ]
        );
    }
}
