<footer class="bg-white border-t border-gray-200 mt-auto pt-6 md:pt-10 pb-6 max-md:pb-24">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        @if(!in_array(Route::currentRouteName(), ['wifi-voucher', 'jasa-furniture', 'martabak-jawara']))
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8 mb-8 items-start">
            
            <!-- Kolom 1: Profil Singkat -->
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-1">
                    <img src="{{ asset('images/LKtech.png') }}" alt="LKTech Logo" class="h-7 sm:h-8 w-auto object-contain">
                    <span class="font-montserrat font-black text-[17px] sm:text-lg lg:text-xl tracking-tight text-blue-900 leading-none whitespace-nowrap">{{ $settings->nama_toko ?? 'LKTech TN SEREAL' }}</span>
                </a>
                <div class="text-[7.5px] sm:text-[8px] font-bold uppercase tracking-widest text-gray-400 mb-2 pl-9 sm:pl-10">
                    By Laras & Kenzi Technology
                </div>
                
                <!-- Google Maps Embed -->
                <div class="rounded-xl overflow-hidden shadow-sm w-full mt-4">
                    @if(isset($settings) && $settings->maps_iframe)
                        <div class="w-full h-40 md:h-48 [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0">
                            {!! $settings->maps_iframe !!}
                        </div>
                    @else
                        <iframe 
                            src="https://maps.google.com/maps?q=LKtech+TN+SEREAL,+Tanah+Sereal,+Bogor&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                            class="w-full h-40 md:h-48 border-0" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    @endif
                </div>
            </div>

            <!-- Kolom 2: Informasi Kontak & Sosial Media -->
            <div class="flex flex-col justify-start items-start space-y-4">
                <!-- HUBUNGI KAMI -->
                <div>
                    <h3 class="font-bold text-slate-900 text-base mb-3 font-montserrat flex items-center">Hubungi Kami</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <!-- Alamat -->
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-brand-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="leading-snug">
                                Villa Mutiara 1 Sektor 2 BLOK i-18<br>
                                No. 03 Tanah Sereal, Bogor 16168
                            </span>
                        </li>

                        <!-- Email -->
                        <li class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:sales@lktech.online" class="hover:text-brand-600 transition-colors">sales@lktech.online</a>
                        </li>

                        <!-- WhatsApp -->
                        <li class="flex items-center gap-2.5">
                            <i class='bx bxl-whatsapp text-[1.25rem] text-brand-500 shrink-0'></i>
                            <a href="https://wa.me/628567354046" target="_blank" class="hover:text-brand-600 transition-colors">+62 856-7354-046</a>
                        </li>

                        <!-- Jam Operasional -->
                        <li class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Senin - Sabtu: 09:00 - 17:00</span>
                        </li>
                    </ul>
                </div>

                <!-- IKUTI KAMI -->
                <div>
                    <h3 class="font-bold text-slate-900 text-base mb-3 font-montserrat flex items-center">Ikuti Kami</h3>
                    <div class="flex items-center gap-2">
                        <!-- Facebook -->
                        <a href="{{ $settings->facebook_url ?? 'https://www.facebook.com/marketplace/profile/1147601792/?ref=permalink&tab=listings&mibextid=dXMIcH' }}" target="_blank" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:-translate-y-1 hover:shadow-md transition-all duration-300" title="Facebook">
                            <i class='bx bxl-facebook text-lg text-[#1877F2]'></i>
                        </a>
                        <!-- Instagram -->
                        <a href="{{ $settings->instagram_url ?? '#' }}" target="_blank" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden group" title="Instagram">
                            <div class="absolute inset-0 bg-gradient-to-tr from-[#F58529] via-[#DD2A7B] to-[#8134AF] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class='bx bxl-instagram text-lg text-gray-700 group-hover:text-white relative z-10 transition-colors'></i>
                        </a>
                        <!-- LinkedIn -->
                        <a href="#" target="_blank" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:-translate-y-1 hover:shadow-md transition-all duration-300" title="LinkedIn">
                            <i class='bx bxl-linkedin text-lg text-[#0A66C2]'></i>
                        </a>
                        <!-- TikTok -->
                        <a href="{{ $settings->tiktok_url ?? '#' }}" target="_blank" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:-translate-y-1 hover:shadow-md transition-all duration-300" title="TikTok">
                            <i class='bx bxl-tiktok text-lg text-[#010101]'></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kolom 3: Metode Pembayaran & Sosial Media -->
            <div class="self-start w-full">
                <!-- Metode Pembayaran -->
                <h4 class="font-bold text-gray-800 mb-3 font-montserrat flex items-center max-md:text-[1.1rem]">Metode Pembayaran</h4>
                <div class="flex flex-wrap md:grid md:grid-cols-2 gap-2 mb-4">
                    
                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center justify-center tracking-tighter">
                        <span class="text-[#005E6A]">Livin'</span> <span class="text-[#FFB71B] ml-0.5">Mandiri</span>
                    </div>
                    
                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center justify-center tracking-tighter">
                        <span class="text-[#006677]">wondr</span> <span class="text-[9px] text-gray-400 mx-1 font-medium italic">by</span> <span class="text-[#F15A23]">BNI</span>
                    </div>
                    
                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center justify-center tracking-tighter italic">
                        <span class="text-[#4C2882]">OVO</span>
                    </div>
                    
                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center justify-center tracking-tighter">
                        <span class="text-[#00AED6]">GoPay</span>
                    </div>

                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center justify-center tracking-tighter">
                        <span class="text-[#108EE9]">DANA</span>
                    </div>

                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center justify-center tracking-tighter">
                        <span class="text-[#EE4D2D]">ShopeePay</span>
                    </div>

                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center justify-center tracking-tighter">
                        <span class="text-[#DF1921] italic">LinkAja</span>
                    </div>

                    <div class="px-2.5 py-1 bg-white border border-gray-200 shadow-sm rounded text-[11px] font-black flex items-center justify-center tracking-tighter italic">
                        <span class="text-[#ED1C24]">QR</span><span class="text-[#005B9F]">IS</span>
                    </div>
                </div>

                <!-- Tokopedia Cicilan / PayLater -->
                <a href="https://www.tokopedia.com/lktech-tn-sereal" target="_blank"
                   class="flex items-center gap-3 w-full bg-gradient-to-r from-green-500 to-emerald-500 text-white px-4 py-3 rounded-xl mt-4 md:mt-2 hover:from-green-600 hover:to-emerald-600 transition-all shadow-md group">
                    <i class='bx bx-store text-2xl shrink-0'></i>
                    <div class="flex flex-col leading-tight">
                        <span class="text-xs sm:text-[13px] font-bold">Tokopedia - Cicilan & Paylater</span>
                        <span class="text-[10px] sm:text-[11px] font-medium text-emerald-100 flex items-center gap-1 mt-0.5">Tersedia disini <i class='bx bx-pointer text-xs'></i></span>
                    </div>
                </a>


            </div>

            <!-- Kolom 4 & 5: Informasi & Mitra -->
            <div class="hidden md:flex w-full justify-between gap-2 self-start">
                
                <!-- Tautan Berguna -->
                <div>
                    <h3 class="font-bold text-slate-900 text-base mb-3 font-montserrat flex items-center">Informasi</h3>
                    <ul class="space-y-2 text-sm text-slate-600 list-none">
                        <li><a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors flex items-center gap-1.5">Beranda</a></li>
                        <li><a href="{{ route('katalog.index') }}" class="hover:text-blue-600 transition-colors flex items-center gap-1.5">Katalog Produk</a></li>
                        <li><a href="{{ route('rakit-pc') }}" class="hover:text-blue-600 transition-colors flex items-center gap-1.5">Rakit PC</a></li>
                        <li><a href="{{ route('jasa-website') }}" class="hover:text-blue-600 transition-colors flex items-center gap-1.5">Jasa Website</a></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-blue-600 transition-colors flex items-center gap-1.5">Blog & Panduan</a></li>
                        <li><a href="{{ route('tentang-kami') }}" class="hover:text-blue-600 transition-colors flex items-center gap-1.5">Tentang Kami</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-blue-600 transition-colors flex items-center gap-1.5">FAQ & Bantuan</a></li>
                        <li>
                            <a href="https://www.tokopedia.com/lktech-tn-sereal" target="_blank"
                               class="hover:text-blue-600 transition-colors flex items-center gap-1.5">
                                Toko Tokopedia
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Support by Mitra -->
                <div class="shrink-0 w-20 lg:w-24">
                    <h3 class="font-bold text-slate-900 text-base mb-3 font-montserrat flex items-center justify-center">Mitra</h3>
                    <div class="flex flex-col gap-2">
                        <!-- Kopkarsat -->
                        <div class="flex items-center justify-center h-10 hover:opacity-80 transition-opacity">
                            <img src="{{ asset('images/kopkarsat.jpg') }}" alt="KOPKARSAT" class="max-h-8 max-w-[80px] object-contain mix-blend-multiply">
                        </div>
                        <!-- Martabak Jawara -->
                        <div class="flex items-center justify-center h-10 hover:opacity-80 transition-opacity">
                            <img src="{{ asset('images/martabak-jawara/Logo-Martabak-Jawara.webp') }}" alt="Martabak Jawara" class="max-h-8 max-w-[80px] object-contain mix-blend-multiply">
                        </div>
                        <!-- Furniture -->
                        <div class="flex items-center justify-center h-10 hover:opacity-80 transition-opacity">
                            <img src="{{ asset('images/logo-furniture.png') }}" alt="Furniture" class="max-h-8 max-w-[80px] object-contain mix-blend-multiply">
                        </div>
                        <!-- Limbah Elektronik Bintang -->
                        <div class="flex items-center justify-center h-10 hover:opacity-80 transition-opacity">
                            <img src="{{ asset('images/logo-bintang-v2.png') }}" alt="Limbah Elektronik Bintang" class="max-h-8 max-w-[80px] object-contain mix-blend-multiply">
                        </div>
                    </div>
                </div>

            </div>

        </div>
        @endif

        <div class="border-t border-gray-100 pt-5 mt-2 flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
            <div class="flex flex-col text-center md:text-left">
                <p class="text-[13px] font-medium text-gray-500">&copy; 2025 LKTech Solusi IT Integrated. All rights reserved.</p>
                <p class="text-[13px] text-gray-500">Hardware Andal. Software Profesional. Satu Integrasi.</p>
            </div>
            <div class="flex items-center gap-3 text-[13px] text-gray-500 font-medium">
                <a href="{{ route('faq') }}#kebijakan-privasi" class="hover:text-brand-600 transition-colors">Kebijakan Privasi</a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('faq') }}#syarat-ketentuan" class="hover:text-brand-600 transition-colors">Syarat &amp; Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
