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

        /* ── Hero Visual Showcase ── */
        .hero-visual-wrapper {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
        }

        .hero-image-frame {
            width: 320px;
            height: 320px;
            border-radius: 50%;
            border: 6px solid rgba(255, 255, 255, 0.15);
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            animation: floatAnim 4s ease-in-out infinite;
        }

        .hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .hero-image-frame:hover .hero-img {
            transform: scale(1.08);
        }

        .floating-badge {
            position: absolute;
            background: #ffffff;
            color: #1e293b;
            padding: 8px 16px;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 10;
            font-weight: 700;
            font-size: 0.75rem;
        }

        .badge-top {
            top: 20px;
            right: -10px;
            background: #fef08a;
            color: #854d0e;
            animation: floatAnim 3s ease-in-out infinite reverse;
        }

        .badge-bottom {
            bottom: 25px;
            left: -10px;
            background: #ffffff;
            animation: floatAnim 3.5s ease-in-out infinite 0.5s;
        }

        .badge-bottom small {
            display: block;
            font-size: 0.65rem;
            color: #64748b;
            font-weight: normal;
        }

        @keyframes floatAnim {
            0%, 100% { transform: translateY(0px); }
            50%      { transform: translateY(-10px); }
        }

        @media (max-width: 1023px) {
            .hero-visual-wrapper {
                margin-top: 40px;
            }
            .hero-image-frame {
                width: 260px;
                height: 260px;
            }
        }
    </style>
</head>
<body class="bg-stone-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <x-navbar />

    <main class="flex-grow w-full pb-20 md:pb-0">

        {{-- ─── HERO ─── --}}
        <section class="hero-furniture min-h-[60vh] md:min-h-[65vh] flex items-center relative">
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-[120px] opacity-20" style="background:#c08040;"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full blur-[100px] opacity-15" style="background:#d4a96a;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-20 pb-10 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    {{-- Text content --}}
                    <div class="lg:col-span-7">
                        <div class="inline-flex flex-wrap items-center gap-2 px-3.5 py-1.5 rounded-full border border-white/20 bg-white/10 backdrop-blur-sm mb-4 fade-up text-xs font-medium text-amber-200">
                            <span class="flex items-center gap-1"><i class='bx bx-map text-amber-400 text-sm'></i> Bandar Lampung</span>
                            <span class="text-white/30">•</span>
                            <span class="flex items-center gap-1"><i class='bx bx-time-five text-amber-400 text-sm'></i> Sen-Sab: 09.00 - 17.00 WIB</span>
                        </div>

                        <h1 class="font-montserrat text-3xl md:text-5xl lg:text-6xl font-black text-white leading-tight mb-3 tracking-tight fade-up delay-1">
                            Furniture Custom<br class="hidden sm:inline">
                            <span class="badge-shimmer">Bandar Lampung</span>
                        </h1>

                        <p class="text-white/90 text-sm leading-relaxed mb-6 max-w-xl fade-up delay-2">
                            Wujudkan interior impian Anda dengan presisi. Kami memproduksi kitchen set, kamar set, hingga backdrop TV berkualitas tinggi yang didesain khusus sesuai ruangan Anda.
                        </p>

                        <div class="grid grid-cols-2 gap-3 max-w-md fade-up delay-3">
                            <a href="https://wa.me/6285366114312?text=Halo%20Interior%20S2%2C%20saya%20ingin%20konsultasi%20mengenai%20furniture%20custom." target="_blank"
                               class="flex items-center justify-center gap-1.5 py-3 px-4 bg-green-500 hover:bg-green-400 text-white font-bold rounded-xl transition-all shadow-md hover:-translate-y-0.5 text-xs sm:text-sm">
                                <i class='bx bxl-whatsapp text-lg'></i> Konsultasi WA
                            </a>
                            <a href="#galeri"
                               class="flex items-center justify-center gap-1.5 py-3 px-4 bg-amber-500 hover:bg-amber-400 text-white font-bold rounded-xl transition-all shadow-md hover:-translate-y-0.5 text-xs sm:text-sm">
                                <i class='bx bx-images text-lg'></i> Lihat Portofolio
                            </a>
                        </div>
                    </div>

                    {{-- Visual Showcase --}}
                    <div class="lg:col-span-5 flex justify-center fade-up delay-2">
                        <div class="hero-visual-wrapper">
                            <!-- Badge Melayang Atas Kanan -->
                            <div class="floating-badge badge-top">
                                <span>✨ Free Desain 3D</span>
                            </div>

                            <!-- Foto Utama Dalam Frame Melingkar -->
                            <div class="hero-image-frame">
                                <img src="{{ asset('images/furniture/kitchen-set/kitchen-1.webp') }}" alt="Furniture Custom Bandar Lampung" class="hero-img">
                            </div>

                            <!-- Badge Melayang Bawah Kiri -->
                            <div class="floating-badge badge-bottom">
                                <div class="badge-icon">🛠️</div>
                                <div class="badge-text">
                                    <strong>100+ Project</strong>
                                    <small>Interior Terpasang</small>
                                </div>
                            </div>
                        </div>
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
        <section class="bg-white py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-2 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Kategori Layanan</span>
                    <h2 class="font-montserrat text-2xl md:text-3xl font-black text-gray-900 mb-2 tracking-tight">Layanan Furniture Kami</h2>
                    <p class="text-gray-500 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">Interior S2 menghadirkan beragam solusi furniture berkualitas tinggi untuk melengkapi hunian Anda.</p>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- Kitchen Set --}}
                    <div class="group relative rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 aspect-square">
                        <img src="{{ asset('images/furniture/kitchen-set/kitchen-1.webp') }}" alt="Kitchen Set Custom" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-end p-3.5">
                            <span class="text-[9px] font-black text-amber-400 uppercase tracking-widest leading-none">Dapur Modern</span>
                            <h3 class="font-montserrat font-bold text-white text-xs sm:text-sm mt-1">Kitchen Set</h3>
                        </div>
                    </div>

                    {{-- Kamar Set --}}
                    <div class="group relative rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 aspect-square">
                        <img src="{{ asset('images/furniture/kamar-set/kamar-2.webp') }}" alt="Kamar Set Elegan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-end p-3.5">
                            <span class="text-[9px] font-black text-amber-400 uppercase tracking-widest leading-none">Kamar Utama</span>
                            <h3 class="font-montserrat font-bold text-white text-xs sm:text-sm mt-1">Kamar Set</h3>
                        </div>
                    </div>

                    {{-- Backdrop TV --}}
                    <div class="group relative rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 aspect-square">
                        <img src="{{ asset('images/furniture/backdrop-tv/backdrop-1.webp') }}" alt="Backdrop TV Premium" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-end p-3.5">
                            <span class="text-[9px] font-black text-amber-400 uppercase tracking-widest leading-none">Panel Dinding</span>
                            <h3 class="font-montserrat font-bold text-white text-xs sm:text-sm mt-1">Backdrop TV</h3>
                        </div>
                    </div>

                    {{-- Interior Custom --}}
                    <div class="group relative rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 aspect-square">
                        <img src="{{ asset('images/furniture/kamar-set/kamar-4.webp') }}" alt="Lemari & Interior Custom" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-end p-3.5">
                            <span class="text-[9px] font-black text-amber-400 uppercase tracking-widest leading-none">Solusi Ruang</span>
                            <h3 class="font-montserrat font-bold text-white text-xs sm:text-sm mt-1">Interior Custom</h3>
                        </div>
                    </div>
                </div>
                </div>
         {{-- ─── GALERI ─── --}}
        <section id="galeri" class="bg-stone-50 py-16"
            x-data="{
                activeTab: 'all',
                lightbox: false,
                lightboxSrc: '',
                lightboxTitle: '',
                lightboxDesc: '',
                lightboxMaterial: '',
                openLightbox(src, title, desc, material) {
                    this.lightboxSrc = src;
                    this.lightboxTitle = title;
                    this.lightboxDesc = desc;
                    this.lightboxMaterial = material;
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
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-2 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Portofolio Kami</span>
                    <h2 class="font-montserrat text-2xl md:text-3xl font-black text-gray-900 mb-2 tracking-tight">Galeri Hasil Karya</h2>
                    <p class="text-gray-500 text-xs sm:text-sm max-w-xl mx-auto">Tap foto untuk melihat detail bahan, spesifikasi, dan konsultasi harga langsung.</p>
                </div>

                <!-- Filter Tabs (Horizontal Scrollable on Mobile) -->
                <div class="flex overflow-x-auto whitespace-nowrap gap-2 pb-3 mb-8 no-scrollbar scroll-smooth justify-start md:justify-center">
                    <button @click="activeTab='all'"      :class="activeTab==='all'      ? 'active' : ''" class="tab-btn py-1.5 px-4 text-xs">Semua</button>
                    <button @click="activeTab='kitchen'"  :class="activeTab==='kitchen'  ? 'active' : ''" class="tab-btn py-1.5 px-4 text-xs">Kitchen Set</button>
                    <button @click="activeTab='kamar'"    :class="activeTab==='kamar'    ? 'active' : ''" class="tab-btn py-1.5 px-4 text-xs">Kamar Set</button>
                    <button @click="activeTab='backdrop'" :class="activeTab==='backdrop' ? 'active' : ''" class="tab-btn py-1.5 px-4 text-xs">Backdrop TV</button>
                </div>

                <!-- Grid Gallery -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @php
                        $kitchenImages = [
                            ['src'=>'images/furniture/kitchen-set/kitchen-1.webp','alt'=>'Kitchen Set Custom Minimalis', 'desc'=>'Dapur modern dengan cabinet multifungsi dan meja bar kompak.', 'material'=>'Multiplex 18mm & HPL Taco Premium'],
                            ['src'=>'images/furniture/kitchen-set/kitchen-2.webp','alt'=>'Kitchen Set Clean White', 'desc'=>'Dapur bernuansa putih bersih dengan finishing anti gores dan laci soft-close.', 'material'=>'Blockboard Melamin & HPL Glossy'],
                            ['src'=>'images/furniture/kitchen-set/kitchen-3.webp','alt'=>'Kitchen Set Classic Modern', 'desc'=>'Sentuhan profil mewah dengan perpaduan warna abu-abu elegan dan top table marmer.', 'material'=>'Multiplex 18mm & Cat Duco Polyurethane'],
                        ];
                        $kamarImages = [
                            ['src'=>'images/furniture/kamar-set/kamar-1.webp', 'alt'=>'Kamar Set Minimalis Cozy', 'desc'=>'Tempat tidur dengan storage laci bawah dipadu lemari pakaian sliding pintu kaca.', 'material'=>'Multiplex & Finishing HPL Serat Kayu'],
                            ['src'=>'images/furniture/kamar-set/kamar-2.webp', 'alt'=>'Kamar Set Luxury Master', 'desc'=>'Kamar tidur utama dengan headboard busa tinggi, list stainless gold, dan nakas gantung.', 'material'=>'Multiplex, Busa Velvet & Finishing HPL'],
                            ['src'=>'images/furniture/kamar-set/kamar-3.webp', 'alt'=>'Kamar Set Anak Multifungsi', 'desc'=>'Ranjang tingkat anak dengan tangga laci dan meja belajar terintegrasi.', 'material'=>'Multiplex & Finishing HPL Colorful'],
                            ['src'=>'images/furniture/kamar-set/kamar-4.webp', 'alt'=>'Wardrobe Walk-in Closet', 'desc'=>'Lemari pakaian besar tanpa pintu dengan gantungan hanger dan rak aksesoris.', 'material'=>'Multiplex & HPL Premium'],
                            ['src'=>'images/furniture/kamar-set/kamar-5.webp', 'alt'=>'Tempat Tidur Platform Minimalis', 'desc'=>'Ranjang kayu rendah dengan panel dinding kisi-kisi dan lampu tidur tersembunyi.', 'material'=>'Multiplex & HPL Motif Kayu'],
                            ['src'=>'images/furniture/kamar-set/kamar-6.webp', 'alt'=>'Lemari Pakaian Tanam (Built-in)', 'desc'=>'Lemari pakaian full plafon menyatu dengan dinding kamar secara rapi.', 'material'=>'Blockboard & HPL Soft Touch'],
                            ['src'=>'images/furniture/kamar-set/kamar-7.webp', 'alt'=>'Nakas Kamar Gantung', 'desc'=>'Meja samping tempat tidur minimalis melayang dengan laci penyimpanan.', 'material'=>'Multiplex & Finishing HPL'],
                            ['src'=>'images/furniture/kamar-set/kamar-8.webp', 'alt'=>'Meja Rias Custom LED Mirror', 'desc'=>'Meja rias dengan cermin bulat lampu LED dan laci organizer kosmetik.', 'material'=>'Multiplex & Finishing HPL Matte'],
                            ['src'=>'images/furniture/kamar-set/kamar-9.webp', 'alt'=>'Kamar Set Klasik Mewah', 'desc'=>'Detail ukiran profil klasik dengan finishing cat duco broken white.', 'material'=>'Kayu Mahoni & Cat Duco Semi Gloss'],
                            ['src'=>'images/furniture/kamar-set/kamar-10.webp','alt'=>'Daybed Storage Multifungsi', 'desc'=>'Ranjang santai di sudut jendela dengan laci penyimpanan selimut di bawahnya.', 'material'=>'Multiplex & Finishing HPL'],
                            ['src'=>'images/furniture/kamar-set/kamar-11.webp','alt'=>'Lemari Pakaian Sliding Glass', 'desc'=>'Lemari pakaian dengan pintu geser kaca tempered hitam yang maskulin.', 'material'=>'Multiplex, Alumunium Frame & Kaca Tinted'],
                            ['src'=>'images/furniture/kamar-set/kamar-11.webp','alt'=>'Headboard Panel Kisi-kisi', 'desc'=>'Panel dinding dekoratif bermotif kisi-kisi kayu di belakang tempat tidur.', 'material'=>'Multiplex & HPL Serat Kayu'],
                        ];
                        $backdropImages = [
                            ['src'=>'images/furniture/backdrop-tv/backdrop-1.webp','alt'=>'Backdrop TV Minimalis LED', 'desc'=>'Panel TV gantung dengan ambalan pajangan dan lampu LED strip hangat.', 'material'=>'Multiplex & Finishing HPL'],
                            ['src'=>'images/furniture/backdrop-tv/backdrop-2.webp','alt'=>'Backdrop TV Luxury Marmer', 'desc'=>'Desain mewah menggunakan kombinasi PVC sheet motif marmer dan list gold.', 'material'=>'Multiplex, PVC Board & List Gold Stainless'],
                            ['src'=>'images/furniture/backdrop-tv/backdrop-3.webp','alt'=>'Backdrop TV Sekat Ruangan', 'desc'=>'Backdrop TV dua sisi yang berfungsi ganda sebagai penyekat ruang tamu dan ruang keluarga.', 'material'=>'Multiplex & Finishing HPL Serat Kayu'],
                            ['src'=>'images/furniture/backdrop-tv/backdrop-4.webp','alt'=>'Backdrop TV Gantung Modern', 'desc'=>'Cabinet TV melayang dengan desain laci minimalis dan lubang kabel rapi.', 'material'=>'Multiplex & HPL Matte White & Wood'],
                        ];
                    @endphp

                    @foreach($kitchenImages as $img)
                    <div class="relative overflow-hidden rounded-2xl cursor-pointer aspect-square group shadow-sm hover:shadow-md transition-all duration-300"
                         x-show="activeTab==='all'||activeTab==='kitchen'"
                         @click="openLightbox('{{ asset($img['src']) }}', '{{ $img['alt'] }}', '{{ $img['desc'] }}', '{{ $img['material'] }}')"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100">
                        <img src="{{ asset($img['src']) }}" alt="{{ $img['alt'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-3">
                            <p class="text-white font-bold text-xs sm:text-sm leading-snug line-clamp-2">{{ $img['alt'] }}</p>
                            <span class="text-white/60 text-[9px] sm:text-[10px] mt-0.5">Kitchen Set • Interior S2</span>
                        </div>
                    </div>
                    @endforeach

                    @foreach($kamarImages as $img)
                    <div class="relative overflow-hidden rounded-2xl cursor-pointer aspect-square group shadow-sm hover:shadow-md transition-all duration-300"
                         x-show="activeTab==='all'||activeTab==='kamar'"
                         @click="openLightbox('{{ asset($img['src']) }}', '{{ $img['alt'] }}', '{{ $img['desc'] }}', '{{ $img['material'] }}')"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100">
                        <img src="{{ asset($img['src']) }}" alt="{{ $img['alt'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-3">
                            <p class="text-white font-bold text-xs sm:text-sm leading-snug line-clamp-2">{{ $img['alt'] }}</p>
                            <span class="text-white/60 text-[9px] sm:text-[10px] mt-0.5">Kamar Set • Interior S2</span>
                        </div>
                    </div>
                    @endforeach

                    @foreach($backdropImages as $img)
                    <div class="relative overflow-hidden rounded-2xl cursor-pointer aspect-square group shadow-sm hover:shadow-md transition-all duration-300"
                         x-show="activeTab==='all'||activeTab==='backdrop'"
                         @click="openLightbox('{{ asset($img['src']) }}', '{{ $img['alt'] }}', '{{ $img['desc'] }}', '{{ $img['material'] }}')"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100">
                        <img src="{{ asset($img['src']) }}" alt="{{ $img['alt'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-3">
                            <p class="text-white font-bold text-xs sm:text-sm leading-snug line-clamp-2">{{ $img['alt'] }}</p>
                            <span class="text-white/60 text-[9px] sm:text-[10px] mt-0.5">Backdrop TV • Interior S2</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Lightbox Modal --}}
            <div x-show="lightbox" class="fixed inset-0 bg-black/90 z-[9999] flex items-center justify-center p-4 overflow-y-auto" @click.self="closeLightbox()" @keydown.escape.window="closeLightbox()" x-cloak>
                <div class="relative bg-stone-900 border border-stone-850 rounded-3xl overflow-hidden max-w-sm w-full shadow-2xl my-auto">
                    <div class="relative h-48 sm:h-64 w-full shrink-0">
                        <img :src="lightboxSrc" :alt="lightboxTitle" class="w-full h-full object-cover">
                        <button @click="closeLightbox()" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-black/60 hover:bg-black/80 flex items-center justify-center text-white transition-all shadow-md z-10">
                            <i class='bx bx-x text-2xl'></i>
                        </button>
                    </div>
                    <div class="p-5 text-left">
                        <span class="text-amber-400 font-extrabold text-xs block mb-1 uppercase tracking-wider" x-text="lightboxMaterial"></span>
                        <h3 class="text-white font-black text-lg mb-2 font-montserrat" x-text="lightboxTitle"></h3>
                        <p class="text-stone-300 text-xs sm:text-sm leading-relaxed mb-5" x-text="lightboxDesc"></p>

                        <a :href="'https://wa.me/6285366114312?text=Halo%20Interior%20S2%2C%20saya%20tertarik%20dengan%20model%20' + encodeURIComponent(lightboxTitle) + '%20dan%20ingin%20tanya%20estimasi%20harganya.'" target="_blank"
                           class="flex items-center justify-center gap-2 w-full py-3 bg-green-500 hover:bg-green-400 text-white font-bold rounded-xl transition-all shadow-lg text-sm">
                            <i class='bx bxl-whatsapp text-lg'></i> Tanya Estimasi Harga via WA
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
                    <h2 class="font-montserrat text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight">Keunggulan Interior S2</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Kepuasan pelanggan adalah prioritas utama kami dalam setiap proyek furniture.</p>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-stone-50 rounded-2xl p-4 border border-stone-100 hover:shadow-lg transition-all hover:-translate-y-0.5 group">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-lg shadow-sm shrink-0 group-hover:scale-105 transition-transform"><i class='bx bx-ruler'></i></div>
                            <h3 class="font-montserrat font-bold text-gray-900 text-xs sm:text-sm leading-tight">Custom Ukuran</h3>
                        </div>
                        <p class="text-gray-500 text-[11px] sm:text-xs leading-relaxed">Dibuat sesuai dimensi ruangan Anda agar pas dan fungsional.</p>
                    </div>
                    <div class="bg-stone-50 rounded-2xl p-4 border border-stone-100 hover:shadow-lg transition-all hover:-translate-y-0.5 group">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center text-lg shadow-sm shrink-0 group-hover:scale-105 transition-transform"><i class='bx bx-shield-quarter'></i></div>
                            <h3 class="font-montserrat font-bold text-gray-900 text-xs sm:text-sm leading-tight">Bahan Premium</h3>
                        </div>
                        <p class="text-gray-500 text-[11px] sm:text-xs leading-relaxed">Multiplex tebal dan finishing HPL berkualitas anti gores.</p>
                    </div>
                    <div class="bg-stone-50 rounded-2xl p-4 border border-stone-100 hover:shadow-lg transition-all hover:-translate-y-0.5 group">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-sm shrink-0 group-hover:scale-105 transition-transform"><i class='bx bxs-paint'></i></div>
                            <h3 class="font-montserrat font-bold text-gray-900 text-xs sm:text-sm leading-tight">Finishing Rapi</h3>
                        </div>
                        <p class="text-gray-500 text-[11px] sm:text-xs leading-relaxed">Pengerjaan detil, edging rapi, dan engsel soft-close awet.</p>
                    </div>
                    <div class="bg-stone-50 rounded-2xl p-4 border border-stone-100 hover:shadow-lg transition-all hover:-translate-y-0.5 group">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-lg shadow-sm shrink-0 group-hover:scale-105 transition-transform"><i class='bx bx-time'></i></div>
                            <h3 class="font-montserrat font-bold text-gray-900 text-xs sm:text-sm leading-tight">Tepat Waktu</h3>
                        </div>
                        <p class="text-gray-500 text-[11px] sm:text-xs leading-relaxed">Proses produksi teratur sesuai jadwal kesepakatan.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── PROSES PENGERJAAN ─── --}}
        <section class="bg-white py-10 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNFMkQ2QzUiLz48L3N2Zz4=')] opacity-60"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-14">
                    <span class="inline-block text-amber-700 font-bold tracking-widest uppercase text-[10px] mb-3 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Cara Kerja</span>
                    <h2 class="font-montserrat text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight">Proses Pengerjaan</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Kami memastikan setiap langkah berjalan transparan dan sesuai harapan Anda.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 relative">
                    <div class="hidden lg:block absolute top-10 left-[10%] right-[10%] h-0.5 z-0" style="background: linear-gradient(90deg, #e8c99a, #a0612a, #e8c99a);"></div>

                    {{-- Step 1 --}}
                    <div class="relative z-10 flex lg:flex-col items-center gap-3 lg:gap-0 p-3 lg:p-0 bg-stone-50 lg:bg-transparent rounded-2xl lg:rounded-none border lg:border-none border-stone-100">
                        <div class="w-9 h-9 lg:w-16 lg:h-16 shrink-0 lg:mx-auto bg-amber-100 lg:bg-white border-2 lg:border-4 border-amber-300 text-amber-800 rounded-full flex items-center justify-center text-sm lg:text-2xl font-black shadow-sm lg:mb-4">1</div>
                        <div class="text-left lg:text-center">
                            <h4 class="font-bold text-gray-900 text-xs lg:text-base leading-tight lg:mb-2">Konsultasi</h4>
                            <p class="text-[11px] lg:text-xs text-gray-500 leading-tight">Ukur ruangan, diskusikan desain, & pilih material.</p>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="relative z-10 flex lg:flex-col items-center gap-3 lg:gap-0 p-3 lg:p-0 bg-stone-50 lg:bg-transparent rounded-2xl lg:rounded-none border lg:border-none border-stone-100">
                        <div class="w-9 h-9 lg:w-16 lg:h-16 shrink-0 lg:mx-auto bg-amber-100 lg:bg-white border-2 lg:border-4 border-amber-300 text-amber-800 rounded-full flex items-center justify-center text-sm lg:text-2xl font-black shadow-sm lg:mb-4">2</div>
                        <div class="text-left lg:text-center">
                            <h4 class="font-bold text-gray-900 text-xs lg:text-base leading-tight lg:mb-2">Desain 3D</h4>
                            <p class="text-[11px] lg:text-xs text-gray-500 leading-tight">Sketsa konsep dan gambar layout 3D presisi.</p>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="relative z-10 flex lg:flex-col items-center gap-3 lg:gap-0 p-3 lg:p-0 bg-stone-50 lg:bg-transparent rounded-2xl lg:rounded-none border lg:border-none border-stone-100">
                        <div class="w-9 h-9 lg:w-16 lg:h-16 shrink-0 lg:mx-auto bg-amber-100 lg:bg-white border-2 lg:border-4 border-amber-300 text-amber-800 rounded-full flex items-center justify-center text-sm lg:text-2xl font-black shadow-sm lg:mb-4">3</div>
                        <div class="text-left lg:text-center">
                            <h4 class="font-bold text-gray-900 text-xs lg:text-base leading-tight lg:mb-2">Produksi</h4>
                            <p class="text-[11px] lg:text-xs text-gray-500 leading-tight">Fabrikasi oleh tukang kayu ahli berpengalaman.</p>
                        </div>
                    </div>

                    {{-- Step 4 --}}
                    <div class="relative z-10 flex lg:flex-col items-center gap-3 lg:gap-0 p-3 lg:p-0 bg-stone-50 lg:bg-transparent rounded-2xl lg:rounded-none border lg:border-none border-stone-100">
                        <div class="w-9 h-9 lg:w-16 lg:h-16 shrink-0 lg:mx-auto bg-amber-100 lg:bg-white border-2 lg:border-4 border-amber-300 text-amber-800 rounded-full flex items-center justify-center text-sm lg:text-2xl font-black shadow-sm lg:mb-4">4</div>
                        <div class="text-left lg:text-center">
                            <h4 class="font-bold text-gray-900 text-xs lg:text-base leading-tight lg:mb-2">Quality Control</h4>
                            <p class="text-[11px] lg:text-xs text-gray-500 leading-tight">Pemeriksaan detail finishing dan kelayakan fungsi.</p>
                        </div>
                    </div>

                    {{-- Step 5 --}}
                    <div class="relative z-10 flex lg:flex-col items-center gap-3 lg:gap-0 p-3 lg:p-0 bg-stone-50 lg:bg-transparent rounded-2xl lg:rounded-none border lg:border-none border-stone-100">
                        <div class="w-9 h-9 lg:w-16 lg:h-16 shrink-0 lg:mx-auto text-white rounded-full flex items-center justify-center text-sm lg:text-2xl font-black shadow-md"
                             style="background: linear-gradient(135deg, #7a4520, #a0612a); box-shadow: 0 0 12px rgba(160,97,42,0.3);">
                            <i class='bx bx-check text-base lg:text-3xl'></i>
                        </div>
                        <div class="text-left lg:text-center">
                            <h4 class="font-bold text-amber-800 text-xs lg:text-base leading-tight lg:mb-2">Instalasi</h4>
                            <p class="text-[11px] lg:text-xs text-gray-500 leading-tight">Pemasangan dan penyetelan rapi di lokasi Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── INFO TOKO ─── --}}
        <section class="bg-stone-50 py-10">
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

                    </div>

                    <!-- Maps -->
                    <div class="rounded-3xl overflow-hidden shadow-sm border border-stone-200 h-full min-h-[300px] md:min-h-[400px]">
                        <iframe
                            src="https://maps.google.com/maps?q=Saba+Balau+Sukabumi+Bandar+Lampung&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            class="w-full h-full border-0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Interior S2 Bandar Lampung">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─── CTA ─── --}}
        <section class="cta-furniture py-6 md:py-16 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="absolute top-0 right-0 w-[600px] h-[600px] rounded-full blur-[160px] opacity-15" style="background:#d4a96a;"></div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 md:px-4 md:py-2 rounded-full border border-white/20 bg-white/10 backdrop-blur-sm mb-2 md:mb-6">
                    <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span class="text-amber-300 text-[9px] md:text-xs font-semibold tracking-widest uppercase">Interior S2 Bandar Lampung</span>
                </div>

                <h2 class="font-playfair text-xl md:text-5xl font-bold text-white mb-2 md:mb-6 leading-tight mt-1 md:mt-0">
                    Wujudkan Hunian Impian<br class="md:hidden"> Anda Bersama Kami
                </h2>

                <p class="text-white/70 text-[11px] md:text-lg mb-4 md:mb-10 max-w-2xl mx-auto leading-[1.35] md:leading-relaxed px-2 md:px-0">
                    Konsultasikan kebutuhan furniture Anda sekarang. Tim kami siap membantu menciptakan ruang yang indah, fungsional, dan sesuai anggaran.
                </p>

                <div class="flex flex-wrap justify-center gap-2 md:gap-6 text-white/60 text-[10px] md:text-sm mt-2 md:mt-12">
                    <div class="flex items-center gap-1.5 md:gap-2">
                        <i class='bx bx-map text-amber-400'></i>
                        <span>Jl. Terusan Pulau Singkep, Saba Balau, Sukabumi, Bandar Lampung</span>
                    </div>
                    <span class="hidden md:inline">•</span>
                    <div class="flex items-center gap-1.5 md:gap-2">
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
