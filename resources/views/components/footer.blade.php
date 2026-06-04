<footer class="bg-white border-t border-gray-200 mt-auto pt-10 pb-6">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8 items-start">
            
            <!-- Kolom 1: Profil Singkat -->
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4 h-6">
                    <img src="{{ asset('images/LKtech.png') }}" alt="LKTech Logo" class="h-6 w-auto object-contain">
                    <span class="font-montserrat font-black text-[19px] tracking-tight text-blue-900 leading-none">LKTech TN SEREAL</span>
                </a>
                <p class="text-sm text-gray-500 leading-relaxed mt-1">
                    Penyedia layanan IT terpercaya: Penjualan laptop second berkualitas, servis & maintenance profesional, serta persewaan perangkat IT untuk kebutuhan acara dan instansi Anda.
                </p>
            </div>

            <!-- Kolom 2: Informasi Kontak -->
            <div>
                <h4 class="font-bold text-gray-800 mb-4 font-montserrat h-6 flex items-center">Hubungi Kami</h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-start gap-2">
                        <i class='bx bx-map text-lg text-brand-500 mt-0.5 flex-shrink-0'></i>
                        <span class="leading-relaxed">Villa Mutiara 1 Sektor 2 BLOK i-18 No.03<br>Tanah Sereal, Bogor 16168</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class='bx bx-envelope text-lg text-brand-500 flex-shrink-0'></i>
                        <a href="mailto:sales@lktech.online" class="hover:text-brand-600 transition-colors">sales@lktech.online</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class='bx bxl-whatsapp text-lg text-brand-500 flex-shrink-0'></i>
                        <a href="https://wa.me/628567354046" target="_blank" class="hover:text-brand-600 transition-colors">+62 856-7354-046</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class='bx bx-time-five text-lg text-brand-500 flex-shrink-0'></i>
                        <span>Senin - Sabtu: 09:00 - 17:00</span>
                    </li>
                </ul>
            </div>

            <!-- Kolom 3: Metode Pembayaran & Sosial Media -->
            <div>
                <!-- Metode Pembayaran -->
                <h4 class="font-bold text-gray-800 mb-4 font-montserrat h-6 flex items-center">Metode Pembayaran</h4>
                <div class="flex flex-wrap gap-2 mb-7">
                    
                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center tracking-tighter">
                        <span class="text-[#005E6A]">Livin'</span> <span class="text-[#FFB71B] ml-0.5">Mandiri</span>
                    </div>
                    
                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center tracking-tighter">
                        <span class="text-[#006677]">wondr</span> <span class="text-[9px] text-gray-400 mx-1 font-medium italic">by</span> <span class="text-[#F15A23]">BNI</span>
                    </div>
                    
                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center tracking-tighter italic">
                        <span class="text-[#4C2882]">OVO</span>
                    </div>
                    
                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center tracking-tighter">
                        <span class="text-[#00AED6]">GoPay</span>
                    </div>

                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center tracking-tighter">
                        <span class="text-[#108EE9]">DANA</span>
                    </div>

                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center tracking-tighter">
                        <span class="text-[#EE4D2D]">ShopeePay</span>
                    </div>

                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center tracking-tighter">
                        <span class="text-[#DF1921] italic">LinkAja</span>
                    </div>

                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center tracking-tighter italic">
                        <span class="text-[#ED1C24]">QR</span><span class="text-[#005B9F]">IS</span>
                    </div>
                </div>

                <!-- Ikuti Kami -->
                <h4 class="font-bold text-gray-800 mb-4 font-montserrat h-6 flex items-center">Ikuti Kami</h4>
                <div class="flex gap-2">
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/marketplace/profile/1147601792/?ref=permalink&tab=listings&mibextid=dXMIcH" target="_blank" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:-translate-y-1 transition-transform duration-300" title="Facebook">
                        <i class='bx bxl-facebook text-lg text-[#1877F2]'></i>
                    </a>
                    <!-- Instagram -->
                    <a href="#" target="_blank" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group" title="Instagram">
                        <div class="absolute inset-0 bg-gradient-to-tr from-[#F58529] via-[#DD2A7B] to-[#8134AF] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class='bx bxl-instagram text-lg text-gray-700 group-hover:text-white relative z-10 transition-colors'></i>
                    </a>
                    <!-- LinkedIn -->
                    <a href="#" target="_blank" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:-translate-y-1 transition-transform duration-300" title="LinkedIn">
                        <i class='bx bxl-linkedin text-lg text-[#0A66C2]'></i>
                    </a>
                    <!-- TikTok -->
                    <a href="#" target="_blank" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:-translate-y-1 transition-transform duration-300" title="TikTok">
                        <i class='bx bxl-tiktok text-lg text-[#010101]'></i>
                    </a>
                </div>
            </div>

            <!-- Kolom 4: Tautan Berguna -->
            <div>
                <h4 class="font-bold text-gray-800 mb-4 font-montserrat h-6 flex items-center">Informasi</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-600 transition-colors flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-gray-300"></div> Beranda</a></li>
                    <li><a href="{{ route('katalog.index') }}" class="text-gray-600 hover:text-brand-600 transition-colors flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-gray-300"></div> Katalog Produk</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-brand-600 transition-colors flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-gray-300"></div> Blog & Panduan</a></li>
                    <li><a href="{{ route('tentang-kami') }}" class="text-gray-600 hover:text-brand-600 transition-colors flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-gray-300"></div> Tentang Kami</a></li>
                    <li><a href="{{ route('kebijakan-garansi') }}" class="text-gray-600 hover:text-brand-600 transition-colors flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-gray-300"></div> Kebijakan Garansi</a></li>
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
