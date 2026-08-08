<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Martabak Jawara – Muara Enim | Menu & Pesan Antar</title>
    <meta name="description" content="Martabak Jawara Muara Enim – Martabak premium dengan berbagai varian rasa. Tersedia di GrabFood & ShopeeFood. Jam buka 14.00–22.00. Pesan antar area Muara Enim & sekitarnya. Hubungi 0856-6492-8097.">

    <!-- Open Graph -->
    <meta property="og:title" content="Martabak Jawara – Menu & Pesan Antar Muara Enim">
    <meta property="og:description" content="Martabak premium berbagai varian rasa, tersedia di GrabFood & ShopeeFood. Buka 14.00–22.00 WIB.">
    <meta property="og:image" content="{{ asset('images/martabak-jawara/Logo-Martabak-Jawara.webp') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=Dancing+Script:wght@700;800&display=swap" rel="stylesheet">

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
                        playfair: ['"Playfair Display"', 'serif'],
                        dancing: ['"Dancing Script"', 'cursive'],
                    },
                    colors: {
                        gold: {
                            50: '#fffbeb', 100: '#fef3c7', 200: '#fde68a',
                            300: '#fcd34d', 400: '#fbbf24', 500: '#f59e0b',
                            600: '#d97706', 700: '#b45309', 800: '#92400e', 900: '#78350f',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* ── Hero ── */
        .hero-martabak {
            background: linear-gradient(135deg, #1a0a00 0%, #3b1800 30%, #5c2c00 60%, #7a3d00 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-martabak::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Shimmer for text */
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }
        .badge-shimmer {
            background: linear-gradient(90deg, #f59e0b, #fef3c7, #d97706, #fef3c7, #f59e0b);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }

        /* Floating animation for logo */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-8px); }
        }
        .logo-float { animation: float 3s ease-in-out infinite; }

        /* ── Gallery ── */
        .gallery-grid { columns: 1; column-gap: 1rem; }
        @media (min-width: 640px)  { .gallery-grid { columns: 2; } }
        @media (min-width: 1024px) { .gallery-grid { columns: 3; } }

        .gallery-item {
            break-inside: avoid;
            margin-bottom: 1rem;
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
        }
        .gallery-item img {
            width: 100%; display: block;
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .gallery-item:hover img { transform: scale(1.06); }
        .gallery-item .overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(26,10,0,0.88) 0%, transparent 55%);
            opacity: 0; transition: opacity 0.35s ease;
            display: flex; align-items: flex-end; padding: 1.25rem;
        }
        .gallery-item:hover .overlay { opacity: 1; }

        /* Tab buttons */
        .tab-btn {
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.8125rem;
            transition: all 0.25s ease;
            border: 2px solid #d97706;
            color: #b45309;
            background: white;
            cursor: pointer;
            white-space: nowrap;
        }
        .tab-btn.active, .tab-btn:hover {
            background: #b45309;
            color: white;
            border-color: #b45309;
            box-shadow: 0 4px 14px rgba(180,83,9,0.35);
        }



        /* CTA gradient */
        .cta-martabak {
            background: linear-gradient(135deg, #3b1800 0%, #7a3d00 50%, #b45309 100%);
        }

        /* Social icon buttons */
        .social-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px; height: 48px;
            border-radius: 50%;
            font-size: 1.5rem;
            transition: all 0.25s ease;
            text-decoration: none;
        }
        .social-btn:hover { transform: translateY(-3px) scale(1.1); }

        /* Pulse badge */
        @keyframes pulse-gold {
            0%, 100% { box-shadow: 0 0 0 0 rgba(245,158,11,0.5); }
            70%       { box-shadow: 0 0 0 10px rgba(245,158,11,0); }
        }
        .pulse-gold { animation: pulse-gold 2s infinite; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up   { animation: fadeUp 0.65s ease both; }
        .delay-1   { animation-delay: 0.1s; }
        .delay-2   { animation-delay: 0.2s; }
        .delay-3   { animation-delay: 0.3s; }
        .delay-4   { animation-delay: 0.4s; }

        [x-cloak] { display: none !important; }

        /* Delivery banner */
        .delivery-banner {
            background: linear-gradient(90deg, #065f46, #047857, #065f46);
            background-size: 200% 100%;
            animation: shimmerBg 3s linear infinite;
        }
        @keyframes shimmerBg {
            0%   { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        /* Grab / Shopee order buttons */
        .grab-btn  { background: linear-gradient(135deg, #00b14f, #00a847); }
        .shopee-btn { background: linear-gradient(135deg, #ee4d2d, #d63b1c); }

        /* Scrolling ticker */
        @keyframes ticker {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .ticker-inner { animation: ticker 18s linear infinite; white-space: nowrap; }
        .ticker-inner:hover { animation-play-state: paused; }
    </style>
</head>
<body class="bg-amber-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <x-navbar />

    <main class="flex-grow w-full pb-20 md:pb-0">

        {{-- ─── HERO ─── --}}
        <section class="hero-martabak min-h-[72vh] md:min-h-[80vh] flex items-center relative">
            {{-- Decorative blobs --}}
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-[130px] opacity-20" style="background:#f59e0b;"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full blur-[100px] opacity-15" style="background:#d97706;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full blur-[200px] opacity-5" style="background:#fbbf24;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-20 pb-8 md:pb-12 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    {{-- Text Content --}}
                    <div>
                        <div class="inline-flex flex-wrap items-center gap-2 px-3.5 py-1.5 rounded-full border border-white/20 bg-white/10 backdrop-blur-sm mb-4 fade-up text-xs font-medium text-amber-200">
                            <span class="flex items-center gap-1"><i class='bx bx-map text-amber-400 text-sm'></i> Muara Enim</span>
                            <span class="text-white/30">•</span>
                            <span class="flex items-center gap-1"><i class='bx bx-time-five text-amber-400 text-sm'></i> Buka 14.00 – 22.00 WIB</span>
                        </div>

                        <h1 class="text-3xl md:text-5xl font-black font-montserrat text-white leading-tight mb-3 tracking-tight fade-up delay-1">
                            Martabak <span class="badge-shimmer">Jawara</span>
                        </h1>

                        <p class="text-white/90 text-sm leading-relaxed mb-6 fade-up delay-2 max-w-xl">
                            Martabak Jawara hadir dengan 3 senjata pamungkas: Manis, Pizza, dan Tipker. Dibuat fresh setiap hari dari bahan pilihan, teksturnya dijamin lembut serta tipker yang crunchy bikin nagih.
                            <br class="hidden md:inline">
                            <span class="font-bold text-amber-300">Satu gigitan, langsung kecanduan. Siap buktikan?</span>
                        </p>

                        {{-- Unified Order Hub --}}
                        <div class="grid grid-cols-2 gap-3 max-w-md mb-6 fade-up delay-3">
                            <a href="https://wa.me/6285664928097?text=Halo%20Martabak%20Jawara%2C%20saya%20ingin%20pesan%20martabak." target="_blank"
                               class="flex items-center justify-center gap-2 py-3 px-4 bg-green-500 hover:bg-green-400 text-white font-bold rounded-xl transition-all shadow-md text-xs sm:text-sm">
                                <i class='bx bxl-whatsapp text-lg'></i> WhatsApp
                            </a>
                            <a href="https://r.grab.com/g/2-1-6-C6XJJJVCLA4YAA" target="_blank"
                               class="flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl transition-all shadow-md text-xs sm:text-sm">
                                <i class='bx bx-car text-lg'></i> GrabFood
                            </a>
                            <a href="https://shopee.co.id/universal-link/now-food/shop/22505814?deep_and_deferred=1&shareChannel=whatsapp" target="_blank"
                               class="flex items-center justify-center gap-2 py-3 px-4 bg-orange-600 hover:bg-orange-500 text-white font-bold rounded-xl transition-all shadow-md text-xs sm:text-sm">
                                <i class='bx bx-shopping-bag text-lg'></i> ShopeeFood
                            </a>
                            <a href="https://wa.me/6285664928097?text=Halo%20Martabak%20Jawara%2C%20saya%20mau%20pesan%20antar%20ke%20alamat%20saya." target="_blank"
                               class="flex items-center justify-center gap-2 py-3 px-4 bg-amber-500 hover:bg-amber-400 text-amber-950 font-bold rounded-xl transition-all shadow-md text-xs sm:text-sm">
                                <i class='bx bx-cycling text-lg'></i> Pesan Antar
                            </a>
                        </div>

                        <div class="fade-up delay-4 mb-4 flex items-center gap-2">
                            <a href="#menu" class="text-amber-300 hover:text-amber-200 text-xs font-semibold flex items-center gap-1">
                                <i class='bx bx-down-arrow-alt animate-bounce text-sm'></i> Lihat Menu Spesial Kami
                            </a>
                        </div>
                    </div>

                    {{-- Logo --}}
                    <div class="hidden lg:flex items-center justify-center fade-up delay-4">
                        <div class="relative logo-float">
                            <div class="w-64 h-64 xl:w-80 xl:h-80 rounded-full overflow-hidden border-4 border-amber-400/30 shadow-2xl" style="box-shadow: 0 0 60px rgba(245,158,11,0.3), 0 30px 80px rgba(0,0,0,0.5);">
                                <img src="{{ asset('images/martabak-jawara/Logo-Martabak-Jawara.webp') }}"
                                     alt="Logo Martabak Jawara"
                                     class="w-full h-full object-cover">
                            </div>
                            {{-- Orbiting badge --}}
                            <div class="absolute -top-3 -right-3 bg-amber-400 text-amber-900 text-xs font-black px-3 py-1.5 rounded-full shadow-lg rotate-12">
                                ⭐ Rasa Juara!
                            </div>
                            <div class="absolute -bottom-3 -left-3 bg-green-500 text-white text-xs font-black px-3 py-1.5 rounded-full shadow-lg -rotate-6">
                                🛵 Pesan Antar
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Wave --}}
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 60L60 50C120 40 240 20 360 15C480 10 600 20 720 28C840 36 960 40 1080 38C1200 36 1320 28 1380 24L1440 20V60H0Z" fill="#fffbeb"/>
                </svg>
            </div>
        </section>

        {{-- ─── SCROLLING TICKER ─── --}}
        <div class="bg-amber-500 py-2.5 overflow-hidden">
            <div class="ticker-inner inline-block">
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🍫 Martabak Black Forest</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🧀 Original Keju Berlimpah</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🍕 Pizza Basic & Ultimate</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">✨ Tipker Chocomalltine</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🥜 Kacang Wijen</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🍪 Original Oreo</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🌰 Almond Keju Kacang</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🛵 Pesan Antar Area Muara Enim</span>
                {{-- duplicate for seamless loop --}}
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🍫 Martabak Black Forest</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🧀 Original Keju Berlimpah</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🍕 Pizza Basic & Ultimate</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">✨ Tipker Chocomalltine</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🥜 Kacang Wijen</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🍪 Original Oreo</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🌰 Almond Keju Kacang</span>
                <span class="text-amber-900 font-bold text-sm tracking-wide mx-8">🛵 Pesan Antar Area Muara Enim</span>
            </div>
        </div>

        {{-- ─── INFO STRIP ─── --}}
        <section class="bg-amber-50 py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-amber-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 text-2xl shrink-0"><i class='bx bxs-cake'></i></div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm leading-tight">15+ Varian</p>
                            <p class="text-xs text-gray-500">Menu Premium</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-amber-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center text-green-600 text-2xl shrink-0"><i class='bx bx-cycling'></i></div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm leading-tight">Pesan Antar</p>
                            <p class="text-xs text-gray-500">Area Muara Enim</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-amber-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 text-2xl shrink-0"><i class='bx bx-time-five'></i></div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm leading-tight">14.00 – 22.00</p>
                            <p class="text-xs text-gray-500">Buka Setiap Hari</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-amber-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 text-2xl shrink-0"><i class='bx bxs-star'></i></div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm leading-tight">Freshly Made</p>
                            <p class="text-xs text-gray-500">Setiap Hari</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        {{-- ─── MENU / GALLERY ─── --}}
        <section id="menu" class="bg-amber-50 py-16"
            x-data="{
                activeTab: 'all',
                lightbox: false,
                lightboxSrc: '',
                lightboxTitle: '',
                lightboxDesc: '',
                lightboxPrice: '',
                openLightbox(src, title, desc, price) {
                    this.lightboxSrc = src;
                    this.lightboxTitle = title;
                    this.lightboxDesc = desc;
                    this.lightboxPrice = price;
                    this.lightbox = true;
                    document.body.style.overflow = 'hidden';
                },
                closeLightbox() {
                    this.lightbox = false;
                    document.body.style.overflow = '';
                }
            }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-2 bg-amber-100 px-3 py-1 rounded-full border border-amber-200">Menu Spesial Kami</span>
                    <h2 class="font-montserrat text-2xl md:text-3xl font-black text-gray-900 mb-2 tracking-tight">Pilihan Menu Martabak</h2>
                    <p class="text-gray-500 text-xs sm:text-sm max-w-xl mx-auto">Tap foto menu untuk melihat detail, deskripsi, harga, dan melakukan pemesanan.</p>
                </div>

                {{-- Filter Tabs --}}
                <div class="flex flex-wrap justify-center gap-2 mb-8">
                    <button @click="activeTab='all'"        :class="activeTab==='all'        ? 'active' : ''" class="tab-btn py-1.5 px-4 text-xs">Semua</button>
                    <button @click="activeTab='original'"   :class="activeTab==='original'   ? 'active' : ''" class="tab-btn py-1.5 px-4 text-xs">Original</button>
                    <button @click="activeTab='blackforest'" :class="activeTab==='blackforest' ? 'active' : ''" class="tab-btn py-1.5 px-4 text-xs">Black Forest</button>
                    <button @click="activeTab='tipker'"     :class="activeTab==='tipker'     ? 'active' : ''" class="tab-btn py-1.5 px-4 text-xs">Tipker</button>
                    <button @click="activeTab='pizza'"      :class="activeTab==='pizza'      ? 'active' : ''" class="tab-btn py-1.5 px-4 text-xs">Pizza</button>
                </div>

                {{-- Grid Gallery --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @php
                    $menus = [
                        /* Original */
                        ['src'=>'images/martabak-jawara/Martabak -Keju-Berlimpah.webp',                   'alt'=>'Martabak Original Keju Berlimpah',           'tag'=>'original',    'label'=>'Original', 'price'=>'Rp 28.000', 'desc'=>'Keju kraft berlimpah dipadu susu kental manis dan mentega premium.'],
                        ['src'=>'images/martabak-jawara/Martabak Original Choco Cruncy.webp',             'alt'=>'Martabak Original Choco Crunchy',            'tag'=>'original',    'label'=>'Original', 'price'=>'Rp 26.000', 'desc'=>'Cokelat crunchy yang renyah dan lumer di setiap gigitan.'],
                        ['src'=>'images/martabak-jawara/Martabak Original Oreo.webp',                     'alt'=>'Martabak Original Oreo',                     'tag'=>'original',    'label'=>'Original', 'price'=>'Rp 25.000', 'desc'=>'Taburan biskuit Oreo premium yang melimpah dan krim susu manis.'],
                        ['src'=>'images/martabak-jawara/Martabak Kacang Keju Meses.webp',                 'alt'=>'Martabak Kacang Keju Meses',                 'tag'=>'original',    'label'=>'Original', 'price'=>'Rp 27.000', 'desc'=>'Kombinasi klasik kacang tanah sangrai, keju parut gurih, dan meses cokelat.'],
                        ['src'=>'images/martabak-jawara/Martabak-Almond- Keju-Kacang.webp',               'alt'=>'Martabak Almond Keju Kacang',                'tag'=>'original',    'label'=>'Original', 'price'=>'Rp 30.000', 'desc'=>'Topping irisan almond panggang renyah berpadu keju gurih dan kacang tanah.'],
                        /* Black Forest */
                        ['src'=>'images/martabak-jawara/Martabak Black Forest - Almond - Keju - Meses.webp','alt'=>'Martabak Black Forest Almond Keju Meses',  'tag'=>'blackforest', 'label'=>'Black Forest', 'price'=>'Rp 32.000', 'desc'=>'Adonan khas Black Forest dengan topping kacang almond premium, keju, dan meses.'],
                        ['src'=>'images/martabak-jawara/Martabak Black Forest Ketan Keju.webp',           'alt'=>'Martabak Black Forest Ketan Keju',           'tag'=>'blackforest', 'label'=>'Black Forest', 'price'=>'Rp 30.000', 'desc'=>'Kombinasi lembut ketan hitam manis pilihan dengan parutan keju melimpah.'],
                        ['src'=>'images/martabak-jawara/Martabak Black Forest Meses.webp',                'alt'=>'Martabak Black Forest Meses',                'tag'=>'blackforest', 'label'=>'Black Forest', 'price'=>'Rp 28.000', 'desc'=>'Adonan Black Forest premium beraroma cokelat dipadu taburan meses melimpah.'],
                        /* Tipker */
                        ['src'=>'images/martabak-jawara/Martabak Tipker Chocomalltine.webp',              'alt'=>'Martabak Tipker Chocomaltine',               'tag'=>'tipker',      'label'=>'Tipker', 'price'=>'Rp 22.000', 'desc'=>'Martabak tipis kering yang super renyah dengan olesan Chocomaltine premium.'],
                        ['src'=>'images/martabak-jawara/Martabak Tipker Kacang Wijen.webp',               'alt'=>'Martabak Tipker Kacang Wijen',               'tag'=>'tipker',      'label'=>'Tipker', 'price'=>'Rp 18.000', 'desc'=>'Tipker renyah dengan taburan kacang tanah sangrai dan wijen sangrai yang harum.'],
                        ['src'=>'images/martabak-jawara/Martabak Tipker-Kacang-Wijen.webp',               'alt'=>'Martabak Tipker Kacang Wijen Premium',       'tag'=>'tipker',      'label'=>'Tipker', 'price'=>'Rp 20.000', 'desc'=>'Tipker kacang wijen ekstra mentega premium menghasilkan rasa lebih gurih.'],
                        ['src'=>'images/martabak-jawara/Martabak-Tipker-Kacang.webp',                     'alt'=>'Martabak Tipker Kacang',                     'tag'=>'tipker',      'label'=>'Tipker', 'price'=>'Rp 18.000', 'desc'=>'Tipker super tipis dan garing dengan taburan kacang tanah gurih.'],
                        /* Pizza */
                        ['src'=>'images/martabak-jawara/Martabak Pizza - Basic.webp',                     'alt'=>'Martabak Pizza Basic',                       'tag'=>'pizza',       'label'=>'Pizza', 'price'=>'Rp 35.000', 'desc'=>'Martabak manis dibentuk pizza dengan 4-8 pilihan topping standar favorit.'],
                        ['src'=>'images/martabak-jawara/Martabak Pizza Ulitimate.webp',                   'alt'=>'Martabak Pizza Ultimate',                    'tag'=>'pizza',       'label'=>'Pizza', 'price'=>'Rp 45.000', 'desc'=>'Martabak pizza mewah dengan kombinasi topping premium terlengkap dan melimpah.'],
                        ['src'=>'images/martabak-jawara/Martabak-Pizza-Pro.webp',                         'alt'=>'Martabak Pizza Pro',                         'tag'=>'pizza',       'label'=>'Pizza', 'price'=>'Rp 40.000', 'desc'=>'Pilihan rasa kekinian pro yang cocok dinikmati bersama teman atau keluarga.'],
                    ];
                    @endphp

                    @foreach($menus as $item)
                    <div class="relative overflow-hidden rounded-2xl cursor-pointer aspect-square group shadow-sm hover:shadow-md transition-all duration-300"
                         x-show="activeTab==='all' || activeTab==='{{ $item['tag'] }}'"
                         @click="openLightbox('{{ asset($item['src']) }}', '{{ $item['alt'] }}', '{{ $item['desc'] }}', '{{ $item['price'] }}')"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100">
                        <img src="{{ asset($item['src']) }}" alt="{{ $item['alt'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-3">
                            <p class="text-white font-bold text-xs sm:text-sm leading-snug line-clamp-2">{{ $item['alt'] }}</p>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-amber-400 font-extrabold text-[10px] sm:text-xs">{{ $item['price'] }}</span>
                                <span class="text-white/60 text-[9px] sm:text-[10px] bg-white/10 px-1.5 py-0.5 rounded">{{ $item['label'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Lightbox Modal --}}
            <div x-show="lightbox" class="fixed inset-0 bg-black/90 z-[9999] flex items-center justify-center p-4 overflow-y-auto" @click.self="closeLightbox()" @keydown.escape.window="closeLightbox()" x-cloak>
                <div class="relative bg-amber-950/95 border border-amber-900/50 rounded-3xl overflow-hidden max-w-sm w-full shadow-2xl flex flex-col scale-100 transition-all duration-300 my-auto max-h-[90vh]">
                    <div class="relative aspect-square w-full shrink-0">
                        <img :src="lightboxSrc" :alt="lightboxTitle" class="w-full h-full object-cover">
                        <button @click="closeLightbox()" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-black/60 hover:bg-black/80 flex items-center justify-center text-white transition-all shadow-md z-10">
                            <i class='bx bx-x text-2xl'></i>
                        </button>
                    </div>
                    <div class="p-5 flex-grow overflow-y-auto">
                        <span class="text-amber-400 font-extrabold text-base block mb-1" x-text="lightboxPrice"></span>
                        <h3 class="text-white font-black text-lg mb-2 font-montserrat" x-text="lightboxTitle"></h3>
                        <p class="text-amber-100/70 text-xs sm:text-sm leading-relaxed mb-5" x-text="lightboxDesc"></p>

                        <a :href="'https://wa.me/6285664928097?text=Halo%20Martabak%20Jawara%2C%20saya%20mau%20pesan%20' + encodeURIComponent(lightboxTitle) + '.'" target="_blank"
                           class="flex items-center justify-center gap-2 w-full py-3 bg-green-500 hover:bg-green-400 text-white font-bold rounded-xl transition-all shadow-lg text-sm">
                            <i class='bx bxl-whatsapp text-lg'></i> Pesan Varian Ini via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </section>



        {{-- ─── KEUNGGULAN ─── --}}
        <section class="bg-white py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-3 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Mengapa Kami?</span>
                    <h2 class="font-montserrat text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight">Keunggulan Martabak Jawara</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Kami berkomitmen menghadirkan martabak terbaik dengan bahan premium dan rasa yang selalu konsisten.</p>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100 hover:shadow-lg transition-all hover:-translate-y-0.5 group">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-lg shadow-sm shrink-0 group-hover:scale-105 transition-transform">🧀</div>
                            <h3 class="font-montserrat font-bold text-gray-900 text-xs sm:text-sm leading-tight">Bahan Premium</h3>
                        </div>
                        <p class="text-gray-500 text-[11px] sm:text-xs leading-relaxed">Keju berlimpah, almond premium, & cokelat pilihan.</p>
                    </div>
                    <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100 hover:shadow-lg transition-all hover:-translate-y-0.5 group">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center text-lg shadow-sm shrink-0 group-hover:scale-105 transition-transform">🍳</div>
                            <h3 class="font-montserrat font-bold text-gray-900 text-xs sm:text-sm leading-tight">Freshly Made</h3>
                        </div>
                        <p class="text-gray-500 text-[11px] sm:text-xs leading-relaxed">Dimasak segar setiap hari, tanpa dipanaskan ulang.</p>
                    </div>
                    <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100 hover:shadow-lg transition-all hover:-translate-y-0.5 group">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-lg shadow-sm shrink-0 group-hover:scale-105 transition-transform">🛵</div>
                            <h3 class="font-montserrat font-bold text-gray-900 text-xs sm:text-sm leading-tight">Pesan Antar</h3>
                        </div>
                        <p class="text-gray-500 text-[11px] sm:text-xs leading-relaxed">Layanan antar langsung ke rumah Anda di Muara Enim.</p>
                    </div>
                    <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100 hover:shadow-lg transition-all hover:-translate-y-0.5 group">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-lg shadow-sm shrink-0 group-hover:scale-105 transition-transform">⭐</div>
                            <h3 class="font-montserrat font-bold text-gray-900 text-xs sm:text-sm leading-tight">15+ Varian</h3>
                        </div>
                        <p class="text-gray-500 text-[11px] sm:text-xs leading-relaxed">Pilihan rasa manis, pizza, dan tipker berlimpah.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── LOKASI & KONTAK ─── --}}
        <section class="bg-amber-50 py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-3 bg-amber-100 px-3 py-1 rounded-full border border-amber-200">Lokasi & Kontak</span>
                    <h2 class="font-montserrat text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight">Temukan Kami</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Kunjungi gerai kami atau pesan melalui WhatsApp & GrabFood.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-stretch">
                    {{-- Info Card --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-amber-100 p-8 flex flex-col gap-6">
                        <div class="flex items-center gap-4 pb-6 border-b border-gray-100">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden shadow-md shrink-0">
                                <img src="{{ asset('images/martabak-jawara/Logo-Martabak-Jawara.webp') }}" alt="Martabak Jawara" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="font-montserrat font-black text-gray-900 text-xl leading-tight">Martabak Jawara</h3>
                                <p class="text-amber-700 text-sm font-semibold">Muara Enim, Sumatera Selatan</p>
                                <p class="text-gray-400 text-xs mt-0.5">Martabak Premium & Kekinian</p>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 text-lg shrink-0 mt-0.5"><i class='bx bx-map'></i></div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Alamat</p>
                                    <p class="text-gray-800 text-sm leading-relaxed font-medium">
                                        Teras Alfamart Talang Jawa Atas<br>
                                        Jl. Jenderal Sudirman, Muara Enim<br>
                                        Kabupaten Muara Enim, Sumatera Selatan 31312
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600 text-lg shrink-0"><i class='bxl-whatsapp bx'></i></div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">WhatsApp / Telepon</p>
                                    <a href="https://wa.me/6285664928097?text=Halo%20Martabak%20Jawara%2C%20saya%20ingin%20pesan."
                                       target="_blank"
                                       class="text-gray-800 text-sm font-bold hover:text-green-600 transition-colors">
                                        0856-6492-8097
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 text-lg shrink-0"><i class='bx bx-time-five'></i></div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Jam Buka</p>
                                    <p class="text-gray-800 text-sm font-medium">Setiap Hari: <span class="font-bold">14.00 – 22.00 WIB</span></p>
                                </div>
                            </div>
                        </div>

                        {{-- Social Media --}}
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Ikuti Kami</p>
                            <div class="flex items-center gap-3">
                                {{-- Instagram --}}
                                <a href="https://www.instagram.com/martabak_jawara45/" target="_blank"
                                   class="social-btn text-white"
                                   style="background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);"
                                   title="Instagram">
                                    <i class='bx bxl-instagram'></i>
                                </a>
                                {{-- Facebook --}}
                                <a href="https://www.facebook.com/watch/?v=493969459997047" target="_blank"
                                   class="social-btn bg-[#1877F2] hover:bg-[#0d6edf] text-white"
                                   title="Facebook">
                                    <i class='bx bxl-facebook'></i>
                                </a>
                                {{-- TikTok --}}
                                <a href="https://www.tiktok.com/@martabak.jawara/video/7632982188920704264" target="_blank"
                                   class="social-btn bg-black hover:bg-gray-800 text-white"
                                   title="TikTok">
                                    <i class='bx bxl-tiktok'></i>
                                </a>
                                {{-- WhatsApp --}}
                                <a href="https://wa.me/6285664928097" target="_blank"
                                   class="social-btn bg-[#25d366] hover:bg-[#1ebe5a] text-white"
                                   title="WhatsApp">
                                    <i class='bx bxl-whatsapp'></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Google Maps Embed --}}
                    <div class="rounded-3xl overflow-hidden shadow-sm border border-amber-100 h-full min-h-[400px]">
                        <iframe
                            src="https://maps.google.com/maps?q=Teras+Alfamart+Talang+Jawa+Atas+Jl+Jenderal+Sudirman+Muara+Enim&t=&z=16&ie=UTF8&iwloc=&output=embed"
                            class="w-full h-full border-0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Martabak Jawara Muara Enim">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── CTA ─── --}}
        <section class="cta-martabak py-6 md:py-16 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="absolute top-0 right-0 w-[600px] h-[600px] rounded-full blur-[160px] opacity-15" style="background:#f59e0b;"></div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 md:px-4 md:py-2 rounded-full border border-white/20 bg-white/10 backdrop-blur-sm mb-2 md:mb-6">
                    <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span class="text-amber-300 text-[9px] md:text-xs font-semibold tracking-widest uppercase">Martabak Jawara – Muara Enim</span>
                </div>

                <h2 class="font-playfair text-2xl md:text-5xl font-bold text-white mb-2 md:mb-6 leading-tight mt-1 md:mt-0">
                    Lapar? Yuk Order<br>Martabak Sekarang!
                </h2>

                <p class="text-white/70 text-[11px] md:text-lg mb-4 md:mb-10 max-w-2xl mx-auto leading-[1.35] md:leading-relaxed px-2 md:px-0">
                    Pesan sekarang via WhatsApp atau GrabFood — diantar hangat ke tempat Anda di area Muara Enim & sekitarnya.
                </p>

                {{-- Unified Order Hub Bottom --}}
                <div class="grid grid-cols-2 gap-2 md:gap-3 max-w-md mx-auto mb-5 md:mb-10">
                    <a href="https://wa.me/6285664928097?text=Halo%20Martabak%20Jawara%2C%20saya%20ingin%20pesan%20martabak." target="_blank"
                       class="flex items-center justify-center gap-1.5 md:gap-2 py-2 px-2 md:py-3 md:px-4 bg-green-500 hover:bg-green-400 text-white font-bold rounded-lg md:rounded-xl transition-all shadow-md text-[11px] md:text-sm">
                        <i class='bx bxl-whatsapp text-sm md:text-lg'></i> WhatsApp
                    </a>
                    <a href="https://r.grab.com/g/2-1-6-C6XJJJVCLA4YAA" target="_blank"
                       class="flex items-center justify-center gap-1.5 md:gap-2 py-2 px-2 md:py-3 md:px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-lg md:rounded-xl transition-all shadow-md text-[11px] md:text-sm">
                        <i class='bx bx-car text-sm md:text-lg'></i> GrabFood
                    </a>
                    <a href="https://shopee.co.id/universal-link/now-food/shop/22505814?deep_and_deferred=1&shareChannel=whatsapp" target="_blank"
                       class="flex items-center justify-center gap-1.5 md:gap-2 py-2 px-2 md:py-3 md:px-4 bg-orange-600 hover:bg-orange-500 text-white font-bold rounded-lg md:rounded-xl transition-all shadow-md text-[11px] md:text-sm">
                        <i class='bx bx-shopping-bag text-sm md:text-lg'></i> ShopeeFood
                    </a>
                    <a href="https://wa.me/6285664928097?text=Halo%20Martabak%20Jawara%2C%20saya%20mau%20pesan%20antar%20ke%20alamat%20saya." target="_blank"
                       class="flex items-center justify-center gap-1.5 md:gap-2 py-2 px-2 md:py-3 md:px-4 bg-amber-500 hover:bg-amber-400 text-amber-950 font-bold rounded-lg md:rounded-xl transition-all shadow-md text-[11px] md:text-sm">
                        <i class='bx bx-cycling text-sm md:text-lg'></i> Pesan Antar
                    </a>
                </div>

                {{-- Info strip --}}
                <div class="flex flex-wrap justify-center gap-3 md:gap-6 text-white/60 text-[10px] md:text-sm">
                    <div class="flex items-center gap-1.5 md:gap-2">
                        <i class='bx bx-map text-amber-400'></i>
                        <span>Teras Alfamart Talang Jawa Atas, Muara Enim</span>
                    </div>
                    <span class="hidden md:inline">•</span>
                    <div class="flex items-center gap-1.5 md:gap-2">
                        <i class='bx bx-time-five text-amber-400'></i>
                        <span>Buka 14.00 – 22.00 WIB</span>
                    </div>
                    <span class="hidden md:inline">•</span>
                    <div class="flex items-center gap-1.5 md:gap-2">
                        <i class='bx bx-phone text-amber-400'></i>
                        <span>0856-6492-8097</span>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <x-footer />
    <x-mobile-bottom-nav />

</body>
</html>
