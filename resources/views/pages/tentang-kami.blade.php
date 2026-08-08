<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - LKTech TN SEREAL</title>
    <meta name="description" content="Mengenal lebih dekat perjalanan, visi, misi, dan komitmen LKTech TN SEREAL sebagai mitra solusi teknologi informasi terpadu di Bogor dan seluruh Nusantara.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], montserrat: ['Montserrat', 'sans-serif'] },
                    colors: { brand: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' } }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">
    <x-navbar />
    <main class="flex-grow w-full pb-20 md:pb-0">

        {{-- ─── HERO HEADER ─────────────────────────────── --}}
        <div class="relative bg-gradient-to-r from-blue-50 via-cyan-50/70 to-emerald-50 py-4 md:py-10 px-4 sm:px-6 lg:px-8 text-center border-b border-cyan-100/70 w-full overflow-hidden">
            <div class="absolute -top-10 -left-10 w-48 h-48 bg-blue-200/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-emerald-200/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="inline-flex items-center gap-2 bg-blue-500/10 border border-blue-200/60 text-blue-600 text-[11px] font-semibold px-4 py-1.5 rounded-full mb-1 md:mb-3 select-none">
                <i class='bx bx-buildings text-sm'></i>
                Tentang LKTech
            </div>
            <h1 class="text-xl md:text-3xl font-black font-montserrat text-blue-900 mt-1 md:mt-0 mb-0 md:mb-2 tracking-tight">Kisah LKTech</h1>
            <p class="text-gray-600 text-[11px] md:text-sm max-w-2xl mx-auto leading-tight md:leading-relaxed truncate">Perjalanan dan komitmen terbaik kami untuk Anda.</p>
        </div>

        {{-- ─── MAIN CONTENT ─────────────────────────── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 md:py-8 lg:py-12 space-y-10 lg:space-y-16">

            {{-- ① KISAH KAMI — 2-Column Layout --}}
            <section>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-12 items-center">
                    {{-- Left: Photo --}}
                    <div class="lg:col-span-5">
                        <div class="relative">
                            <img src="{{ asset('images/TentangKami.webp') }}"
                                 alt="Tim LKTech TN SEREAL"
                                 class="w-full h-56 lg:h-auto object-cover rounded-2xl shadow-lg hover:scale-[1.02] transition duration-300">
                            <div class="absolute -bottom-4 -right-4 bg-white rounded-2xl shadow-md px-4 py-3 flex items-center gap-3 border border-gray-100">
                                <div class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center text-white text-lg shrink-0">
                                    <i class='bx bx-calendar-check'></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Berdiri Sejak</p>
                                    <p class="text-sm font-black text-gray-900 font-montserrat">2020</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Right: Story --}}
                    <div class="lg:col-span-7 text-center kisah-kami-content">
                        <div class="space-y-4 text-slate-600 text-sm md:text-base leading-[1.7] text-justify">
                            <p>Berawal dari sebuah komitmen untuk menghadirkan perangkat teknologi yang terjangkau namun berkualitas premium, <strong class="text-gray-800">LKTech</strong> lahir sebagai solusi tepercaya bagi masyarakat dan instansi di wilayah Bogor dan sekitarnya. Kami memulai langkah dengan spesialisasi pada penyediaan perangkat laptop standar tinggi yang wajib melewati proses <em>Quality Control</em> (QC) ketat, guna memastikan setiap unit yang diterima pelanggan selalu dalam kondisi prima dan siap tempur.</p>
                            <p>Seiring dengan pesatnya tuntutan era digital dan besarnya dukungan kepercayaan dari para pelanggan setia, <strong class="text-gray-800">LKTech</strong> kini telah bertransformasi menjadi penyedia solusi teknologi informasi terpadu <em>(One-Stop IT Solution)</em>. Jangkauan layanan kami telah berekspansi secara profesional, mencakup layanan perakitan PC <em>custom</em> berspesifikasi tinggi, serta penyedia jasa pembuatan <em>website</em> modern yang didedikasikan untuk membantu UMKM dan perusahaan melakukan digitalisasi bisnis dengan mudah, responsif, dan elegan.</p>
                            <p class="mb-0">Meskipun skala layanan kami semakin membesar, nilai inti fundamental LKTech tidak pernah bergeser. Kami selalu menomorsatukan layanan purna jual <em>(after-sales)</em> yang prima, jaminan garansi yang transparan, serta dukungan servis oleh teknisi ahli yang berpengalaman. Di LKTech, kami tidak sekadar menjual produk; kami hadir untuk membangun kemitraan teknologi jangka panjang yang berlandaskan prinsip kepercayaan, kemudahan, dan kepuasan Anda sebagai prioritas utama.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ② VISI & MISI — 2 Side-by-Side Cards --}}
            <section>
                <div class="text-center mb-5 lg:mb-8">
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 font-montserrat tracking-tight">Visi &amp; Misi Kami</h2>
                    <p class="text-gray-500 text-sm mt-2">Prinsip yang memandu setiap langkah LKTech.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-8">
                    {{-- Visi Card --}}
                    <div class="bg-gradient-to-br from-blue-50/60 to-slate-50 border border-blue-100 rounded-2xl p-5 lg:p-8 shadow-sm hover:-translate-y-1 hover:shadow-md transition duration-300">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-12 h-12 bg-brand-600 text-white rounded-xl flex items-center justify-center text-2xl shadow-md shrink-0">
                                <i class='bx bx-target-lock'></i>
                            </div>
                            <h3 class="text-xl font-black text-blue-900 font-montserrat">Visi</h3>
                        </div>
                        <p class="text-gray-700 text-sm leading-relaxed">Menjadi mitra solusi teknologi informasi terpadu <em>(One-Stop IT Solution)</em> yang tepercaya, baik di wilayah Bogor dan sekitarnya, maupun di seluruh Nusantara, guna mendukung produktivitas harian dan pertumbuhan bisnis pelanggan.</p>
                    </div>
                    {{-- Misi Card --}}
                    <div class="bg-gradient-to-br from-blue-50/60 to-slate-50 border border-blue-100 rounded-2xl p-5 lg:p-8 shadow-sm hover:-translate-y-1 hover:shadow-md transition duration-300">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-12 h-12 bg-emerald-600 text-white rounded-xl flex items-center justify-center text-2xl shadow-md shrink-0">
                                <i class='bx bx-rocket'></i>
                            </div>
                            <h3 class="text-xl font-black text-blue-900 font-montserrat">Misi</h3>
                        </div>
                        <ul class="space-y-3 text-gray-700 text-sm leading-relaxed">
                            <li class="flex items-start gap-2.5">
                                <i class='bx bx-check-circle text-brand-600 text-lg mt-0.5 shrink-0'></i>
                                <span><strong>Penyediaan Perangkat Andal:</strong> Menghadirkan perangkat keras berkualitas tinggi, mulai dari laptop second premium hingga perakitan PC custom yang disesuaikan kebutuhan pelanggan.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <i class='bx bx-check-circle text-brand-600 text-lg mt-0.5 shrink-0'></i>
                                <span><strong>Solusi Digital Terdepan:</strong> Membantu UMKM dan perusahaan go-digital melalui jasa pembuatan website profesional yang modern, responsif, dan siap bersaing.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <i class='bx bx-check-circle text-brand-600 text-lg mt-0.5 shrink-0'></i>
                                <span><strong>Layanan Purna Jual &amp; Servis Unggul:</strong> Memberikan dukungan teknis terbaik melalui layanan servis, maintenance, dan garansi yang transparan.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <i class='bx bx-check-circle text-brand-600 text-lg mt-0.5 shrink-0'></i>
                                <span><strong>Kualitas Tanpa Kompromi:</strong> Menerapkan proses Quality Control (QC) ketat di setiap produk dan layanan demi kepuasan dan kepercayaan pelanggan.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            {{-- ③ MENGAPA MEMILIH KAMI — 4-Column Grid --}}
            <section class="pb-2 lg:pb-6">
                <div class="text-center mb-5 lg:mb-8">
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 font-montserrat tracking-tight">Mengapa Memilih LKTech?</h2>
                    <p class="text-gray-500 text-sm mt-2">Keunggulan nyata yang membedakan kami dari yang lain.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 lg:gap-6">
                    {{-- Card 1 --}}
                    <div class="bg-white rounded-2xl md:rounded-3xl p-4 lg:p-6 border border-gray-100 shadow-sm hover:-translate-y-2 hover:shadow-xl hover:border-emerald-200 transition-all duration-300 group flex flex-row md:flex-col items-start md:items-center text-left md:text-center">
                        <div class="shrink-0 w-11 h-11 lg:w-14 lg:h-14 bg-emerald-50 group-hover:bg-emerald-100 text-emerald-600 rounded-xl md:rounded-2xl flex items-center justify-center text-xl lg:text-2xl mr-3 md:mr-0 mb-0 md:mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm">
                            <i class='bx bx-check-shield'></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-1 md:mb-2 text-sm lg:text-base group-hover:text-emerald-700 transition-colors duration-300 font-montserrat">Quality Control Ketat</h4>
                            <p class="text-[13px] lg:text-xs text-gray-500 leading-snug lg:leading-relaxed">Setiap produk melewati 2 lapis pengujian teknis untuk memastikan performa dan fisik maksimal.</p>
                        </div>
                    </div>
                    {{-- Card 2 --}}
                    <div class="bg-white rounded-2xl md:rounded-3xl p-4 lg:p-6 border border-gray-100 shadow-sm hover:-translate-y-2 hover:shadow-xl hover:border-blue-200 transition-all duration-300 group flex flex-row md:flex-col items-start md:items-center text-left md:text-center">
                        <div class="shrink-0 w-11 h-11 lg:w-14 lg:h-14 bg-blue-50 group-hover:bg-blue-100 text-brand-600 rounded-xl md:rounded-2xl flex items-center justify-center text-xl lg:text-2xl mr-3 md:mr-0 mb-0 md:mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm">
                            <i class='bx bx-money'></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-1 md:mb-2 text-sm lg:text-base group-hover:text-brand-600 transition-colors duration-300 font-montserrat">Harga Transparan</h4>
                            <p class="text-[13px] lg:text-xs text-gray-500 leading-snug lg:leading-relaxed">Penawaran harga terbaik dan sangat bersaing di pasaran tanpa adanya biaya tersembunyi.</p>
                        </div>
                    </div>
                    {{-- Card 3 --}}
                    <div class="bg-white rounded-2xl md:rounded-3xl p-4 lg:p-6 border border-gray-100 shadow-sm hover:-translate-y-2 hover:shadow-xl hover:border-purple-200 transition-all duration-300 group flex flex-row md:flex-col items-start md:items-center text-left md:text-center">
                        <div class="shrink-0 w-11 h-11 lg:w-14 lg:h-14 bg-purple-50 group-hover:bg-purple-100 text-purple-600 rounded-xl md:rounded-2xl flex items-center justify-center text-xl lg:text-2xl mr-3 md:mr-0 mb-0 md:mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm">
                            <i class='bx bx-support'></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-1 md:mb-2 text-sm lg:text-base group-hover:text-purple-600 transition-colors duration-300 font-montserrat">Layanan Purna Jual</h4>
                            <p class="text-[13px] lg:text-xs text-gray-500 leading-snug lg:leading-relaxed">Dukungan teknisi after-sales yang ramah, cepat tanggap, dan senantiasa siap membantu.</p>
                        </div>
                    </div>
                    {{-- Card 4 --}}
                    <div class="bg-white rounded-2xl md:rounded-3xl p-4 lg:p-6 border border-gray-100 shadow-sm hover:-translate-y-2 hover:shadow-xl hover:border-amber-200 transition-all duration-300 group flex flex-row md:flex-col items-start md:items-center text-left md:text-center">
                        <div class="shrink-0 w-11 h-11 lg:w-14 lg:h-14 bg-amber-50 group-hover:bg-amber-100 text-amber-600 rounded-xl md:rounded-2xl flex items-center justify-center text-xl lg:text-2xl mr-3 md:mr-0 mb-0 md:mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm">
                            <i class='bx bx-map-pin'></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-1 md:mb-2 text-sm lg:text-base group-hover:text-amber-600 transition-colors duration-300 font-montserrat">Jangkauan Luas</h4>
                            <p class="text-[13px] lg:text-xs text-gray-500 leading-snug lg:leading-relaxed">Melayani pelanggan di Bogor dan sekitarnya, kini juga siap melayani seluruh wilayah Indonesia.</p>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>
    <x-footer />
    <x-mobile-bottom-nav />
</body>
</html>
