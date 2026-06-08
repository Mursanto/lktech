<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog & Panduan - LKTech TN SEREAL</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], montserrat: ['Montserrat', 'sans-serif'], },
                    colors: { brand: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', } }
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
                    <a href="{{ route('blog.index') }}" class="hover:text-brand-600 transition-colors text-brand-600">Blog & Panduan</a>
                    <a href="{{ route('tentang-kami') }}" class="hover:text-brand-600 transition-colors">Tentang Kami</a>
                </div>
                <div class="flex-shrink-0 flex items-center gap-3 md:hidden">
                    <a href="{{ route('katalog.index') }}" class="text-sm font-semibold text-gray-600 hover:text-brand-600">Ke Katalog</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10 lg:py-16">
        
        <x-inner-page-header title="Blog & Panduan IT" subtitle="Tips, trik, dan wawasan seputar dunia teknologi." />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
            <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full group transform hover:-translate-y-1">
                <!-- Thumbnail -->
                <a href="{{ route('blog.show', $post->slug) }}" class="block w-full h-56 bg-gray-100 overflow-hidden relative">
                    @if($post->thumbnail)
                        <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-200">
                            <i class='bx bx-image-alt text-5xl'></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                
                <!-- Content -->
                <div class="p-6 flex flex-col flex-grow">
                    <div class="text-xs text-brand-600 font-bold mb-3 flex items-center gap-2">
                        <span class="bg-brand-50 text-brand-600 px-2 py-1 rounded-md"><i class='bx bx-calendar'></i> {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                    </div>
                    <h2 class="font-bold text-gray-900 text-xl mb-3 leading-tight group-hover:text-brand-600 transition-colors">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h2>
                    <p class="text-sm text-gray-500 leading-relaxed mb-6 flex-grow">
                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                    </p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-1 text-sm font-bold text-brand-600 hover:text-brand-700 mt-auto w-max group-hover:gap-2 transition-all">
                        Baca Selengkapnya <i class='bx bx-right-arrow-alt text-lg'></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300">
                <i class='bx bx-book-open text-6xl text-gray-300 mb-4'></i>
                <h3 class="text-xl font-bold text-gray-600 mb-2">Belum ada artikel</h3>
                <p class="text-gray-400">Nantikan artikel dan panduan menarik dari LKTech segera!</p>
            </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $posts->links() }}
        </div>
        
    </main>

    <!-- Footer -->
    <x-footer />

</body>
</html>
