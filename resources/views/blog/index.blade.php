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

    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4 pb-10 lg:pt-6 lg:pb-16">
        
        <x-inner-page-header title="Blog & Panduan IT" subtitle="Tips, trik, dan wawasan seputar dunia teknologi." />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 lg:mt-8">
            @forelse($posts as $post)
            <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-row h-full group transform hover:-translate-y-1 p-3 gap-4 items-center">
                <!-- Thumbnail -->
                <a href="{{ route('blog.show', $post->slug) }}" class="block w-28 h-28 sm:w-32 sm:h-32 bg-gray-100 overflow-hidden relative shrink-0 rounded-xl">
                    @if($post->thumbnail)
                        <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-200">
                            <i class='bx bx-image-alt text-4xl'></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                
                <!-- Content -->
                <div class="flex flex-col flex-grow py-1 min-w-0">
                    <div class="text-[10px] md:text-xs text-brand-600 font-bold mb-1.5 flex items-center gap-2">
                        <span class="bg-brand-50 text-brand-600 px-2 py-1 rounded-md"><i class='bx bx-calendar'></i> {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                    </div>
                    <h2 class="font-bold text-gray-900 text-sm md:text-base mb-1.5 leading-tight group-hover:text-brand-600 transition-colors line-clamp-2">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h2>
                    <p class="text-xs text-gray-500 leading-relaxed mb-2 line-clamp-2">
                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 80) }}
                    </p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-brand-600 hover:text-brand-700 mt-auto w-max group-hover:gap-2 transition-all">
                        Baca Selengkapnya <i class='bx bx-right-arrow-alt text-sm'></i>
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

    <!-- Mobile Bottom Navigation -->
    <x-mobile-bottom-nav />

</body>
</html>
