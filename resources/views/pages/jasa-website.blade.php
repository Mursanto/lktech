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
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 gap-4">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/LKtech.png') }}" alt="LKTech Logo" class="h-7 w-auto">
                        <span class="font-montserrat font-black text-xl tracking-tight text-blue-900 hidden sm:block">LKTech TN SEREAL</span>
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-6 text-sm font-bold text-gray-700">
                    <a href="{{ route('katalog.index') }}" class="hover:text-brand-600 transition-colors">Katalog</a>
                    <div class="relative group" x-data="{ open: false }" @mouseleave="open = false">
                        <button @mouseover="open = true" class="hover:text-brand-600 transition-colors flex items-center gap-1 text-brand-600">
                            Layanan <i class='bx bx-chevron-down text-lg'></i>
                        </button>
                        <div x-show="open" x-transition.opacity class="absolute top-full left-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-lg py-2 z-50" style="display: none;">
                            <a href="{{ route('rakit-pc') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">Rakit PC</a>
                            <a href="{{ route('jasa-website') }}" class="block px-4 py-2 text-sm text-brand-600 hover:bg-brand-50 hover:text-brand-700 transition-colors">Jasa Pembuatan Website</a>
                        </div>
                    </div>
                    <a href="{{ route('blog.index') }}" class="hover:text-brand-600 transition-colors">Blog & Panduan</a>
                    <a href="{{ route('tentang-kami') }}" class="hover:text-brand-600 transition-colors">Tentang Kami</a>
                </div>
                <div class="flex-shrink-0 flex items-center gap-3 md:hidden">
                    <a href="{{ route('katalog.index') }}" class="text-sm font-semibold text-gray-600 hover:text-brand-600">Ke Katalog</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow w-full">
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-gray-900 via-blue-900 to-brand-900 py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-30"></div>
            <!-- Decorative blur -->
            <div class="absolute top-0 left-10 w-96 h-96 bg-brand-500 rounded-full blur-[120px] opacity-20"></div>
            <div class="absolute bottom-0 right-10 w-80 h-80 bg-cyan-500 rounded-full blur-[100px] opacity-20"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 text-brand-300 border border-brand-400/30 rounded-full font-bold tracking-wider uppercase text-[11px] mb-6 backdrop-blur-sm">
                    <i class='bx bx-code-alt text-lg'></i> Jasa Web Development
                </span>
                <h1 class="text-4xl md:text-6xl font-black text-white font-montserrat mb-6 drop-shadow-lg tracking-tight leading-tight max-w-4xl mx-auto">
                    Tingkatkan Kredibilitas Bisnis Anda dengan Website Profesional
                </h1>
                <p class="text-lg md:text-xl text-gray-200 max-w-3xl mx-auto mb-10 leading-relaxed font-medium">
                    Dari Landing Page hingga E-Commerce, LKTech siap mewujudkan website impian Anda yang cepat, responsif, dan siap bersaing di era digital.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#paket" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-brand-600 hover:bg-brand-500 text-white rounded-full font-bold transition-all shadow-[0_0_20px_rgba(37,99,235,0.4)] hover:shadow-[0_0_25px_rgba(37,99,235,0.6)] transform hover:-translate-y-1">
                        Lihat Paket Harga <i class='bx bx-down-arrow-alt text-xl'></i>
                    </a>
                    <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20ingin%20konsultasi%20mengenai%20Jasa%20Pembuatan%20Website." target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white/10 hover:bg-white/20 border border-white/30 text-white rounded-full font-bold transition-all backdrop-blur-sm transform hover:-translate-y-1">
                        <i class='bx bxl-whatsapp text-xl'></i> Konsultasi Gratis
                    </a>
                </div>
            </div>
        </div>

        <!-- Mengapa Memilih Kami (Features Grid) -->
        <div class="bg-white py-20 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-brand-600 font-bold tracking-wider uppercase text-[10px] mb-2 inline-block bg-brand-50 px-3 py-1 rounded-full border border-brand-100">Keunggulan Kami</span>
                    <h2 class="text-3xl font-black text-gray-900 font-montserrat mb-4 tracking-tight">Mengapa Memilih Jasa Website LKTech?</h2>
                    <p class="text-gray-500 text-sm max-w-2xl mx-auto">Kami tidak sekadar membuat website, kami membangun identitas digital bisnis Anda dengan standar performa dan kualitas tinggi.</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-14 h-14 bg-blue-100 text-brand-600 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm group-hover:scale-110 transition-transform">
                            <i class='bx bx-devices'></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 font-montserrat">Desain Modern & Responsif</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Tampil sempurna di berbagai perangkat, mulai dari Smartphone, Tablet, hingga Layar Desktop.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm group-hover:scale-110 transition-transform">
                            <i class='bx bx-search-alt'></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 font-montserrat">SEO Friendly</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Struktur kode dioptimasi agar website Anda lebih mudah terindeks dan ditemukan di halaman pencarian Google.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm group-hover:scale-110 transition-transform">
                            <i class='bx bx-globe'></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 font-montserrat">Gratis Domain & Hosting</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Terima beres! Paket kami sudah termasuk gratis pendaftaran Domain (.com) dan Hosting berkecepatan tinggi untuk tahun pertama.</p>
                    </div>
                    <!-- Feature 4 -->
                    <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm group-hover:scale-110 transition-transform">
                            <i class='bx bx-support'></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 font-montserrat">Support & Maintenance</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Dukungan teknis penuh setelah website dirilis untuk memastikan semuanya berjalan lancar dan aman.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Packages Grid -->
        <div id="paket" class="bg-gray-50 py-20 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-black text-gray-900 font-montserrat mb-3 tracking-tight">Pilihan Paket Harga</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Solusi tepat untuk segala skala bisnis. Harga transparan tanpa biaya tersembunyi.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                    
                    <!-- Card 1: Paket Starter -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 hover:shadow-xl transition-all flex flex-col h-full relative group">
                        <div class="flex-grow">
                            <h3 class="text-xl font-bold text-gray-900 mb-1 font-montserrat">Paket Starter</h3>
                            <p class="text-xs text-brand-600 font-bold uppercase tracking-wider mb-6">Landing Page / UMKM</p>
                            
                            <div class="mb-8">
                                <span class="text-3xl font-black text-gray-900">Rp 1.499.000</span>
                            </div>
                            
                            <ul class="space-y-4 mb-8 text-sm text-gray-600 font-medium">
                                <li class="flex items-start gap-3"><i class='bx bx-check-circle text-brand-500 text-xl'></i> <span>1 Halaman Landing Page Panjang</span></li>
                                <li class="flex items-start gap-3"><i class='bx bx-check-circle text-brand-500 text-xl'></i> <span>Desain Modern (Template Premium)</span></li>
                                <li class="flex items-start gap-3"><i class='bx bx-check-circle text-brand-500 text-xl'></i> <span>Gratis Domain (.com/.id) & Hosting 1 Thn</span></li>
                                <li class="flex items-start gap-3"><i class='bx bx-check-circle text-brand-500 text-xl'></i> <span>SSL Certificate (Keamanan HTTPS)</span></li>
                                <li class="flex items-start gap-3"><i class='bx bx-check-circle text-brand-500 text-xl'></i> <span>Integrasi Tombol WhatsApp</span></li>
                            </ul>
                        </div>
                        <div class="mt-auto pt-6 border-t border-gray-100">
                            <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20ingin%20konsultasi%20mengenai%20Jasa%20Pembuatan%20Website%20(Paket%20Starter)." target="_blank" class="w-full block text-center px-6 py-3 bg-gray-50 hover:bg-gray-100 text-gray-800 font-bold rounded-xl transition-colors border border-gray-200">
                                Pilih Paket
                            </a>
                        </div>
                    </div>

                    <!-- Card 2: Paket Profesional (Highlighted) -->
                    <div class="bg-white rounded-3xl shadow-2xl border-2 border-brand-500 p-8 flex flex-col h-full relative z-10 md:-translate-y-4 transform">
                        <div class="absolute top-0 right-0 bg-brand-600 text-white text-[10px] font-black px-4 py-1.5 rounded-bl-2xl uppercase tracking-widest shadow-sm">
                            Best Seller
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-b from-brand-50/50 to-transparent rounded-3xl pointer-events-none"></div>
                        
                        <div class="flex-grow relative z-10">
                            <h3 class="text-2xl font-bold text-brand-600 mb-1 font-montserrat">Paket Profesional</h3>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-6">Company Profile</p>
                            
                            <div class="mb-8">
                                <span class="text-4xl font-black text-gray-900">Rp 3.499.000</span>
                            </div>
                            
                            <ul class="space-y-4 mb-8 text-sm text-gray-700 font-semibold">
                                <li class="flex items-start gap-3"><i class='bx bxs-check-circle text-brand-600 text-xl'></i> <span>Hingga 5 Halaman Custom</span></li>
                                <li class="flex items-start gap-3"><i class='bx bxs-check-circle text-brand-600 text-xl'></i> <span>Custom Design UI/UX</span></li>
                                <li class="flex items-start gap-3"><i class='bx bxs-check-circle text-brand-600 text-xl'></i> <span>Gratis Domain & Cloud Hosting 1 Thn</span></li>
                                <li class="flex items-start gap-3"><i class='bx bxs-check-circle text-brand-600 text-xl'></i> <span>Basic SEO Setup (On-Page)</span></li>
                                <li class="flex items-start gap-3"><i class='bx bxs-check-circle text-brand-600 text-xl'></i> <span>Email Bisnis Resmi (contoh: info@domain.com)</span></li>
                                <li class="flex items-start gap-3"><i class='bx bxs-check-circle text-brand-600 text-xl'></i> <span>Formulir Kontak Terintegrasi</span></li>
                            </ul>
                        </div>
                        <div class="mt-auto pt-6 border-t border-brand-100 relative z-10">
                            <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20ingin%20konsultasi%20mengenai%20Jasa%20Pembuatan%20Website%20(Paket%20Profesional)." target="_blank" class="w-full block text-center px-6 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Pilih Paket Paling Laris
                            </a>
                        </div>
                    </div>

                    <!-- Card 3: Paket E-Commerce -->
                    <div class="bg-gray-900 rounded-3xl shadow-sm border border-gray-800 p-8 hover:shadow-xl transition-all flex flex-col h-full relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/20 to-transparent rounded-3xl pointer-events-none"></div>
                        <div class="flex-grow relative z-10">
                            <h3 class="text-xl font-bold text-white mb-1 font-montserrat">Paket E-Commerce</h3>
                            <p class="text-xs text-purple-400 font-bold uppercase tracking-wider mb-6">Toko Online Digital</p>
                            
                            <div class="mb-8">
                                <span class="text-3xl font-black text-white">Rp 6.999.000</span>
                            </div>
                            
                            <ul class="space-y-4 mb-8 text-sm text-gray-300 font-medium">
                                <li class="flex items-start gap-3"><i class='bx bx-check-circle text-purple-500 text-xl'></i> <span>Katalog Produk (Upload s/d 100 Produk)</span></li>
                                <li class="flex items-start gap-3"><i class='bx bx-check-circle text-purple-500 text-xl'></i> <span>Fitur Keranjang & Checkout Lengkap</span></li>
                                <li class="flex items-start gap-3"><i class='bx bx-check-circle text-purple-500 text-xl'></i> <span>Integrasi Payment Gateway Otomatis</span></li>
                                <li class="flex items-start gap-3"><i class='bx bx-check-circle text-purple-500 text-xl'></i> <span>Cek Ongkir Otomatis (JNE, J&T, dll)</span></li>
                                <li class="flex items-start gap-3"><i class='bx bx-check-circle text-purple-500 text-xl'></i> <span>Dashboard Admin Manajemen Toko</span></li>
                            </ul>
                        </div>
                        <div class="mt-auto pt-6 border-t border-gray-800 relative z-10">
                            <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20ingin%20konsultasi%20mengenai%20Jasa%20Pembuatan%20Website%20(Paket%20E-Commerce)." target="_blank" class="w-full block text-center px-6 py-3 bg-purple-600/20 hover:bg-purple-600 text-purple-300 hover:text-white border border-purple-600/50 font-bold rounded-xl transition-all">
                                Pilih Paket E-Commerce
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Alur Kerja (Workflow) -->
        <div class="bg-white py-20 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNFMkU4RjAiLz48L3N2Zz4=')] opacity-50"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <span class="text-brand-600 font-bold tracking-wider uppercase text-[10px] mb-2 block bg-brand-50 inline-block px-3 py-1 rounded-full border border-brand-100">Step By Step</span>
                    <h2 class="text-3xl font-black text-gray-900 font-montserrat mb-3 tracking-tight">Alur Kerja Kami</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Proses yang terstruktur untuk memastikan hasil akhir yang memuaskan dan sesuai ekspektasi.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-5 gap-8 md:gap-4 text-center relative">
                    <!-- Connecting Line for Desktop -->
                    <div class="hidden md:block absolute top-10 left-[10%] right-[10%] h-0.5 bg-gray-200 z-0"></div>

                    <!-- Step 1 -->
                    <div class="relative z-10">
                        <div class="w-20 h-20 mx-auto bg-white border-4 border-brand-100 text-brand-600 rounded-full flex items-center justify-center text-3xl font-black shadow-sm mb-4 group hover:bg-brand-600 hover:text-white transition-colors duration-300">
                            1
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Konsultasi</h4>
                        <p class="text-xs text-gray-500 px-2">Diskusi konsep, target audiens, dan fitur yang dibutuhkan.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative z-10">
                        <div class="w-20 h-20 mx-auto bg-white border-4 border-brand-100 text-brand-600 rounded-full flex items-center justify-center text-3xl font-black shadow-sm mb-4 group hover:bg-brand-600 hover:text-white transition-colors duration-300">
                            2
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Desain UI/UX</h4>
                        <p class="text-xs text-gray-500 px-2">Pembuatan mockup visual yang memukau dan mudah digunakan.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative z-10">
                        <div class="w-20 h-20 mx-auto bg-white border-4 border-brand-100 text-brand-600 rounded-full flex items-center justify-center text-3xl font-black shadow-sm mb-4 group hover:bg-brand-600 hover:text-white transition-colors duration-300">
                            3
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Development</h4>
                        <p class="text-xs text-gray-500 px-2">Proses coding yang rapi, optimasi kecepatan, dan keamanan.</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative z-10">
                        <div class="w-20 h-20 mx-auto bg-white border-4 border-brand-100 text-brand-600 rounded-full flex items-center justify-center text-3xl font-black shadow-sm mb-4 group hover:bg-brand-600 hover:text-white transition-colors duration-300">
                            4
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Revisi</h4>
                        <p class="text-xs text-gray-500 px-2">Kami berikan kesempatan revisi agar hasil benar-benar sempurna.</p>
                    </div>

                    <!-- Step 5 -->
                    <div class="relative z-10">
                        <div class="w-20 h-20 mx-auto bg-emerald-500 border-4 border-emerald-100 text-white rounded-full flex items-center justify-center text-3xl font-black shadow-[0_0_20px_rgba(16,185,129,0.3)] mb-4">
                            <i class='bx bx-check'></i>
                        </div>
                        <h4 class="font-bold text-emerald-600 mb-2">Rilis & Panduan</h4>
                        <p class="text-xs text-gray-500 px-2">Website online! Anda akan dibekali panduan penggunaannya.</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-brand-600 py-20 relative overflow-hidden">
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

    <!-- Floating CTA (WhatsApp) -->
    <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20ingin%20konsultasi%20mengenai%20Jasa%20Pembuatan%20Website." 
       target="_blank"
       class="fixed bottom-6 right-6 z-50 bg-[#25D366] text-white p-4 rounded-full shadow-2xl hover:bg-[#128C7E] hover:-translate-y-1 transition-all flex items-center gap-2 group border-2 border-white">
        <i class='bx bxl-whatsapp text-3xl'></i>
        <span class="font-bold text-sm max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-300 ease-in-out whitespace-nowrap hidden md:block">Konsultasi Web Sekarang</span>
    </a>

    <!-- Footer -->
    <x-footer />

</body>
</html>
