<footer class="bg-white border-t border-gray-200 mt-auto pt-10 pb-6">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Kolom 1: Profil Singkat -->
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/LKtech.png') }}" alt="LKTech Logo" class="h-7 w-auto">
                    <span class="font-montserrat font-black text-xl tracking-tight text-blue-900">LKTech TN SEREAL</span>
                </a>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Penyedia layanan IT terpercaya: Penjualan laptop second berkualitas, servis & maintenance profesional, serta persewaan perangkat IT untuk kebutuhan acara dan instansi Anda.
                </p>
            </div>

            <!-- Kolom 2: Informasi Kontak -->
            <div>
                <h4 class="font-bold text-gray-800 mb-4 font-montserrat">Hubungi Kami</h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-start gap-2">
                        <i class='bx bx-map text-lg text-brand-500 mt-0.5 flex-shrink-0'></i>
                        <span>Villa Mutiara 1 Sektor 2 BLOK i-18 No.03<br>Tanah Sereal, Bogor 16168</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class='bx bx-envelope text-lg text-brand-500 flex-shrink-0'></i>
                        <a href="mailto:sales@lktech.online" class="hover:text-brand-600">sales@lktech.online</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class='bx bxl-whatsapp text-lg text-brand-500 flex-shrink-0'></i>
                        <a href="https://wa.me/628567354046" target="_blank" class="hover:text-brand-600">+62 856-7354-046</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class='bx bx-time-five text-lg text-brand-500 flex-shrink-0'></i>
                        <span>Senin - Sabtu: 09:00 - 17:00</span>
                    </li>
                </ul>
            </div>

            <!-- Kolom 3: Tautan Berguna -->
            <div>
                <h4 class="font-bold text-gray-800 mb-4 font-montserrat">Informasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-600 transition-colors">Beranda</a></li>
                    <li><a href="{{ route('katalog.index') }}" class="text-gray-600 hover:text-brand-600 transition-colors">Katalog Produk</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-brand-600 transition-colors flex items-center gap-1"><i class='bx bx-chevron-right text-brand-500'></i> Blog & Panduan</a></li>
                    <li><a href="{{ route('tentang-kami') }}" class="text-gray-600 hover:text-brand-600 transition-colors flex items-center gap-1"><i class='bx bx-chevron-right text-brand-500'></i> Tentang Kami</a></li>
                    <li><a href="{{ route('kebijakan-garansi') }}" class="text-gray-600 hover:text-brand-600 transition-colors flex items-center gap-1"><i class='bx bx-chevron-right text-brand-500'></i> Kebijakan Garansi</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-6 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-xs text-gray-500 font-medium">
                &copy; {{ date('Y') }} LKTech TN SEREAL. All rights reserved.
            </div>
        </div>
    </div>
</footer>
