<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jasa Furniture - Interior S2 Bandar Lampung | LKTech</title>
    <meta name="description" content="Interior S2 Bandar Lampung - Jasa furniture custom berkualitas tinggi. Kitchen Set, Kamar Set, Backdrop TV. Hubungi 085366114312. Jl. Terusan Pulau Singkep, Saba Balau, Sukabumi, Bandar Lampung.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800;900&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

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

    <style>
        body { font-family: 'Inter', sans-serif; }

        .hero-furniture {
            background: linear-gradient(135deg, #1a0e05 0%, #3d1e0c 30%, #5c3015 60%, #7a4520 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-furniture::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .gallery-grid { columns: 1; column-gap: 1rem; }
        @media (min-width: 640px) { .gallery-grid { columns: 2; } }
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
            width: 100%;
            display: block;
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .gallery-item:hover img { transform: scale(1.06); }
        .gallery-item .overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(26,14,5,0.85) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.35s ease;
            display: flex; align-items: flex-end; padding: 1.25rem;
        }
        .gallery-item:hover .overlay { opacity: 1; }

        .tab-btn {
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.25s ease;
            border: 2px solid #e2d6c5;
            color: #7a4520;
            background: white;
            cursor: pointer;
        }
        .tab-btn.active, .tab-btn:hover {
            background: #7a4520;
            color: white;
            border-color: #7a4520;
            box-shadow: 0 4px 14px rgba(122, 69, 32, 0.35);
        }

        .lightbox-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.93);
            z-index: 9999;
            display: flex; align-items: center; justify-content: center;
        }
        .lightbox-overlay img {
            max-width: 92vw; max-height: 90vh;
            border-radius: 12px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.6);
        }

        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }
        .badge-shimmer {
            background: linear-gradient(90deg, #c08040, #f5e6cc, #a0612a, #f5e6cc, #c08040);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }

        .cta-furniture {
            background: linear-gradient(135deg, #3d1e0c 0%, #7a4520 50%, #a0612a 100%);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.65s ease both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-stone-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <x-navbar />

    <main class="flex-grow w-full pb-20 md:pb-0">

        {{-- ─── HERO ─── --}}
        <section class="hero-furniture min-h-[68vh] md:min-h-[72vh] flex items-center relative">
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-[120px] opacity-20" style="background:#c08040;"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full blur-[100px] opacity-15" style="background:#d4a96a;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20 w-full">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/20 bg-white/10 backdrop-blur-sm mb-6 fade-up">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        <span class="text-amber-300 text-xs font-semibold tracking-widest uppercase">Interior S2 Bandar Lampung</span>
                    </div>

                    <h1 class="font-playfair text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6 fade-up delay-1">
                        Furniture Custom<br>
                        <span class="badge-shimmer">Berkualitas Tinggi</span>
                    </h1>

                    <p class="text-white/70 text-lg md:text-xl leading-relaxed mb-10 max-w-2xl fade-up delay-2">
                        Kami menghadirkan solusi furniture interior impian Anda — dari kitchen set modern, kamar set elegan, hingga backdrop TV yang memukau. Dikerjakan dengan penuh presisi dan keahlian.
                    </p>

                    <div class="flex flex-wrap gap-4 fade-up delay-3">
                        <a href="#galeri"
                           class="inline-flex items-center gap-2 px-8 py-3.5 bg-amber-500 hover:bg-amber-400 text-white font-bold rounded-full transition-all shadow-lg hover:shadow-amber-500/40 hover:-translate-y-0.5 text-sm">
                            <i class='bx bx-images text-lg'></i> Lihat Galeri
                        </a>
                        <a href="https://wa.me/6285366114312?text=Halo%20Interior%20S2%2C%20saya%20ingin%20konsultasi%20mengenai%20furniture%20custom." target="_blank"
                           class="inline-flex items-center gap-2 px-8 py-3.5 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-bold rounded-full border border-white/25 transition-all hover:-translate-y-0.5 text-sm">
                            <i class='bx bxl-whatsapp text-lg text-green-400'></i> Konsultasi Gratis
                        </a>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 60L60 50C120 40 240 20 360 15C480 10 600 20 720 28C840 36 960 40 1080 38C1200 36 1320 28 1380 24L1440 20V60H0Z" fill="#f8f4ef"/>
                </svg>
            </div>
        </section>

        {{-- ─── INFO STRIP ─── --}}
        <section class="bg-stone-50 py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-stone-200 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 text-2xl shrink-0"><i class='bx bx-home-heart'></i></div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm leading-tight">Kitchen Set</p>
                            <p class="text-xs text-gray-500">Custom & Modern</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-stone-200 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 text-2xl shrink-0"><i class='bx bx-bed'></i></div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm leading-tight">Kamar Set</p>
                            <p class="text-xs text-gray-500">Elegan & Nyaman</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-stone-200 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 text-2xl shrink-0"><i class='bx bx-tv'></i></div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm leading-tight">Backdrop TV</p>
                            <p class="text-xs text-gray-500">Desain Premium</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-stone-200 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center text-green-600 text-2xl shrink-0"><i class='bx bxs-check-shield'></i></div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm leading-tight">Bergaransi</p>
                            <p class="text-xs text-gray-500">Kualitas Terjamin</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── LAYANAN UNGGULAN ─── --}}
        <section class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-3 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Kategori Layanan</span>
                    <h2 class="font-montserrat text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight">Layanan Furniture Kami</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto leading-relaxed">Interior S2 menghadirkan beragam solusi furniture berkualitas tinggi untuk melengkapi hunian dan ruang usaha Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
                    <div class="group relative rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100">
                        <div class="aspect-[4/3] overflow-hidden">
                            <img src="{{ asset('images/furniture/kitchen-set/kitchen-1.webp') }}" alt="Kitchen Set Custom Interior S2 Bandar Lampung" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <span class="text-xs font-bold text-amber-300 uppercase tracking-widest mb-1 block">Kitchen Set</span>
                            <h3 class="font-montserrat font-bold text-white text-xl mb-2">Kitchen Set Custom</h3>
                            <p class="text-white/70 text-sm leading-relaxed">Dapur impian Anda dengan desain modern dan material berkualitas tinggi, disesuaikan dengan ukuran dan selera.</p>
                        </div>
                    </div>

                    <div class="group relative rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100">
                        <div class="aspect-[4/3] overflow-hidden">
                            <img src="{{ asset('images/furniture/kamar-set/kamar-2.webp') }}" alt="Kamar Set Elegan Interior S2 Bandar Lampung" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <span class="text-xs font-bold text-amber-300 uppercase tracking-widest mb-1 block">Kamar Set</span>
                            <h3 class="font-montserrat font-bold text-white text-xl mb-2">Kamar Set Elegan</h3>
                            <p class="text-white/70 text-sm leading-relaxed">Furniture kamar tidur lengkap — tempat tidur, lemari, meja rias — dengan sentuhan desain mewah dan fungsional.</p>
                        </div>
                    </div>

                    <div class="group relative rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100">
                        <div class="aspect-[4/3] overflow-hidden">
                            <img src="{{ asset('images/furniture/backdrop-tv/backdrop-1.webp') }}" alt="Backdrop TV Premium Interior S2 Bandar Lampung" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <span class="text-xs font-bold text-amber-300 uppercase tracking-widest mb-1 block">Backdrop TV</span>
                            <h3 class="font-montserrat font-bold text-white text-xl mb-2">Backdrop TV Premium</h3>
                            <p class="text-white/70 text-sm leading-relaxed">Backdrop TV yang menambah keindahan ruang tamu, dengan pilihan material dan finishing yang beragam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── GALERI ─── --}}
        <section id="galeri" class="bg-stone-50 py-20"
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
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-3 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Portofolio Kami</span>
                    <h2 class="font-montserrat text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight">Galeri Hasil Karya</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Setiap karya adalah bukti komitmen kami terhadap kualitas dan keindahan.</p>
                </div>

                <!-- Filter Tabs -->
                <div class="flex flex-wrap justify-center gap-3 mb-10">
                    <button @click="activeTab='all'"      :class="activeTab==='all'      ? 'active' : ''" class="tab-btn">Semua</button>
                    <button @click="activeTab='kitchen'"  :class="activeTab==='kitchen'  ? 'active' : ''" class="tab-btn">Kitchen Set</button>
                    <button @click="activeTab='kamar'"    :class="activeTab==='kamar'    ? 'active' : ''" class="tab-btn">Kamar Set</button>
                    <button @click="activeTab='backdrop'" :class="activeTab==='backdrop' ? 'active' : ''" class="tab-btn">Backdrop TV</button>
                </div>

                <!-- Masonry Gallery -->
                <div class="gallery-grid">
                    @php
                        $kitchenImages = [
                            ['src'=>'images/furniture/kitchen-set/kitchen-1.webp','alt'=>'Kitchen Set Custom 1'],
                            ['src'=>'images/furniture/kitchen-set/kitchen-2.webp','alt'=>'Kitchen Set Custom 2'],
                            ['src'=>'images/furniture/kitchen-set/kitchen-3.webp','alt'=>'Kitchen Set Custom 3'],
                        ];
                        $kamarImages = [
                            ['src'=>'images/furniture/kamar-set/kamar-1.webp', 'alt'=>'Kamar Set Custom 1'],
                            ['src'=>'images/furniture/kamar-set/kamar-2.webp', 'alt'=>'Kamar Set Custom 2'],
                            ['src'=>'images/furniture/kamar-set/kamar-3.webp', 'alt'=>'Kamar Set Custom 3'],
                            ['src'=>'images/furniture/kamar-set/kamar-4.webp', 'alt'=>'Kamar Set Custom 4'],
                            ['src'=>'images/furniture/kamar-set/kamar-5.webp', 'alt'=>'Kamar Set Custom 5'],
                            ['src'=>'images/furniture/kamar-set/kamar-6.webp', 'alt'=>'Kamar Set Custom 6'],
                            ['src'=>'images/furniture/kamar-set/kamar-7.webp', 'alt'=>'Kamar Set Custom 7'],
                            ['src'=>'images/furniture/kamar-set/kamar-8.webp', 'alt'=>'Kamar Set Custom 8'],
                            ['src'=>'images/furniture/kamar-set/kamar-9.webp', 'alt'=>'Kamar Set Custom 9'],
                            ['src'=>'images/furniture/kamar-set/kamar-10.webp','alt'=>'Kamar Set Custom 10'],
                            ['src'=>'images/furniture/kamar-set/kamar-11.webp','alt'=>'Kamar Set Custom 11'],
                            ['src'=>'images/furniture/kamar-set/kamar-12.webp','alt'=>'Kamar Set Custom 12'],
                        ];
                        $backdropImages = [
                            ['src'=>'images/furniture/backdrop-tv/backdrop-1.webp','alt'=>'Backdrop TV 1'],
                            ['src'=>'images/furniture/backdrop-tv/backdrop-2.webp','alt'=>'Backdrop TV 2'],
                            ['src'=>'images/furniture/backdrop-tv/backdrop-3.webp','alt'=>'Backdrop TV 3'],
                            ['src'=>'images/furniture/backdrop-tv/backdrop-4.webp','alt'=>'Backdrop TV 4'],
                        ];
                    @endphp

                    @foreach($kitchenImages as $img)
                    <div class="gallery-item" x-show="activeTab==='all'||activeTab==='kitchen'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                        <img src="{{ asset($img['src']) }}" alt="{{ $img['alt'] }}" loading="lazy">
                        <div class="overlay" @click="openLightbox('{{ asset($img['src']) }}', '{{ $img['alt'] }} — Interior S2 Bandar Lampung')">
                            <div>
                                <p class="text-white font-semibold text-sm">{{ $img['alt'] }}</p>
                                <p class="text-white/60 text-xs">Kitchen Set • Interior S2</p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach($kamarImages as $img)
                    <div class="gallery-item" x-show="activeTab==='all'||activeTab==='kamar'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                        <img src="{{ asset($img['src']) }}" alt="{{ $img['alt'] }}" loading="lazy">
                        <div class="overlay" @click="openLightbox('{{ asset($img['src']) }}', '{{ $img['alt'] }} — Interior S2 Bandar Lampung')">
                            <div>
                                <p class="text-white font-semibold text-sm">{{ $img['alt'] }}</p>
                                <p class="text-white/60 text-xs">Kamar Set • Interior S2</p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach($backdropImages as $img)
                    <div class="gallery-item" x-show="activeTab==='all'||activeTab==='backdrop'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                        <img src="{{ asset($img['src']) }}" alt="{{ $img['alt'] }}" loading="lazy">
                        <div class="overlay" @click="openLightbox('{{ asset($img['src']) }}', '{{ $img['alt'] }} — Interior S2 Bandar Lampung')">
                            <div>
                                <p class="text-white font-semibold text-sm">{{ $img['alt'] }}</p>
                                <p class="text-white/60 text-xs">Backdrop TV • Interior S2</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Lightbox -->
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

        {{-- ─── KEUNGGULAN ─── --}}
        <section class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-3 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Mengapa Kami?</span>
                    <h2 class="font-montserrat text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight">Keunggulan Interior S2</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Kepuasan pelanggan adalah prioritas utama kami dalam setiap proyek furniture.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-stone-50 rounded-3xl p-6 border border-stone-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mb-5 shadow-sm group-hover:scale-110 transition-transform"><i class='bx bx-ruler'></i></div>
                        <h3 class="font-montserrat font-bold text-gray-900 mb-2">Custom Ukuran</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Dibuat sesuai dimensi ruangan dan kebutuhan Anda, tidak ada yang tidak muat.</p>
                    </div>
                    <div class="bg-stone-50 rounded-3xl p-6 border border-stone-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center text-2xl mb-5 shadow-sm group-hover:scale-110 transition-transform"><i class='bx bx-shield-quarter'></i></div>
                        <h3 class="font-montserrat font-bold text-gray-900 mb-2">Material Premium</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Menggunakan bahan pilihan berkualitas tinggi untuk ketahanan jangka panjang.</p>
                    </div>
                    <div class="bg-stone-50 rounded-3xl p-6 border border-stone-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-5 shadow-sm group-hover:scale-110 transition-transform"><i class='bx bxs-paint'></i></div>
                        <h3 class="font-montserrat font-bold text-gray-900 mb-2">Finishing Rapi</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Proses finishing teliti dan rapi menghasilkan tampilan yang halus dan mewah.</p>
                    </div>
                    <div class="bg-stone-50 rounded-3xl p-6 border border-stone-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl mb-5 shadow-sm group-hover:scale-110 transition-transform"><i class='bx bx-time'></i></div>
                        <h3 class="font-montserrat font-bold text-gray-900 mb-2">Tepat Waktu</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Pengerjaan sesuai jadwal yang disepakati dengan komunikasi yang transparan.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── INFO TOKO ─── --}}
        <section class="bg-stone-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-3 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Lokasi & Kontak</span>
                    <h2 class="font-montserrat text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight">Temukan Kami</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Kunjungi showroom kami atau hubungi langsung untuk konsultasi furniture custom Anda.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-stretch">
                    <!-- Info Card -->
                    <div class="bg-white rounded-3xl shadow-sm border border-stone-200 p-8 flex flex-col gap-6">
                        <div class="flex items-center gap-4 pb-6 border-b border-gray-100">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-md shrink-0"
                                 style="background: linear-gradient(135deg, #3d1e0c, #a0612a);">
                                <i class='bx bx-home-smile text-white text-3xl'></i>
                            </div>
                            <div>
                                <h3 class="font-montserrat font-black text-gray-900 text-xl leading-tight">Interior S2</h3>
                                <p class="text-amber-700 text-sm font-semibold">Bandar Lampung</p>
                                <p class="text-gray-400 text-xs mt-0.5">Furniture Custom & Interior</p>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 text-lg shrink-0 mt-0.5"><i class='bx bx-map'></i></div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Alamat</p>
                                    <p class="text-gray-800 text-sm leading-relaxed font-medium">
                                        Jalan Terusan Pulau Singkep, Saba Balau<br>
                                        Sukabumi, Bandar Lampung
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600 text-lg shrink-0"><i class='bx bxl-whatsapp'></i></div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">WhatsApp / Telepon</p>
                                    <a href="https://wa.me/6285366114312?text=Halo%20Interior%20S2%2C%20saya%20ingin%20konsultasi%20furniture."
                                       target="_blank"
                                       class="text-gray-800 text-sm font-bold hover:text-green-600 transition-colors">
                                        0853-6611-4312
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 text-lg shrink-0"><i class='bx bx-time-five'></i></div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Jam Operasional</p>
                                    <p class="text-gray-800 text-sm font-medium">Senin – Sabtu: <span class="font-bold">09.00 – 17.00 WIB</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto pt-6 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <a href="https://wa.me/6285366114312?text=Halo%20Interior%20S2%2C%20saya%20ingin%20konsultasi%20furniture%20custom."
                               target="_blank"
                               class="flex items-center justify-center gap-2 px-5 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-md text-sm">
                                <i class='bx bxl-whatsapp text-lg'></i> Chat WhatsApp
                            </a>
                            <a href="tel:+6285366114312"
                               class="flex items-center justify-center gap-2 px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition-all text-sm">
                                <i class='bx bx-phone text-lg'></i> Telepon
                            </a>
                        </div>
                    </div>

                    <!-- Maps -->
                    <div class="rounded-3xl overflow-hidden shadow-sm border border-stone-200 min-h-[400px]">
                        <iframe
                            src="https://maps.google.com/maps?q=Saba+Balau+Sukabumi+Bandar+Lampung&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            class="w-full h-full min-h-[400px] border-0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Interior S2 Bandar Lampung">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── PROSES PENGERJAAN ─── --}}
        <section class="bg-white py-20 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNFMkQ2QzUiLz48L3N2Zz4=')] opacity-60"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-14">
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-3 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Cara Kerja</span>
                    <h2 class="font-montserrat text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight">Proses Pengerjaan</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Kami memastikan setiap langkah berjalan transparan dan sesuai harapan Anda.</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center relative">
                    <div class="hidden md:block absolute top-10 left-[10%] right-[10%] h-0.5 z-0" style="background: linear-gradient(90deg, #e8c99a, #a0612a, #e8c99a);"></div>

                    <div class="relative z-10 flex flex-col items-center text-center p-3 md:p-0 bg-white md:bg-transparent rounded-xl md:rounded-none shadow-sm md:shadow-none border md:border-none border-gray-100">
                        <div class="w-10 h-10 md:w-20 md:h-20 shrink-0 mx-auto bg-white border-4 border-amber-100 text-amber-700 rounded-full flex items-center justify-center text-lg md:text-3xl font-black shadow-sm mb-2 md:mb-4 hover:bg-amber-700 hover:text-white transition-colors duration-300">1</div>
                        <h4 class="font-bold text-gray-900 text-xs md:text-base leading-tight md:mb-2">Konsultasi</h4>
                        <p class="hidden md:block text-xs text-gray-500 px-2">Diskusi ukuran, desain, dan material sesuai kebutuhan.</p>
                    </div>
                    <div class="relative z-10 flex flex-col items-center text-center p-3 md:p-0 bg-white md:bg-transparent rounded-xl md:rounded-none shadow-sm md:shadow-none border md:border-none border-gray-100">
                        <div class="w-10 h-10 md:w-20 md:h-20 shrink-0 mx-auto bg-white border-4 border-amber-100 text-amber-700 rounded-full flex items-center justify-center text-lg md:text-3xl font-black shadow-sm mb-2 md:mb-4 hover:bg-amber-700 hover:text-white transition-colors duration-300">2</div>
                        <h4 class="font-bold text-gray-900 text-xs md:text-base leading-tight md:mb-2">Desain</h4>
                        <p class="hidden md:block text-xs text-gray-500 px-2">Pembuatan sketsa atau gambar 3D desain furniture.</p>
                    </div>
                    <div class="relative z-10 flex flex-col items-center text-center p-3 md:p-0 bg-white md:bg-transparent rounded-xl md:rounded-none shadow-sm md:shadow-none border md:border-none border-gray-100">
                        <div class="w-10 h-10 md:w-20 md:h-20 shrink-0 mx-auto bg-white border-4 border-amber-100 text-amber-700 rounded-full flex items-center justify-center text-lg md:text-3xl font-black shadow-sm mb-2 md:mb-4 hover:bg-amber-700 hover:text-white transition-colors duration-300">3</div>
                        <h4 class="font-bold text-gray-900 text-xs md:text-base leading-tight md:mb-2">Produksi</h4>
                        <p class="hidden md:block text-xs text-gray-500 px-2">Pengerjaan oleh tenaga ahli berpengalaman.</p>
                    </div>
                    <div class="relative z-10 flex flex-col items-center text-center p-3 md:p-0 bg-white md:bg-transparent rounded-xl md:rounded-none shadow-sm md:shadow-none border md:border-none border-gray-100">
                        <div class="w-10 h-10 md:w-20 md:h-20 shrink-0 mx-auto bg-white border-4 border-amber-100 text-amber-700 rounded-full flex items-center justify-center text-lg md:text-3xl font-black shadow-sm mb-2 md:mb-4 hover:bg-amber-700 hover:text-white transition-colors duration-300">4</div>
                        <h4 class="font-bold text-gray-900 text-xs md:text-base leading-tight md:mb-2">Quality Check</h4>
                        <p class="hidden md:block text-xs text-gray-500 px-2">Pengecekan kualitas sebelum pengiriman.</p>
                    </div>
                    <div class="relative z-10 flex flex-col items-center text-center p-3 md:p-0 bg-white md:bg-transparent rounded-xl md:rounded-none shadow-sm md:shadow-none border md:border-none border-gray-100 col-span-2 md:col-span-1">
                        <div class="w-10 h-10 md:w-20 md:h-20 shrink-0 mx-auto text-white rounded-full flex items-center justify-center text-lg md:text-3xl font-black shadow-lg mb-2 md:mb-4"
                             style="background: linear-gradient(135deg, #7a4520, #a0612a); box-shadow: 0 0 20px rgba(160,97,42,0.4);">
                            <i class='bx bx-check'></i>
                        </div>
                        <h4 class="font-bold text-amber-700 text-xs md:text-base leading-tight md:mb-2">Instalasi</h4>
                        <p class="hidden md:block text-xs text-gray-500 px-2">Pemasangan di lokasi Anda hingga selesai dan rapi.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── CTA ─── --}}
        <section class="cta-furniture py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="absolute top-0 right-0 w-[600px] h-[600px] rounded-full blur-[160px] opacity-15" style="background:#d4a96a;"></div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/20 bg-white/10 backdrop-blur-sm mb-6">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span class="text-amber-300 text-xs font-semibold tracking-widest uppercase">Interior S2 Bandar Lampung</span>
                </div>

                <h2 class="font-playfair text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">
                    Wujudkan Hunian Impian<br>Anda Bersama Kami
                </h2>

                <p class="text-white/70 text-lg mb-10 max-w-2xl mx-auto leading-relaxed">
                    Konsultasikan kebutuhan furniture Anda sekarang. Tim kami siap membantu menciptakan ruang yang indah, fungsional, dan sesuai anggaran.
                </p>

                <div class="flex flex-wrap justify-center gap-4">
                    <a href="https://wa.me/6285366114312?text=Halo%20Interior%20S2%2C%20saya%20ingin%20konsultasi%20furniture%20custom%20untuk%20rumah%20saya."
                       target="_blank"
                       class="inline-flex items-center gap-2 px-10 py-4 bg-white hover:bg-gray-50 text-amber-800 rounded-full font-black text-lg transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1">
                        <i class='bx bxl-whatsapp text-2xl text-green-500'></i> Chat WhatsApp Sekarang
                    </a>
                    <a href="tel:+6285366114312"
                       class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-full font-bold text-lg border border-white/20 transition-all hover:-translate-y-1">
                        <i class='bx bx-phone text-xl'></i> 0853-6611-4312
                    </a>
                </div>

                <div class="mt-12 flex flex-wrap justify-center gap-6 text-white/60 text-sm">
                    <div class="flex items-center gap-2">
                        <i class='bx bx-map text-amber-400'></i>
                        <span>Jl. Terusan Pulau Singkep, Saba Balau, Sukabumi, Bandar Lampung</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class='bx bx-time-five text-amber-400'></i>
                        <span>Buka 09.00 – 17.00 WIB</span>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <x-footer />
    <x-mobile-bottom-nav />

</body>
</html>
