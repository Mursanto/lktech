<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bintang – Jual Beli Limbah Elektronik & Scrap PC/Laptop | LKTech Indonesia</title>
    <meta name="description" content="Bintang Scrap – Layanan jual beli limbah elektronik, scrap PC/Laptop, motherboard bekas, PCB, RAM, CPU rusak, casing server bekas dan baterai. Mitra resmi LKTech Indonesia, Tanah Sereal Bogor.">

    <!-- Open Graph -->
    <meta property="og:title" content="Bintang – Jual Beli Limbah Elektronik & Scrap PC/Laptop">
    <meta property="og:description" content="Layanan jual beli limbah elektronik terpercaya, mitra resmi LKTech Indonesia.">
    <meta property="og:type" content="website">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800;900&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">

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
                        sans:    ['Inter', 'sans-serif'],
                        outfit:  ['Outfit', 'sans-serif'],
                        montserrat: ['Montserrat', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }

        .hero-bintang {
            background: linear-gradient(135deg, #021a0e 0%, #064e3b 30%, #065f46 60%, #047857 85%, #0a3d2b 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bintang::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.025'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .circuit-line {
            position: absolute;
            background: linear-gradient(90deg, transparent, rgba(52,211,153,0.3), transparent);
            height: 1px;
        }
        .glow-emerald { box-shadow: 0 0 20px rgba(16,185,129,0.4), 0 4px 15px rgba(16,185,129,0.2); }
        .text-glow-emerald { text-shadow: 0 0 20px rgba(52,211,153,0.6); }
        .text-glow-amber { text-shadow: 0 0 12px rgba(251,191,36,0.7); }
        @keyframes pulseBadge { 0%,100% { transform: scale(1); } 50% { transform: scale(1.05); } }
        @keyframes floatUp { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-6px); } }
        .float-anim { animation: floatUp 4s ease-in-out infinite; }
        .waste-card { transition: all 0.25s cubic-bezier(0.4,0,0.2,1); }
        .waste-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(16,185,129,0.25); }
        .gallery-img-wrap { overflow: hidden; border-radius: 0.75rem; position: relative; }
        .gallery-img-wrap img { transition: transform 0.4s ease; width: 100%; height: 100%; object-fit: cover; }
        .gallery-img-wrap:hover img { transform: scale(1.07); }
        .gallery-img-wrap .overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(4,120,87,0.65) 0%, transparent 60%);
            opacity: 0; transition: opacity 0.3s ease;
            display: flex; align-items: flex-end; padding: 8px;
        }
        .gallery-img-wrap:hover .overlay { opacity: 1; }
        @keyframes ctaPulse { 0%,100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.5); } 50% { box-shadow: 0 0 0 10px rgba(34,197,94,0); } }
        .cta-pulse { animation: ctaPulse 2.5s ease-in-out infinite; }
        .divider-emerald { background: linear-gradient(90deg, transparent, #10b981, transparent); height: 2px; }
        .stat-card { background: linear-gradient(135deg, rgba(6,95,70,0.5), rgba(4,120,87,0.3)); border: 1px solid rgba(52,211,153,0.2); backdrop-filter: blur(8px); }
        .lightbox-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.92); z-index: 9999; display: flex; align-items: center; justify-content: center; }
        .lightbox-img { max-width: 90vw; max-height: 88vh; object-fit: contain; border-radius: 8px; box-shadow: 0 0 60px rgba(52,211,153,0.3); }
    </style>
</head>
<body class="bg-gray-950 text-white antialiased">

    @include('components.navbar')

    {{-- ── HERO SECTION ── --}}
    <section class="hero-bintang flex items-center py-3 lg:py-5 px-4 relative">
        <div class="circuit-line absolute top-[30%] left-0 right-0"></div>
        <div class="circuit-line absolute bottom-[25%] left-0 right-0" style="background: linear-gradient(90deg, transparent, rgba(251,191,36,0.2), transparent);"></div>
        <div class="absolute top-6 right-8 w-2 h-2 rounded-full bg-emerald-400 opacity-60" style="background:#34d399;"></div>
        <div class="absolute top-16 right-20 w-1.5 h-1.5 rounded-full bg-amber-400 opacity-50" style="background:#fbbf24;"></div>
        <div class="absolute bottom-10 left-10 w-2 h-2 rounded-full bg-emerald-300 opacity-40" style="background:#6ee7b7;"></div>

        <div class="max-w-6xl mx-auto w-full relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-6 lg:gap-10">

                {{-- LEFT: Text --}}
                <div class="flex-1 min-w-0 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 mb-2 px-3 py-0.5 rounded-full" style="background:rgba(6,78,59,0.5);border:1px solid rgba(52,211,153,0.4);">
                        <span class="w-1.5 h-1.5 rounded-full" style="background:#34d399;animation:pulseBadge 2s infinite;"></span>
                        <span class="text-[10px] font-semibold tracking-wide uppercase" style="color:#6ee7b7;">Layanan Mitra LKTech Indonesia</span>
                    </div>

                    <h1 class="font-outfit font-black text-xl sm:text-2xl lg:text-3xl leading-tight mb-2">
                        <span class="text-white">Bintang – </span><span class="text-emerald-400">Jual Beli Limbah</span><br>
                        <span class="text-emerald-400">Elektronik &amp; Scrap</span>
                        <span class="text-white font-bold"> PC/Laptop</span>
                    </h1>

                    <p class="text-xs sm:text-sm leading-relaxed mb-4 max-w-lg mx-auto lg:mx-0" style="color:#d1d5db;">
                        Kami menerima <strong style="color:#6ee7b7;">semua jenis limbah elektronik</strong> dan komponen PC/Laptop bekas.
                        Proses cepat, harga kompetitif, dan ramah lingkungan.
                    </p>

                    <div class="flex flex-row items-center justify-center lg:justify-start gap-2 flex-wrap">
                        <a href="https://wa.me/628567354046?text=Halo%20Bintang%2C%20saya%20ingin%20bertanya%20tentang%20layanan%20jual%20beli%20limbah%20elektronik"
                           target="_blank"
                           class="cta-pulse inline-flex items-center gap-1.5 font-bold text-xs px-4 py-2 rounded-lg transition-all duration-200 text-white whitespace-nowrap"
                           style="background:#10b981;">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Hubungi Mitra via WA
                        </a>
                        <a href="#gallery"
                           class="inline-flex items-center gap-1.5 font-semibold text-xs px-4 py-2 rounded-lg transition-all duration-200 text-white whitespace-nowrap"
                           style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Lihat Galeri
                        </a>
                    </div>
                </div>

                {{-- RIGHT: Custom SVG Logo --}}
                <div class="flex-shrink-0 float-anim hidden lg:block">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" class="w-20 h-20 lg:w-24 lg:h-24 drop-shadow-lg opacity-80">
                        <defs>
                            <linearGradient id="starGold" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#fbbf24;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#d97706;stop-opacity:1" />
                            </linearGradient>
                            <linearGradient id="circuitGreen" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#34d399;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#059669;stop-opacity:1" />
                            </linearGradient>
                            <filter id="starGlow">
                                <feGaussianBlur stdDeviation="3" result="coloredBlur"/>
                                <feMerge><feMergeNode in="coloredBlur"/><feMergeNode in="SourceGraphic"/></feMerge>
                            </filter>
                        </defs>
                        <!-- Outer dashed ring -->
                        <circle cx="100" cy="100" r="94" fill="none" stroke="url(#circuitGreen)" stroke-width="1.5" stroke-dasharray="8 4" opacity="0.5"/>
                        <circle cx="100" cy="100" r="84" fill="rgba(6,95,70,0.3)" stroke="url(#circuitGreen)" stroke-width="1"/>
                        <!-- Cardinal circuit lines -->
                        <line x1="100" y1="16" x2="100" y2="40" stroke="#34d399" stroke-width="2" opacity="0.7"/>
                        <line x1="184" y1="100" x2="160" y2="100" stroke="#34d399" stroke-width="2" opacity="0.7"/>
                        <line x1="100" y1="184" x2="100" y2="160" stroke="#34d399" stroke-width="2" opacity="0.7"/>
                        <line x1="16" y1="100" x2="40" y2="100" stroke="#34d399" stroke-width="2" opacity="0.7"/>
                        <!-- Circuit dots -->
                        <circle cx="100" cy="16" r="3" fill="#34d399"/>
                        <circle cx="184" cy="100" r="3" fill="#34d399"/>
                        <circle cx="100" cy="184" r="3" fill="#34d399"/>
                        <circle cx="16" cy="100" r="3" fill="#34d399"/>
                        <!-- Diagonal pad marks -->
                        <rect x="135" y="32" width="6" height="6" rx="1" fill="#fbbf24" opacity="0.7" transform="rotate(45,138,35)"/>
                        <rect x="158" y="135" width="6" height="6" rx="1" fill="#fbbf24" opacity="0.7" transform="rotate(45,161,138)"/>
                        <rect x="35" y="135" width="6" height="6" rx="1" fill="#fbbf24" opacity="0.7" transform="rotate(45,38,138)"/>
                        <rect x="35" y="55" width="6" height="6" rx="1" fill="#fbbf24" opacity="0.7" transform="rotate(45,38,58)"/>
                        <!-- 5-pointed Star -->
                        <polygon
                            points="100,48 110.9,79.4 143.9,79.4 118.5,97.5 129.4,128.9 100,110 70.6,128.9 81.5,97.5 56.1,79.4 89.1,79.4"
                            fill="url(#starGold)" filter="url(#starGlow)"
                            stroke="#fbbf24" stroke-width="1.5" stroke-linejoin="round"/>
                        <!-- Recycle arrows inside star -->
                        <path d="M100,75 A18,18 0 0,1 115.6,90" fill="none" stroke="#065f46" stroke-width="3" stroke-linecap="round"/>
                        <polygon points="118,86 116,94 110,90" fill="#065f46"/>
                        <path d="M115.6,110 A18,18 0 0,1 84.4,110" fill="none" stroke="#065f46" stroke-width="3" stroke-linecap="round"/>
                        <polygon points="81,114 83,106 89,110" fill="#065f46"/>
                        <path d="M84.4,90 A18,18 0 0,1 100,75" fill="none" stroke="#065f46" stroke-width="3" stroke-linecap="round"/>
                        <polygon points="97,71 103,75 97,79" fill="#065f46"/>
                        <!-- Center dot -->
                        <circle cx="100" cy="100" r="5" fill="#064e3b" stroke="#fbbf24" stroke-width="1.5"/>
                        <!-- IC/Chip below star -->
                        <rect x="85" y="138" width="30" height="20" rx="3" fill="none" stroke="#34d399" stroke-width="1.5" opacity="0.8"/>
                        <line x1="90" y1="138" x2="90" y2="133" stroke="#34d399" stroke-width="1.5"/>
                        <line x1="97" y1="138" x2="97" y2="133" stroke="#34d399" stroke-width="1.5"/>
                        <line x1="104" y1="138" x2="104" y2="133" stroke="#34d399" stroke-width="1.5"/>
                        <line x1="111" y1="138" x2="111" y2="133" stroke="#34d399" stroke-width="1.5"/>
                        <line x1="90" y1="158" x2="90" y2="163" stroke="#34d399" stroke-width="1.5"/>
                        <line x1="97" y1="158" x2="97" y2="163" stroke="#34d399" stroke-width="1.5"/>
                        <line x1="104" y1="158" x2="104" y2="163" stroke="#34d399" stroke-width="1.5"/>
                        <line x1="111" y1="158" x2="111" y2="163" stroke="#34d399" stroke-width="1.5"/>
                        <text x="100" y="152" text-anchor="middle" font-family="monospace" font-size="6" fill="#34d399" opacity="0.9">IC</text>
                    </svg>
                </div>
            </div>


        </div>
    </section>

    {{-- ── JENIS LIMBAH SECTION ── --}}
    <section class="py-7 px-4" style="background:#111827;">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-4">
                <span class="inline-block text-[10px] font-bold uppercase tracking-widest px-2.5 py-0.5 rounded-full mb-1.5" style="background:rgba(6,78,59,0.4);border:1px solid rgba(52,211,153,0.4);color:#34d399;">Kami Terima</span>
                <h2 class="font-outfit font-black text-xl sm:text-2xl text-white">Jenis Limbah <span style="color:#34d399;">yang Diterima</span></h2>
                <p class="text-xs mt-1" style="color:#9ca3af;">Semua komponen elektronik bekas, rusak, atau tidak terpakai kami beli dengan harga wajar.</p>
                <div class="divider-emerald max-w-xs mx-auto mt-3 rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 sm:gap-4">
                @php
                $wasteTypes = [
                    ['emoji'=>'🖥️','label'=>'Motherboard Bekas','desc'=>'Semua merk & generasi'],
                    ['emoji'=>'🔌','label'=>'PCB / Board','desc'=>'Printed Circuit Board'],
                    ['emoji'=>'💾','label'=>'RAM / CPU Rusak','desc'=>'DDR2, DDR3, DDR4, DDR5'],
                    ['emoji'=>'🖥', 'label'=>'Casing PC','desc'=>'ATX, mATX, SFF'],
                    ['emoji'=>'🖧', 'label'=>'Server Bekas','desc'=>'Rack & tower server'],
                    ['emoji'=>'🔋','label'=>'Baterai / Adaptor','desc'=>'Laptop & UPS baterai'],
                ];
                @endphp
                @foreach($wasteTypes as $waste)
                <div class="flex items-center gap-2 sm:gap-3 rounded-lg p-2 sm:p-3 cursor-default transition-colors duration-300 border border-slate-700/50 hover:border-emerald-500" style="background:rgba(31,41,55,0.4);">
                    <div class="text-2xl sm:text-3xl flex-shrink-0">{{ $waste['emoji'] }}</div>
                    <div class="min-w-0">
                        <div class="font-bold text-[11px] sm:text-sm text-white leading-tight mb-0.5 truncate">{{ $waste['label'] }}</div>
                        <div class="text-[9px] sm:text-xs text-slate-400 leading-tight truncate sm:whitespace-normal">{{ $waste['desc'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-3 rounded-xl p-3 flex flex-wrap sm:flex-nowrap items-center gap-3" style="background:rgba(6,78,59,0.3);border:1px solid rgba(52,211,153,0.4);">
                <div class="flex-shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="#34d399" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold mb-0.5" style="color:#6ee7b7;">Ada jenis limbah lain?</p>
                    <p class="text-xs" style="color:#9ca3af;">Hubungi kami terlebih dahulu untuk konfirmasi. Kami terbuka menerima berbagai jenis komponen elektronik bekas lainnya yang tidak tercantum di atas.</p>
                </div>
                <a href="https://wa.me/628567354046?text=Halo%20Bintang%2C%20saya%20ingin%20tanya%20apakah%20kalian%20menerima..."
                   target="_blank"
                   class="flex-shrink-0 text-white text-xs font-bold px-3 py-2 rounded-lg transition-colors whitespace-nowrap"
                   style="background:#059669;">
                    Tanya Dulu
                </a>
            </div>
        </div>
    </section>

    {{-- ── GALLERY SECTION ── --}}
    <section id="gallery" class="py-7 px-4" style="background:#030712;" x-data="{ lightboxOpen: false, lightboxSrc: '', lightboxCaption: '' }">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-4">
                <span class="inline-block text-[10px] font-bold uppercase tracking-widest px-2.5 py-0.5 rounded-full mb-1.5" style="background:rgba(120,53,15,0.4);border:1px solid rgba(245,158,11,0.4);color:#fbbf24;">Portfolio &amp; Galeri</span>
                <h2 class="font-outfit font-black text-xl sm:text-2xl text-white">Foto <span style="color:#fbbf24;">Limbah Kami</span></h2>
                <p class="text-xs mt-1" style="color:#9ca3af;">Dokumentasi nyata koleksi dan proses jual beli scrap elektronik Bintang.</p>
                <div class="divider-emerald max-w-xs mx-auto mt-3 rounded-full"></div>
            </div>

            {{--
                ======================================================
                GALLERY PHOTO MAPPING — Edit sesuai kebutuhan
                ======================================================
                Format: ['file' => 'nama-file.ext', 'caption' => 'Keterangan']
                Letakkan foto di: public/images/bintang/
                ======================================================
            --}}
            @php
            $galleryPhotos = [
                // wa_224614.jpeg (WA 22.46.14) & wa_224615_1.jpeg (WA 22.46.15 (1)) dihapus
                ['file' => 'scrap1.jfif',      'caption' => 'Koleksi Scrap Elektronik'],
                ['file' => 'scrap2.jfif',      'caption' => 'Koleksi Scrap Elektronik'],
                ['file' => 'scarp3.jfif',      'caption' => 'Komponen PCB Bekas'],
                ['file' => 'scrap4.jfif',      'caption' => 'Scrap Komponen'],
                ['file' => 'scrap5.jpg',       'caption' => 'Limbah Elektronik'],
                ['file' => 'scrap6.jpg',       'caption' => 'Limbah Elektronik'],
                ['file' => 'scrap7.jpg',       'caption' => 'Scrap PC/Laptop'],
                ['file' => 'scrap8.jpg',       'caption' => 'Scrap PC/Laptop'],
                ['file' => 'wa_224615.jpeg',   'caption' => 'Koleksi Limbah'],
                ['file' => 'wa_224615_3.jpeg', 'caption' => 'Koleksi Limbah'],
                ['file' => 'wa_224616.jpeg',   'caption' => 'Koleksi Limbah'],
                ['file' => 'wa_224616_1.jpeg', 'caption' => 'Koleksi Limbah'],
                ['file' => 'wa_224616_2.jpeg', 'caption' => 'Koleksi Limbah'],
                ['file' => 'wa_224616_3.jpeg', 'caption' => 'Koleksi Limbah'],
                ['file' => 'wa_224617.jpeg',   'caption' => 'Koleksi Limbah'],
                ['file' => 'wa_224617_1.jpeg', 'caption' => 'Koleksi Limbah'],
            ];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($galleryPhotos as $photo)
                <div class="gallery-img-wrap aspect-[4/3] cursor-pointer rounded-lg overflow-hidden group border border-slate-800" style="background:#1f2937;"
                     @click="lightboxOpen = true; lightboxSrc = '{{ asset('images/bintang/' . $photo['file']) }}'; lightboxCaption = '{{ $photo['caption'] }}'">
                    <img src="{{ asset('images/bintang/' . $photo['file']) }}"
                         alt="{{ $photo['caption'] }}"
                         loading="lazy"
                         class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105"
                         onerror="this.parentElement.style.display='none'">
                    <div class="overlay">
                        <span class="text-white text-xs font-semibold truncate">{{ $photo['caption'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Lightbox --}}
            <div x-show="lightboxOpen"
                 x-cloak
                 x-transition.opacity
                 class="lightbox-overlay"
                 @click.self="lightboxOpen = false"
                 @keydown.escape.window="lightboxOpen = false">
                <div class="relative flex flex-col items-center px-4">
                    <button @click="lightboxOpen = false"
                            class="absolute -top-8 right-0 text-3xl leading-none"
                            style="color:rgba(255,255,255,0.6);">&times;</button>
                    <img :src="lightboxSrc" :alt="lightboxCaption" class="lightbox-img">
                    <p class="text-sm mt-3 text-center" style="color:#d1d5db;" x-text="lightboxCaption"></p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CARA KERJA SECTION ── --}}
    <section class="py-7 px-4" style="background:#111827;">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-4">
                <span class="inline-block text-[10px] font-bold uppercase tracking-widest px-2.5 py-0.5 rounded-full mb-1.5" style="background:rgba(6,78,59,0.4);border:1px solid rgba(52,211,153,0.4);color:#34d399;">Proses Mudah</span>
                <h2 class="font-outfit font-black text-2xl text-white">Cara <span style="color:#34d399;">Jual Scrap</span> ke Bintang</h2>
                <div class="divider-emerald max-w-xs mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @php
                $steps = [
                    ['step'=>'01','icon'=>'bx-chat','title'=>'Hubungi via WA','desc'=>'Chat atau telepon nomor mitra Bintang. Jelaskan jenis dan jumlah scrap yang Anda miliki.'],
                    ['step'=>'02','icon'=>'bx-camera','title'=>'Kirim Foto','desc'=>'Foto komponen elektronik dan kirim via WhatsApp. Kami akan memberikan estimasi harga.'],
                    ['step'=>'03','icon'=>'bx-check-shield','title'=>'Deal & Pickup','desc'=>'Setuju harga? Kami atur jadwal pickup langsung ke lokasi Anda atau Anda antar ke tempat kami.'],
                ];
                @endphp
                @foreach($steps as $step)
                <div class="relative rounded-xl p-4 text-center" style="background:rgba(31,41,55,0.5);border:1px solid rgba(55,65,81,0.5);">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full mb-3" style="background:rgba(6,78,59,0.6);border:1px solid rgba(52,211,153,0.4);">
                        <i class="bx {{ $step['icon'] }} text-xl" style="color:#34d399;"></i>
                    </div>
                    <div class="absolute top-3 left-3 font-outfit font-black text-4xl leading-none select-none" style="color:rgba(107,114,128,0.4);">{{ $step['step'] }}</div>
                    <h3 class="font-bold text-sm text-white mb-1">{{ $step['title'] }}</h3>
                    <p class="text-xs leading-relaxed" style="color:#9ca3af;">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── CTA BOTTOM ── --}}
    <section class="hero-bintang py-6 sm:py-12 px-4 text-center relative overflow-hidden">
        <div class="circuit-line absolute top-[40%] left-0 right-0"></div>
        <div class="max-w-2xl mx-auto relative z-10">
            <div class="float-anim inline-block mb-3 sm:mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 sm:w-14 sm:h-14 mx-auto" viewBox="0 0 60 60">
                    <circle cx="30" cy="30" r="28" fill="rgba(6,95,70,0.5)" stroke="#10b981" stroke-width="1.5"/>
                    <path d="M30,12 A18,18 0 0,1 47.6,27" fill="none" stroke="#fbbf24" stroke-width="3" stroke-linecap="round"/>
                    <polygon points="50,23 49,31 43,27" fill="#fbbf24"/>
                    <path d="M47.6,33 A18,18 0 0,1 12.4,33" fill="none" stroke="#fbbf24" stroke-width="3" stroke-linecap="round"/>
                    <polygon points="9,37 10,29 16,33" fill="#fbbf24"/>
                    <path d="M12.4,27 A18,18 0 0,1 30,12" fill="none" stroke="#fbbf24" stroke-width="3" stroke-linecap="round"/>
                    <polygon points="27,8 33,12 27,16" fill="#fbbf24"/>
                </svg>
            </div>
            <h2 class="font-outfit font-black text-[17px] sm:text-3xl text-white mb-1 sm:mb-2 whitespace-nowrap">
                Siap Jual Limbah <span style="color:#fbbf24;">Elektronik Anda?</span>
            </h2>
            <p class="text-[11px] sm:text-sm mb-4 sm:mb-6 leading-tight" style="color:#d1d5db;">Dapatkan harga terbaik untuk scrap PC, laptop, & komponen elektronik bekas. Proses cepat, transparan, ramah lingkungan.</p>
            <a href="https://wa.me/628567354046?text=Halo%20Bintang%2C%20saya%20mau%20jual%20limbah%20elektronik%20saya"
               target="_blank"
               class="cta-pulse glow-emerald inline-flex items-center gap-1.5 sm:gap-2 text-white font-black text-sm sm:text-base px-5 py-2.5 sm:px-8 sm:py-4 rounded-xl sm:rounded-2xl transition-all duration-200"
               style="background:#10b981;">
                <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Hubungi Mitra via WhatsApp
            </a>
        </div>
    </section>

    @include('components.footer')

</body>
</html>
