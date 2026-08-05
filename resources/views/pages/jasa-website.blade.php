<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jasa Pembuatan Website - LKTech TN SEREAL</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        montserrat: ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Header -->

    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow w-full pb-20 md:pb-0">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-blue-50 via-cyan-50/70 to-emerald-50 py-10 px-4 sm:px-6 lg:px-8 text-center border-b border-cyan-100/70 w-full overflow-hidden"
             x-data="{
                words: ['Website Company Profile', 'Toko Online UMKM', 'Landing Page Sales', 'Website Profesional'],
                wordIndex: 0,
                displayed: '',
                isDeleting: false,
                charIndex: 0,
                typingSpeed: 80,
                deletingSpeed: 40,
                pauseMs: 1800,
                init() {
                    this.type();
                },
                type() {
                    const current = this.words[this.wordIndex];
                    if (!this.isDeleting) {
                        this.displayed = current.substring(0, this.charIndex + 1);
                        this.charIndex++;
                        if (this.charIndex === current.length) {
                            this.isDeleting = true;
                            setTimeout(() => this.type(), this.pauseMs);
                            return;
                        }
                    } else {
                        this.displayed = current.substring(0, this.charIndex - 1);
                        this.charIndex--;
                        if (this.charIndex === 0) {
                            this.isDeleting = false;
                            this.wordIndex = (this.wordIndex + 1) % this.words.length;
                        }
                    }
                    setTimeout(() => this.type(), this.isDeleting ? this.deletingSpeed : this.typingSpeed);
                }
             }">
            <!-- Decorative blobs -->
            <div class="absolute -top-10 -left-10 w-48 h-48 bg-blue-200/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-emerald-200/20 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Pill Badge -->
            <div class="inline-flex items-center gap-2 bg-blue-500/10 border border-blue-200/60 text-blue-600 text-[11px] font-semibold px-4 py-1.5 rounded-full mb-4 select-none">
                <span class="animate-pulse text-yellow-400 text-sm">✨</span>
                Solusi Web Profesional &amp; Terpercaya
            </div>

            <!-- Main Title with Typing Animation -->
            <h1 class="text-2xl md:text-3xl font-black font-montserrat text-blue-900 mb-2 tracking-tight leading-tight">
                Jasa Pembuatan
                <br class="sm:hidden">
                <!-- Dynamic typed word with gradient shimmer -->
                <span class="inline-flex items-center gap-0.5 whitespace-nowrap">
                    <span class="bg-gradient-to-r from-blue-600 via-indigo-500 to-cyan-500 bg-clip-text text-transparent"
                          style="background-size: 200% auto; animation: shimmer 3s linear infinite;"
                          x-text="displayed"></span>
                    <!-- Blinking cursor -->
                    <span class="inline-block w-0.5 h-[1em] bg-blue-600 ml-0.5 animate-pulse align-middle rounded-sm"></span>
                </span>
            </h1>

            <!-- Shimmer keyframes -->
            <style>
                @keyframes shimmer {
                    0%   { background-position: 0% center; }
                    100% { background-position: 200% center; }
                }
            </style>

            <!-- Subtitle -->
            <p class="text-gray-600 text-xs md:text-sm max-w-2xl mx-auto leading-relaxed mt-2">
                Tingkatkan kredibilitas bisnis Anda dengan website profesional yang tampil memukau di semua perangkat.
            </p>
        </div>

        <!-- Mengapa Memilih Kami (Features Grid) -->
        <div class="bg-white pt-6 pb-12 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Feature 1 -->
                    <div class="bg-gray-50 rounded-3xl p-5 border border-gray-100 hover:border-blue-200 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 ease-in-out group h-full w-full flex flex-col justify-start cursor-default">
                        <div class="flex items-center gap-3.5 mb-4">
                            <div class="w-12 h-12 shrink-0 bg-blue-100 group-hover:bg-blue-200/70 text-brand-600 rounded-2xl flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <i class='bx bx-devices'></i>
                            </div>
                            <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-blue-600 font-montserrat leading-snug transition-colors duration-300">Tampil Profesional di Semua Gawai</h3>
                        </div>
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Website Anda akan terlihat sempurna baik dilihat dari ponsel, tablet, maupun komputer, sehingga calon pelanggan tidak ragu bertransaksi.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="bg-gray-50 rounded-3xl p-5 border border-gray-100 hover:border-blue-200 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 ease-in-out group h-full w-full flex flex-col justify-start cursor-default">
                        <div class="flex items-center gap-3.5 mb-4">
                            <div class="w-12 h-12 shrink-0 bg-emerald-100 group-hover:bg-emerald-200/70 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <i class='bx bx-search-alt'></i>
                            </div>
                            <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-blue-600 font-montserrat leading-snug transition-colors duration-300">Mudah Ditemukan Pelanggan Baru</h3>
                        </div>
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Struktur website dirancang dan dioptimasi agar cepat terindeks di Google, membuat usaha Anda lebih mudah ditemukan calon pembeli.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="bg-gray-50 rounded-3xl p-5 border border-gray-100 hover:border-blue-200 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 ease-in-out group h-full w-full flex flex-col justify-start cursor-default">
                        <div class="flex items-center gap-3.5 mb-4">
                            <div class="w-12 h-12 shrink-0 bg-amber-100 group-hover:bg-amber-200/70 text-amber-600 rounded-2xl flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <i class='bx bx-globe'></i>
                            </div>
                            <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-blue-600 font-montserrat leading-snug transition-colors duration-300">Langsung Online Tanpa Ribet</h3>
                        </div>
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Kami mengurus semua aspek teknis mulai dari domain hingga hosting. Anda tinggal fokus menjalankan dan mengembangkan bisnis.</p>
                    </div>
                    <!-- Feature 4 -->
                    <div class="bg-gray-50 rounded-3xl p-5 border border-gray-100 hover:border-blue-200 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 ease-in-out group h-full w-full flex flex-col justify-start cursor-default">
                        <div class="flex items-center gap-3.5 mb-4">
                            <div class="w-12 h-12 shrink-0 bg-purple-100 group-hover:bg-purple-200/70 text-purple-600 rounded-2xl flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <i class='bx bx-support'></i>
                            </div>
                            <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-blue-600 font-montserrat leading-snug transition-colors duration-300">Kami Siap Bantu Kapan Pun</h3>
                        </div>
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Kami memberikan jaminan rasa tenang dengan dukungan teknis yang siap mendampingi Anda kapan saja jika ada kendala pasca rilis.</p>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .hide-scroll::-webkit-scrollbar { display: none; }
            .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
        <!-- Template Carousel Section -->
        <div class="bg-gradient-to-br from-blue-50 via-cyan-50/60 to-emerald-50 py-12 border-t border-cyan-100/60"
             x-data="{
                scrollNext() { 
                    let slider = this.$refs.slider;
                    slider.scrollBy({left: slider.offsetWidth * 0.8, behavior: 'smooth'});
                },
                scrollPrev() { 
                    let slider = this.$refs.slider;
                    slider.scrollBy({left: -slider.offsetWidth * 0.8, behavior: 'smooth'});
                }
             }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-8">
                    <span class="inline-block bg-brand-50 text-brand-600 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-brand-100 mb-3">Inspirasi Desain</span>
                    <h2 class="text-3xl font-black text-gray-900 font-montserrat mb-2 tracking-tight">Pilihan Contoh Template Website</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Beberapa contoh tampilan website yang pernah kami kerjakan. Desain bisa disesuaikan dengan kebutuhan dan identitas bisnis Anda.</p>
                </div>

                <!-- Carousel Wrapper -->
                <div class="relative group">
                    <!-- Prev Button -->
                    <button @click="scrollPrev()"
                        class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 -translate-x-5 z-20 w-11 h-11 rounded-full bg-white border border-gray-200 shadow-lg items-center justify-center text-gray-600 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-all opacity-0 group-hover:opacity-100">
                        <i class='bx bx-chevron-left text-2xl'></i>
                    </button>

                    <!-- Carousel Track -->
                    <div x-ref="slider" class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-6 pt-2 hide-scroll -mx-4 px-4 sm:mx-0 sm:px-0">

                            <!-- Card 1: UMKM -->
                            <div class="flex-none w-[85%] sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] snap-center sm:snap-start bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all overflow-hidden group/card">
                                <div class="relative overflow-hidden h-48 bg-orange-50">
                                    <img src="{{ asset('images/template_umkm.png') }}" alt="Template UMKM" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500">
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-orange-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">UMKM</span>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-base font-bold text-gray-900 font-montserrat mb-1">Template Bisnis UMKM</h3>
                                    <p class="text-xs text-gray-500 leading-relaxed mb-4">Cocok untuk usaha kuliner, fashion lokal, atau produk rumahan. Desain hangat yang membangun kepercayaan pelanggan.</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 flex-wrap">
                                            <span class="bg-orange-50 text-orange-600 text-[10px] font-bold px-2 py-0.5 rounded-full border border-orange-100">Starter</span>
                                            <span class="bg-gray-50 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded-full border border-gray-100">1 Halaman</span>
                                        </div>
                                        <a href="https://wa.me/628567354046?text=Halo%20LKTech,%20saya%20tertarik%20dengan%20Template%20UMKM." target="_blank" class="flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors">
                                            Lihat Demo <i class='bx bx-link-external text-base'></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Perusahaan -->
                            <div class="flex-none w-[85%] sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] snap-center sm:snap-start bg-white rounded-3xl border border-brand-100 shadow-sm hover:shadow-xl transition-all overflow-hidden group/card relative">
                                <div class="absolute top-0 right-0 bg-brand-600 text-white text-[10px] font-black px-4 py-1.5 rounded-bl-2xl uppercase tracking-widest z-10">Populer</div>
                                <div class="relative overflow-hidden h-48 bg-blue-50">
                                    <img src="{{ asset('images/template_company.png') }}" alt="Template Perusahaan" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500">
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-blue-700 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">Perusahaan</span>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-base font-bold text-gray-900 font-montserrat mb-1">Template Perusahaan / CV / PT</h3>
                                    <p class="text-xs text-gray-500 leading-relaxed mb-4">Tampilan formal dan profesional untuk perusahaan, kontraktor, atau jasa konsultan yang ingin terlihat kredibel.</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 flex-wrap">
                                            <span class="bg-brand-50 text-brand-600 text-[10px] font-bold px-2 py-0.5 rounded-full border border-brand-100">Profesional</span>
                                            <span class="bg-gray-50 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded-full border border-gray-100">Multi Halaman</span>
                                        </div>
                                        <a href="https://wa.me/628567354046?text=Halo%20LKTech,%20saya%20tertarik%20dengan%20Template%20Perusahaan." target="_blank" class="flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors">
                                            Lihat Demo <i class='bx bx-link-external text-base'></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Toko Online -->
                            <div class="flex-none w-[85%] sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] snap-center sm:snap-start bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all overflow-hidden group/card">
                                <div class="relative overflow-hidden h-48 bg-emerald-50">
                                    <img src="{{ asset('images/template_ecommerce.png') }}" alt="Template Toko Online" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500">
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-emerald-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">Toko Online</span>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-base font-bold text-gray-900 font-montserrat mb-1">Template Toko Online / E-Commerce</h3>
                                    <p class="text-xs text-gray-500 leading-relaxed mb-4">Platform jual beli mandiri dengan katalog produk, keranjang belanja, dan sistem pembayaran otomatis.</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 flex-wrap">
                                            <span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-100">E-Commerce</span>
                                            <span class="bg-gray-50 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded-full border border-gray-100">Full Fitur</span>
                                        </div>
                                        <a href="https://wa.me/628567354046?text=Halo%20LKTech,%20saya%20tertarik%20dengan%20Template%20Toko%20Online." target="_blank" class="flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors">
                                            Lihat Demo <i class='bx bx-link-external text-base'></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 4: Portofolio -->
                            <div class="flex-none w-[85%] sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] snap-center sm:snap-start bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all overflow-hidden group/card">
                                <div class="relative overflow-hidden h-48 bg-purple-50">
                                    <img src="{{ asset('images/template_portfolio.png') }}" alt="Template Portofolio" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500">
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-purple-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">Portofolio</span>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-base font-bold text-gray-900 font-montserrat mb-1">Template Portofolio / Jasa Kreatif</h3>
                                    <p class="text-xs text-gray-500 leading-relaxed mb-4">Ideal untuk fotografer, desainer, freelancer, atau agensi kreatif yang ingin pamerkan karya terbaik mereka.</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 flex-wrap">
                                            <span class="bg-purple-50 text-purple-600 text-[10px] font-bold px-2 py-0.5 rounded-full border border-purple-100">Kreatif</span>
                                            <span class="bg-gray-50 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded-full border border-gray-100">Galeri</span>
                                        </div>
                                        <a href="https://wa.me/628567354046?text=Halo%20LKTech,%20saya%20tertarik%20dengan%20Template%20Portofolio." target="_blank" class="flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors">
                                            Lihat Demo <i class='bx bx-link-external text-base'></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 5: Landing Page -->
                            <div class="flex-none w-[85%] sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] snap-center sm:snap-start bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all overflow-hidden group/card">
                                <div class="relative overflow-hidden h-48 bg-sky-50">
                                    <img src="{{ asset('images/template_landingpage.png') }}" alt="Template Landing Page" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500">
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-sky-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">Landing Page</span>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-base font-bold text-gray-900 font-montserrat mb-1">Template Landing Page Promosi</h3>
                                    <p class="text-xs text-gray-500 leading-relaxed mb-4">Dirancang untuk konversi tinggi. Cocok untuk promosi produk, event, atau layanan dengan satu halaman yang persuasif.</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 flex-wrap">
                                            <span class="bg-sky-50 text-sky-600 text-[10px] font-bold px-2 py-0.5 rounded-full border border-sky-100">Promosi</span>
                                            <span class="bg-gray-50 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded-full border border-gray-100">1 Halaman</span>
                                        </div>
                                        <a href="https://wa.me/628567354046?text=Halo%20LKTech,%20saya%20tertarik%20dengan%20Template%20Landing%20Page." target="_blank" class="flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors">
                                            Lihat Demo <i class='bx bx-link-external text-base'></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                    </div>

                    <!-- Next Button -->
                    <button @click="scrollNext()"
                        class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 translate-x-5 z-20 w-11 h-11 rounded-full bg-white border border-gray-200 shadow-lg items-center justify-center text-gray-600 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-all opacity-0 group-hover:opacity-100">
                        <i class='bx bx-chevron-right text-2xl'></i>
                    </button>
                </div>

                <!-- CTA -->
                <div class="text-center mt-8">
                    <p class="text-sm text-gray-500 mb-3">Tidak menemukan template yang cocok? Kami bisa membuat desain custom dari nol!</p>
                    <a href="https://wa.me/628567354046?text=Halo%20LKTech,%20saya%20ingin%20konsultasi%20desain%20website%20custom." target="_blank"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg text-sm">
                        <i class='bx bxl-whatsapp text-xl'></i> Konsultasi Desain Custom
                    </a>
                </div>
            </div>
        </div>

        <!-- Packages Grid -->
        <div id="paket" class="bg-gray-50 pt-10 pb-12 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-black text-gray-900 font-montserrat mb-3 tracking-tight">Pilihan Paket Harga</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Solusi tepat untuk segala skala bisnis. Harga transparan tanpa biaya tersembunyi.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                    
                    @forelse($packages as $package)
                    @php
                        $isHighlighted = !empty($package->badge);
                    @endphp
                    <!-- Card: {{ $package->nama_paket }} -->
                    <div class="bg-white rounded-3xl {{ $isHighlighted ? 'shadow-2xl border-2 border-brand-500 z-10 md:-translate-y-4 transform' : 'shadow-sm border border-gray-100 hover:shadow-xl' }} p-8 transition-all flex flex-col h-full relative group">
                        @if($isHighlighted)
                        <div class="absolute top-0 right-0 bg-brand-600 text-white text-[10px] font-black px-4 py-1.5 rounded-bl-2xl uppercase tracking-widest shadow-sm">
                            {{ $package->badge }}
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-b from-brand-50/50 to-transparent rounded-3xl pointer-events-none"></div>
                        @endif
                        
                        <div class="flex-grow relative z-10">
                            <h3 class="{{ $isHighlighted ? 'text-2xl font-bold text-brand-600' : 'text-xl font-bold text-gray-900' }} mb-1 font-montserrat">{{ $package->nama_paket }}</h3>
                            <p class="text-xs {{ $isHighlighted ? 'text-gray-500' : 'text-brand-600' }} font-bold uppercase tracking-wider mb-6">{{ $package->deskripsi_singkat ?? 'Paket Website' }}</p>
                            
                            <div class="mb-8">
                                <span class="{{ $isHighlighted ? 'text-2xl sm:text-3xl md:text-4xl' : 'text-xl sm:text-2xl md:text-3xl' }} font-black text-gray-900 whitespace-nowrap">Rp {{ number_format($package->harga_mulai, 0, ',', '.') }}</span>
                            </div>
                            
                            <ul class="space-y-4 mb-8 text-sm {{ $isHighlighted ? 'text-gray-700 font-semibold' : 'text-gray-600 font-medium' }}">
                                @if($package->fitur_list)
                                    @foreach(explode("\n", $package->fitur_list) as $fitur)
                                        @if(trim($fitur))
                                        <li class="flex items-start gap-3"><i class='bx {{ $isHighlighted ? 'bxs-check-circle text-brand-600' : 'bx-check-circle text-brand-500' }} text-xl'></i> <span>{{ trim($fitur) }}</span></li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="mt-auto pt-6 border-t {{ $isHighlighted ? 'border-brand-100' : 'border-gray-100' }} relative z-10">
                            @php
                                $waText = urlencode("Halo LKtech, saya ingin konsultasi mengenai Jasa Pembuatan Website (".$package->nama_paket.").");
                            @endphp
                            <a href="https://wa.me/628567354046?text={{ $waText }}" target="_blank" class="w-full block text-center {{ $isHighlighted ? 'px-6 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5' : 'px-6 py-3 bg-gray-50 hover:bg-gray-100 text-gray-800 font-bold rounded-xl transition-colors border border-gray-200' }}">
                                {{ $isHighlighted ? 'Pilih Paket Spesial' : 'Pilih Paket' }}
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-1 md:col-span-3 text-center py-12 text-gray-500">
                        <i class='bx bx-info-circle text-4xl mb-3 text-gray-400'></i>
                        <p>Paket Jasa Website belum tersedia saat ini. Silakan hubungi kami untuk informasi lebih lanjut.</p>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>

        <!-- Alur Kerja (Workflow) -->
        <div class="bg-white pt-10 pb-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNFMkU4RjAiLz48L3N2Zz4=')] opacity-50"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-8">
                    <span class="text-brand-600 font-bold tracking-wider uppercase text-[10px] mb-2 block bg-brand-50 inline-block px-3 py-1 rounded-full border border-brand-100">Step By Step</span>
                    <h2 class="text-3xl font-black text-gray-900 font-montserrat mb-3 tracking-tight">Alur Kerja Kami</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Proses yang terstruktur untuk memastikan hasil akhir yang memuaskan dan sesuai ekspektasi.</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3 md:gap-4 text-center relative">
                    <!-- Connecting Line for Desktop -->
                    <div class="hidden md:block absolute top-10 left-[10%] right-[10%] h-0.5 bg-gray-200 z-0"></div>

                    <!-- Step 1 -->
                    <div class="relative z-10 flex flex-col items-center text-center p-3 md:p-0 bg-white md:bg-transparent rounded-xl md:rounded-none shadow-sm md:shadow-none border md:border-none border-gray-100">
                        <div class="w-10 h-10 md:w-20 md:h-20 shrink-0 mx-auto bg-white border-4 border-brand-100 text-brand-600 rounded-full flex items-center justify-center text-lg md:text-3xl font-black shadow-sm mb-2 md:mb-4 group hover:bg-brand-600 hover:text-white transition-colors duration-300">
                            1
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-xs md:text-base leading-tight md:mb-2">Konsultasi</h4>
                            <p class="hidden md:block text-xs text-gray-500 px-2">Diskusi konsep, target audiens, dan fitur yang dibutuhkan.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative z-10 flex flex-col items-center text-center p-3 md:p-0 bg-white md:bg-transparent rounded-xl md:rounded-none shadow-sm md:shadow-none border md:border-none border-gray-100">
                        <div class="w-10 h-10 md:w-20 md:h-20 shrink-0 mx-auto bg-white border-4 border-brand-100 text-brand-600 rounded-full flex items-center justify-center text-lg md:text-3xl font-black shadow-sm mb-2 md:mb-4 group hover:bg-brand-600 hover:text-white transition-colors duration-300">
                            2
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-xs md:text-base leading-tight md:mb-2">Desain UI/UX</h4>
                            <p class="hidden md:block text-xs text-gray-500 px-2">Pembuatan mockup visual yang memukau dan mudah digunakan.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative z-10 flex flex-col items-center text-center p-3 md:p-0 bg-white md:bg-transparent rounded-xl md:rounded-none shadow-sm md:shadow-none border md:border-none border-gray-100">
                        <div class="w-10 h-10 md:w-20 md:h-20 shrink-0 mx-auto bg-white border-4 border-brand-100 text-brand-600 rounded-full flex items-center justify-center text-lg md:text-3xl font-black shadow-sm mb-2 md:mb-4 group hover:bg-brand-600 hover:text-white transition-colors duration-300">
                            3
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-xs md:text-base leading-tight md:mb-2">Development</h4>
                            <p class="hidden md:block text-xs text-gray-500 px-2">Proses coding yang rapi, optimasi kecepatan, dan keamanan.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative z-10 flex flex-col items-center text-center p-3 md:p-0 bg-white md:bg-transparent rounded-xl md:rounded-none shadow-sm md:shadow-none border md:border-none border-gray-100">
                        <div class="w-10 h-10 md:w-20 md:h-20 shrink-0 mx-auto bg-white border-4 border-brand-100 text-brand-600 rounded-full flex items-center justify-center text-lg md:text-3xl font-black shadow-sm mb-2 md:mb-4 group hover:bg-brand-600 hover:text-white transition-colors duration-300">
                            4
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-xs md:text-base leading-tight md:mb-2">Revisi</h4>
                            <p class="hidden md:block text-xs text-gray-500 px-2">Kami berikan kesempatan revisi agar hasil benar-benar sempurna.</p>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="relative z-10 flex flex-col items-center text-center p-3 md:p-0 bg-white md:bg-transparent rounded-xl md:rounded-none shadow-sm md:shadow-none border md:border-none border-gray-100 col-span-2 md:col-span-1">
                        <div class="w-10 h-10 md:w-20 md:h-20 shrink-0 mx-auto bg-emerald-500 border-4 border-emerald-100 text-white rounded-full flex items-center justify-center text-lg md:text-3xl font-black shadow-[0_0_20px_rgba(16,185,129,0.3)] mb-2 md:mb-4">
                            <i class='bx bx-check'></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-emerald-600 text-xs md:text-base leading-tight md:mb-2">Rilis & Panduan</h4>
                            <p class="hidden md:block text-xs text-gray-500 px-2">Website online! Anda akan dibekali panduan penggunaannya.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-brand-600 py-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-white rounded-full blur-[150px] opacity-10"></div>
            
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <h2 class="text-3xl md:text-5xl font-black text-white font-montserrat mb-6 tracking-tight leading-tight">Siap Membawa Bisnis Anda ke Level Selanjutnya?</h2>
                <p class="text-brand-100 text-lg mb-10 max-w-2xl mx-auto">
                    Jangan biarkan kompetitor mendahului Anda. Mari ciptakan website profesional yang meningkatkan kredibilitas dan penjualan hari ini juga!
                </p>
                <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20ingin%20konsultasi%20mengenai%20Jasa%20Pembuatan%20Website." target="_blank" class="inline-flex items-center gap-2 px-10 py-4 bg-white text-brand-600 hover:bg-gray-50 hover:text-brand-700 rounded-full font-black text-lg transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                    <i class='bx bxl-whatsapp text-2xl'></i> Hubungi Tim Kami Sekarang
                </a>
            </div>
        </div>
    </main>



    <!-- Footer -->
    <x-footer />

    <!-- Mobile Bottom Navigation -->
    <x-mobile-bottom-nav />

</body>
</html>
