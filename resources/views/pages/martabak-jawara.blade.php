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

        /* Lightbox */
        .lightbox-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.95);
            z-index: 9999;
            display: flex; align-items: center; justify-content: center;
        }
        .lightbox-overlay img {
            max-width: 92vw; max-height: 90vh;
            border-radius: 12px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.6);
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

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    {{-- Text Content --}}
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/20 bg-white/10 backdrop-blur-sm mb-6 fade-up">
                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse pulse-gold"></span>
                            <span class="text-amber-300 text-xs font-semibold tracking-widest uppercase">Muara Enim, Sumatera Selatan</span>
                        </div>

                        <h1 class="font-dancing text-5xl sm:text-6xl md:text-7xl font-bold text-white leading-tight mb-4 fade-up delay-1">
                            Martabak<br>
                            <span class="badge-shimmer">Jawara</span>
                        </h1>

                        <p class="text-white/80 text-base md:text-lg leading-relaxed mb-4 fade-up delay-2">
                            Martabak Jawara hadir dengan 3 senjata pamungkas: Manis, Pizza, dan Tipker. Dibuat fresh setiap hari dari bahan pilihan, teksturnya di jamin lembut,serta tipker yang cruncy bikin nagih dan lagi.
                            <br><br>
                            <span class="font-bold text-amber-300">Satu gigitan, langsung kecanduan. Siap buktikan?</span>
                        </p>

                        {{-- Jam buka badge --}}
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500/20 border border-amber-400/40 rounded-full text-amber-200 text-sm font-semibold mb-8 fade-up delay-2">
                            <i class='bx bx-time-five text-amber-400'></i>
                            Buka setiap hari: <strong class="text-amber-300">14.00 – 22.00 WIB</strong>
                        </div>

                        <div class="flex flex-wrap gap-3 fade-up delay-3">
                            <a href="#menu"
                               class="inline-flex items-center gap-2 px-7 py-3.5 bg-amber-500 hover:bg-amber-400 text-white font-bold rounded-full transition-all shadow-lg hover:shadow-amber-500/40 hover:-translate-y-0.5 text-sm">
                                <i class='bx bx-food-menu text-lg'></i> Lihat Menu
                            </a>
                            <a href="https://wa.me/6285664928097?text=Halo%20Martabak%20Jawara%2C%20saya%20ingin%20pesan%20martabak." target="_blank"
                               class="inline-flex items-center gap-2 px-7 py-3.5 bg-green-500 hover:bg-green-400 text-white font-bold rounded-full transition-all shadow-lg hover:shadow-green-500/30 hover:-translate-y-0.5 text-sm">
                                <i class='bx bxl-whatsapp text-lg'></i> Pesan via WA
                            </a>
                            <a href="https://r.grab.com/g/2-1-6-C6XJJJVCLA4YAA" target="_blank"
                               class="inline-flex items-center gap-2 px-7 py-3.5 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-bold rounded-full border border-white/25 transition-all hover:-translate-y-0.5 text-sm">
                                <i class='bx bx-car text-lg text-green-400'></i> GrabFood
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

        {{-- ─── ORDER PLATFORM ─── --}}
        <section class="bg-white py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-3 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Tersedia Di</span>
                <h2 class="font-montserrat text-2xl md:text-3xl font-black text-gray-900 mb-3 tracking-tight">Pesan Sekarang Via</h2>
                <p class="text-gray-500 text-sm mb-10">Nikmati kemudahan memesan martabak favoritmu melalui berbagai platform.</p>

                <div class="flex flex-wrap justify-center gap-4">
                    {{-- WhatsApp --}}
                    <a href="https://wa.me/6285664928097?text=Halo%20Martabak%20Jawara%2C%20saya%20ingin%20pesan%20martabak." target="_blank"
                       class="flex items-center gap-3 px-7 py-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-2xl transition-all shadow-md hover:shadow-green-500/40 hover:-translate-y-1 text-sm">
                        <i class='bx bxl-whatsapp text-2xl'></i>
                        <div class="text-left">
                            <p class="text-[10px] font-medium opacity-80 leading-none">Pesan via</p>
                            <p class="font-black text-base leading-tight">WhatsApp</p>
                        </div>
                    </a>
                    {{-- GrabFood --}}
                    <a href="https://r.grab.com/g/2-1-6-C6XJJJVCLA4YAA" target="_blank"
                       class="flex items-center gap-3 px-7 py-4 grab-btn text-white font-bold rounded-2xl transition-all shadow-md hover:shadow-green-500/30 hover:-translate-y-1 text-sm">
                        <svg width="28" height="28" viewBox="0 0 40 40" fill="none"><rect width="40" height="40" rx="8" fill="white"/><path d="M20 8C13.4 8 8 13.4 8 20s5.4 12 12 12 12-5.4 12-12S26.6 8 20 8zm0 2c5.5 0 10 4.5 10 10s-4.5 10-10 10S10 25.5 10 20 14.5 10 20 10z" fill="#00b14f"/><text x="20" y="26" font-family="Arial" font-size="10" font-weight="bold" fill="#00b14f" text-anchor="middle">GRAB</text></svg>
                        <div class="text-left">
                            <p class="text-[10px] font-medium opacity-80 leading-none">Pesan via</p>
                            <p class="font-black text-base leading-tight">GrabFood</p>
                        </div>
                    </a>
                    {{-- ShopeeFood --}}
                    <a href="https://shopee.co.id/universal-link/now-food/shop/22505814?deep_and_deferred=1&shareChannel=whatsapp" target="_blank"
                       class="flex items-center gap-3 px-7 py-4 shopee-btn text-white font-bold rounded-2xl transition-all shadow-md hover:shadow-orange-500/30 hover:-translate-y-1 text-sm">
                        <i class='bx bx-shopping-bag text-2xl'></i>
                        <div class="text-left">
                            <p class="text-[10px] font-medium opacity-80 leading-none">Pesan via</p>
                            <p class="font-black text-base leading-tight">ShopeeFood</p>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        {{-- ─── MENU / GALLERY ─── --}}
        <section id="menu" class="bg-amber-50 py-20"
            x-data="{
                activeTab: 'all',
                lightbox: false,
                lightboxSrc: '',
                lightboxCaption: '',
                openLightbox(src, caption) { this.lightboxSrc = src; this.lightboxCaption = caption; this.lightbox = true; document.body.style.overflow = 'hidden'; },
                closeLightbox() { this.lightbox = false; document.body.style.overflow = ''; }
            }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-3 bg-amber-100 px-3 py-1 rounded-full border border-amber-200">Menu Spesial Kami</span>
                    <h2 class="font-montserrat text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight">Pilihan Menu Martabak</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Dari martabak klasik hingga kreasi premium kekinian — semua tersedia di sini!</p>
                </div>

                {{-- Filter Tabs --}}
                <div class="flex flex-wrap justify-center gap-3 mb-10">
                    <button @click="activeTab='all'"        :class="activeTab==='all'        ? 'active' : ''" class="tab-btn">Semua</button>
                    <button @click="activeTab='original'"   :class="activeTab==='original'   ? 'active' : ''" class="tab-btn">Original</button>
                    <button @click="activeTab='blackforest'" :class="activeTab==='blackforest' ? 'active' : ''" class="tab-btn">Black Forest</button>
                    <button @click="activeTab='tipker'"     :class="activeTab==='tipker'     ? 'active' : ''" class="tab-btn">Tipker</button>
                    <button @click="activeTab='pizza'"      :class="activeTab==='pizza'      ? 'active' : ''" class="tab-btn">Pizza</button>
                </div>

                {{-- Masonry Gallery --}}
                <div class="gallery-grid">
                    @php
                    $menus = [
                        /* Original */
                        ['src'=>'images/martabak-jawara/Martabak -Keju-Berlimpah.webp',                   'alt'=>'Martabak Original Keju Berlimpah',           'tag'=>'original',    'label'=>'Original'],
                        ['src'=>'images/martabak-jawara/Martabak Original Choco Cruncy.webp',             'alt'=>'Martabak Original Choco Crunchy',            'tag'=>'original',    'label'=>'Original'],
                        ['src'=>'images/martabak-jawara/Martabak Original Oreo.webp',                     'alt'=>'Martabak Original Oreo',                     'tag'=>'original',    'label'=>'Original'],
                        ['src'=>'images/martabak-jawara/Martabak Kacang Keju Meses.webp',                 'alt'=>'Martabak Kacang Keju Meses',                 'tag'=>'original',    'label'=>'Original'],
                        ['src'=>'images/martabak-jawara/Martabak-Almond- Keju-Kacang.webp',               'alt'=>'Martabak Almond Keju Kacang',                'tag'=>'original',    'label'=>'Original'],
                        /* Black Forest */
                        ['src'=>'images/martabak-jawara/Martabak Black Forest - Almond - Keju - Meses.webp','alt'=>'Martabak Black Forest Almond Keju Meses',  'tag'=>'blackforest', 'label'=>'Black Forest'],
                        ['src'=>'images/martabak-jawara/Martabak Black Forest Ketan Keju.webp',           'alt'=>'Martabak Black Forest Ketan Keju',           'tag'=>'blackforest', 'label'=>'Black Forest'],
                        ['src'=>'images/martabak-jawara/Martabak Black Forest Meses.webp',                'alt'=>'Martabak Black Forest Meses',                'tag'=>'blackforest', 'label'=>'Black Forest'],
                        /* Tipker */
                        ['src'=>'images/martabak-jawara/Martabak Tipker Chocomalltine.webp',              'alt'=>'Martabak Tipker Chocomaltine',               'tag'=>'tipker',      'label'=>'Tipker'],
                        ['src'=>'images/martabak-jawara/Martabak Tipker Kacang Wijen.webp',               'alt'=>'Martabak Tipker Kacang Wijen',               'tag'=>'tipker',      'label'=>'Tipker'],
                        ['src'=>'images/martabak-jawara/Martabak Tipker-Kacang-Wijen.webp',               'alt'=>'Martabak Tipker Kacang Wijen Premium',       'tag'=>'tipker',      'label'=>'Tipker'],
                        ['src'=>'images/martabak-jawara/Martabak-Tipker-Kacang.webp',                     'alt'=>'Martabak Tipker Kacang',                     'tag'=>'tipker',      'label'=>'Tipker'],
                        /* Pizza */
                        ['src'=>'images/martabak-jawara/Martabak Pizza - Basic.webp',                     'alt'=>'Martabak Pizza Basic',                       'tag'=>'pizza',       'label'=>'Pizza'],
                        ['src'=>'images/martabak-jawara/Martabak Pizza Ulitimate.webp',                   'alt'=>'Martabak Pizza Ultimate',                    'tag'=>'pizza',       'label'=>'Pizza'],
                        ['src'=>'images/martabak-jawara/Martabak-Pizza-Pro.webp',                         'alt'=>'Martabak Pizza Pro',                         'tag'=>'pizza',       'label'=>'Pizza'],
                    ];
                    @endphp

                    @foreach($menus as $item)
                    <div class="gallery-item"
                         x-show="activeTab==='all' || activeTab==='{{ $item['tag'] }}'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100">
                        <img src="{{ asset($item['src']) }}" alt="{{ $item['alt'] }}" loading="lazy">
                        <div class="overlay" @click="openLightbox('{{ asset($item['src']) }}', '{{ $item['alt'] }} — Martabak Jawara')">
                            <div>
                                <p class="text-white font-semibold text-sm">{{ $item['alt'] }}</p>
                                <p class="text-white/60 text-xs">{{ $item['label'] }} • Martabak Jawara</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Lightbox --}}
            <div x-show="lightbox" class="lightbox-overlay" @click.self="closeLightbox()" @keydown.escape.window="closeLightbox()" x-cloak>
                <div class="relative">
                    <img :src="lightboxSrc" :alt="lightboxCaption">
                    <p class="text-white/70 text-sm text-center mt-3" x-text="lightboxCaption"></p>
                    <button @click="closeLightbox()" class="absolute -top-4 -right-4 w-9 h-9 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-sm flex items-center justify-center text-white transition-all">
                        <i class='bx bx-x text-xl'></i>
                    </button>
                </div>
            </div>
        </section>

        {{-- ─── DELIVERY BANNER ─── --}}
        <section class="delivery-banner py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-3xl">
                            🛵
                        </div>
                        <div>
                            <h3 class="font-montserrat font-black text-white text-xl">Layanan Pesan Antar</h3>
                            <p class="text-green-100 text-sm">Tersedia untuk area Muara Enim & sekitarnya</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 justify-center">
                        <a href="https://wa.me/6285664928097?text=Halo%20Martabak%20Jawara%2C%20saya%20mau%20pesan%20antar%20ke%20alamat%20saya." target="_blank"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-green-800 font-black rounded-xl hover:bg-green-50 transition-all shadow-md hover:-translate-y-0.5 text-sm">
                            <i class='bx bxl-whatsapp text-xl text-green-600'></i> Order Sekarang
                        </a>
                        <a href="https://r.grab.com/g/2-1-6-C6XJJJVCLA4YAA" target="_blank"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-[#00b14f] text-white font-black rounded-xl hover:bg-[#009e46] transition-all shadow-md hover:-translate-y-0.5 text-sm">
                            <i class='bx bx-car text-xl'></i> GrabFood
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── KEUNGGULAN ─── --}}
        <section class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-3 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Mengapa Kami?</span>
                    <h2 class="font-montserrat text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight">Keunggulan Martabak Jawara</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Kami berkomitmen menghadirkan martabak terbaik dengan bahan premium dan rasa yang selalu konsisten.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-amber-50 rounded-3xl p-6 border border-amber-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl mb-5 shadow-sm group-hover:scale-110 transition-transform">🧀</div>
                        <h3 class="font-montserrat font-bold text-gray-900 mb-2">Bahan Premium</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Keju berlimpah, almond premium, dan cokelat pilihan untuk rasa terbaik.</p>
                    </div>
                    <div class="bg-amber-50 rounded-3xl p-6 border border-amber-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center text-2xl mb-5 shadow-sm group-hover:scale-110 transition-transform">🍳</div>
                        <h3 class="font-montserrat font-bold text-gray-900 mb-2">Freshly Made</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Dimasak segar setiap hari, tidak ada yang dipanaskan ulang.</p>
                    </div>
                    <div class="bg-amber-50 rounded-3xl p-6 border border-amber-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl mb-5 shadow-sm group-hover:scale-110 transition-transform">🛵</div>
                        <h3 class="font-montserrat font-bold text-gray-900 mb-2">Pesan Antar</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Layanan antar ke rumah Anda di area Muara Enim & sekitarnya.</p>
                    </div>
                    <div class="bg-amber-50 rounded-3xl p-6 border border-amber-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl mb-5 shadow-sm group-hover:scale-110 transition-transform">⭐</div>
                        <h3 class="font-montserrat font-bold text-gray-900 mb-2">15+ Varian Rasa</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Pilihan rasa yang beragam untuk semua selera.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── LOKASI & KONTAK ─── --}}
        <section class="bg-amber-50 py-20">
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

                        <div class="mt-auto pt-4 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <a href="https://wa.me/6285664928097?text=Halo%20Martabak%20Jawara%2C%20saya%20ingin%20pesan%20martabak."
                               target="_blank"
                               class="flex items-center justify-center gap-2 px-5 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-md text-sm">
                                <i class='bx bxl-whatsapp text-lg'></i> Chat WhatsApp
                            </a>
                            <a href="https://maps.app.goo.gl/GhJ1yEj7cviTwbkz5" target="_blank"
                               class="flex items-center justify-center gap-2 px-5 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-md text-sm">
                                <i class='bx bx-map text-lg'></i> Buka Maps
                            </a>
                        </div>
                    </div>

                    {{-- Google Maps Embed --}}
                    <div class="rounded-3xl overflow-hidden shadow-sm border border-amber-100 min-h-[400px]">
                        <iframe
                            src="https://maps.google.com/maps?q=Teras+Alfamart+Talang+Jawa+Atas+Jl+Jenderal+Sudirman+Muara+Enim&t=&z=16&ie=UTF8&iwloc=&output=embed"
                            class="w-full h-full min-h-[400px] border-0"
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
        <section class="cta-martabak py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="absolute top-0 right-0 w-[600px] h-[600px] rounded-full blur-[160px] opacity-15" style="background:#f59e0b;"></div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/20 bg-white/10 backdrop-blur-sm mb-6">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span class="text-amber-300 text-xs font-semibold tracking-widest uppercase">Martabak Jawara – Muara Enim</span>
                </div>

                <h2 class="font-playfair text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">
                    Lapar? Yuk Order<br>Martabak Sekarang!
                </h2>

                <p class="text-white/70 text-lg mb-10 max-w-2xl mx-auto leading-relaxed">
                    Pesan sekarang via WhatsApp atau GrabFood — diantar hangat ke tempat Anda di area Muara Enim & sekitarnya.
                </p>

                <div class="flex flex-wrap justify-center gap-4 mb-12">
                    <a href="https://wa.me/6285664928097?text=Halo%20Martabak%20Jawara%2C%20saya%20mau%20order%20martabak%20dan%20minta%20dikirim%20ke%20alamat%20saya."
                       target="_blank"
                       class="inline-flex items-center gap-2 px-10 py-4 bg-white hover:bg-gray-50 text-amber-800 rounded-full font-black text-lg transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1">
                        <i class='bx bxl-whatsapp text-2xl text-green-500'></i> Pesan via WhatsApp
                    </a>
                    <a href="https://r.grab.com/g/2-1-6-C6XJJJVCLA4YAA"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-8 py-4 bg-[#00b14f] hover:bg-[#009e46] text-white rounded-full font-bold text-lg transition-all shadow-xl hover:-translate-y-1">
                        <i class='bx bx-car text-xl'></i> GrabFood
                    </a>
                </div>

                {{-- Info strip --}}
                <div class="flex flex-wrap justify-center gap-6 text-white/60 text-sm">
                    <div class="flex items-center gap-2">
                        <i class='bx bx-map text-amber-400'></i>
                        <span>Teras Alfamart Talang Jawa Atas, Jl. Jend. Sudirman, Muara Enim</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class='bx bx-time-five text-amber-400'></i>
                        <span>Buka 14.00 – 22.00 WIB</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class='bx bx-phone text-amber-400'></i>
                        <span>0856-6492-8097</span>
                    </div>
                </div>

                {{-- Social icons at bottom --}}
                <div class="flex justify-center gap-4 mt-10">
                    <a href="https://www.instagram.com/martabak_jawara45/" target="_blank"
                       class="w-12 h-12 rounded-full flex items-center justify-center text-white text-2xl transition-all hover:scale-110"
                       style="background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);"
                       title="Instagram @martabak_jawara45">
                        <i class='bx bxl-instagram'></i>
                    </a>
                    <a href="https://www.facebook.com/watch/?v=493969459997047" target="_blank"
                       class="w-12 h-12 rounded-full bg-[#1877F2] hover:bg-[#0d6edf] flex items-center justify-center text-white text-2xl transition-all hover:scale-110"
                       title="Facebook Martabak Jawara">
                        <i class='bx bxl-facebook'></i>
                    </a>
                    <a href="https://www.tiktok.com/@martabak.jawara/video/7632982188920704264" target="_blank"
                       class="w-12 h-12 rounded-full bg-black hover:bg-gray-800 flex items-center justify-center text-white text-2xl transition-all hover:scale-110"
                       title="TikTok Martabak Jawara">
                        <i class='bx bxl-tiktok'></i>
                    </a>
                    <a href="https://wa.me/6285664928097" target="_blank"
                       class="w-12 h-12 rounded-full bg-[#25d366] hover:bg-[#1ebe5a] flex items-center justify-center text-white text-2xl transition-all hover:scale-110"
                       title="WhatsApp Martabak Jawara">
                        <i class='bx bxl-whatsapp'></i>
                    </a>
                </div>
            </div>
        </section>

    </main>

    <x-footer />
    <x-mobile-bottom-nav />

</body>
</html>
