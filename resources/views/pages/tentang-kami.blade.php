<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - LKTech TN SEREAL</title>
    
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
                    <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">Beranda</a>
                    <a href="{{ route('katalog.index') }}" class="hover:text-brand-600 transition-colors">Katalog</a>
                    <div class="relative group" x-data="{ open: false }" @mouseleave="open = false">
                        <button @mouseover="open = true" class="hover:text-brand-600 transition-colors flex items-center gap-1">
                            Layanan <i class='bx bx-chevron-down text-lg'></i>
                        </button>
                        <div x-show="open" x-transition.opacity class="absolute top-full left-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-lg py-2 z-50" style="display: none;">
                            <a href="{{ route('rakit-pc') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">Rakit PC</a>
                            <a href="{{ route('jasa-website') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">Jasa Pembuatan Website</a>
                        </div>
                    </div>
                    <a href="{{ route('blog.index') }}" class="hover:text-brand-600 transition-colors">Blog & Panduan</a>
                    <a href="{{ route('tentang-kami') }}" class="hover:text-brand-600 transition-colors text-brand-600">Tentang Kami</a>
                </div>
                <div class="flex-shrink-0 flex items-center gap-3 md:hidden">
                    <a href="{{ route('katalog.index') }}" class="text-sm font-semibold text-gray-600 hover:text-brand-600">Ke Katalog</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-10 pb-16 lg:pt-12 lg:pb-20 max-md:pb-24">
        <x-inner-page-header title="Kisah LKtech" subtitle="Mengenal lebih dekat perjalanan dan komitmen kami untuk Anda." />

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8 md:p-12 prose max-w-none text-gray-600 leading-relaxed">
                @if(isset($settings) && $settings->tentang_kami)
                    {!! $settings->tentang_kami !!}
                @else
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 font-montserrat">Kisah Kami</h2>
                    <p class="mb-4">
                        LKTech adalah sebuah usaha mikro yang bergerak di bidang penjualan laptop bekas berkualitas premium. Kami tidak sekadar menjual perangkat, tetapi juga mengutamakan layanan purna jual (after sales) serta menerapkan proses quality control yang ketat. Dengan demikian, kami berkomitmen untuk memastikan bahwa setiap perangkat yang sampai ke tangan pelanggan tetap dalam kondisi prima dan berkualitas tinggi.
                    </p>
                    <p class="mb-6">
                        Di samping itu, LKTech juga melayani kebutuhan penyewaan laptop untuk berbagai keperluan, baik individu maupun instansi, serta menyediakan layanan servis laptop dan komputer yang dikerjakan oleh teknisi berpengalaman. Seluruh layanan kami hadir dengan prinsip kepercayaan, kemudahan, dan kepuasan pelanggan sebagai prioritas utama.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-10 items-center">
                        <div>
                            <img src="{{ asset('images/TentangKami.webp') }}" alt="Tim LKTech" class="w-full h-auto rounded-xl shadow-lg object-cover border border-gray-100">
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 font-montserrat">Visi & Misi</h3>
                            <h4 class="font-bold text-gray-800 mb-1">Visi</h4>
                            <p class="mb-4 text-sm md:text-base">
                                Menjadi mitra pengadaan teknologi informasi yang terpercaya, baik di wilayah Bogor dan sekitarnya, maupun di seluruh Nusantara.
                            </p>
                            <h4 class="font-bold text-gray-800 mb-1">Misi</h4>
                            <p class="text-sm md:text-base">
                                Menyediakan laptop bekas berkualitas premium dengan jaminan garansi serta layanan purna jual yang bertanggung jawab dan memuaskan.
                            </p>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4 font-montserrat">Mengapa Memilih Kami?</h2>
                    <ul class="space-y-3 mb-6 list-none p-0">
                        <li class="flex items-center gap-3">
                            <i class='bx bx-check-circle text-emerald-500 text-xl'></i>
                            <span>Produk melewati 2 lapis Quality Control ketat.</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class='bx bx-check-circle text-emerald-500 text-xl'></i>
                            <span>Harga transparan dan bersaing di pasaran.</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class='bx bx-check-circle text-emerald-500 text-xl'></i>
                            <span>Dukungan purna jual (after-sales) yang ramah dan cepat.</span>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
        
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Mobile Bottom Navigation -->
    <x-mobile-bottom-nav />

</body>
</html>
