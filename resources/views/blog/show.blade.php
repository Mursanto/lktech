<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $post->title }} - Blog LKTech</title>
    
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
    <style>
        [x-cloak] { display: none !important; }
        .prose h2, .prose h3 { font-family: 'Montserrat', sans-serif; font-weight: 800; color: #111827; margin-top: 1.2em; margin-bottom: 0.5em; }
        .prose h2 { font-size: 0.95rem; line-height: 1.3; }
        .prose h3 { font-size: 0.9rem; line-height: 1.4; }
        .prose p { margin-bottom: 1em; line-height: 1.6; color: #374151; font-size: 0.8rem; }
        .prose ul { list-style-type: disc; padding-left: 1.2em; margin-bottom: 1em; font-size: 0.8rem; }
        .prose ol { list-style-type: decimal; padding-left: 1.2em; margin-bottom: 1em; font-size: 0.8rem; }
        .prose li { margin-bottom: 0.4em; line-height: 1.5; color: #374151; }
        .prose img { border-radius: 0.5rem; margin: 1.2em 0; max-width: 100%; height: auto; }
        .prose blockquote { border-left: 4px solid #3b82f6; padding-left: 1em; font-style: italic; color: #4b5563; background: #eff6ff; padding: 1em; border-radius: 0 0.5rem 0.5rem 0; margin-bottom: 1em; font-size: 0.8rem; }
        .prose strong { color: #111827; font-weight: 700; }
        
        @media (min-width: 768px) {
            .prose h2 { font-size: 1.1rem; margin-top: 2em; margin-bottom: 0.75em; }
            .prose h3 { font-size: 1rem; margin-top: 2em; margin-bottom: 0.75em; }
            .prose p, .prose li, .prose blockquote { font-size: 0.95rem; margin-bottom: 1.5em; line-height: 1.8; }
            .prose img { border-radius: 0.75rem; margin: 2em 0; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Header -->

    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 lg:py-16">
        
        <!-- Breadcrumbs -->
        <nav class="flex text-xs text-gray-500 mb-4 sm:mb-8 font-medium">
            <a href="{{ route('home') }}" class="hover:text-brand-600">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('blog.index') }}" class="hover:text-brand-600">Blog</a>
            <span class="mx-2">/</span>
            <span class="text-gray-400 cursor-default line-clamp-1">{{ $post->title }}</span>
        </nav>

        <article class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-12">
            
            <!-- Content Container -->
            <div class="p-4 md:p-8">
                
                <!-- Floated Container for Image and Meta Info -->
                <div class="float-left w-[45%] sm:w-1/3 md:w-1/4 mr-4 mb-2 md:mr-6 md:mb-4 flex flex-col gap-2">
                    @if($post->thumbnail)
                        <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="w-full rounded-xl object-contain bg-gray-50 border border-gray-100 p-1">
                    @else
                        <div class="w-full aspect-square flex items-center justify-center text-gray-400 bg-gray-100 rounded-xl border border-gray-100">
                            <i class='bx bx-image-alt text-4xl md:text-6xl'></i>
                        </div>
                    @endif

                    <!-- Meta Info (underneath image) -->
                    <div class="flex flex-row flex-wrap justify-between gap-1.5 text-[8.5px] sm:text-[10px] text-gray-500 font-semibold w-full">
                        <div class="flex items-center gap-1 bg-brand-50 text-brand-600 px-1.5 py-0.5 rounded shrink-0">
                            <i class='bx bx-calendar'></i>
                            {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                        </div>
                        <div class="flex items-center gap-1 text-gray-400 shrink-0">
                            <i class='bx bx-user-circle'></i> Admin
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-base sm:text-lg md:text-xl lg:text-2xl font-black text-gray-900 font-montserrat leading-snug mb-3 sm:mb-4">
                    {{ $post->title }}
                </h1>

                <!-- Article Body -->
                <div class="prose max-w-none text-gray-700">
                    {!! $post->content !!}
                </div>
                
                <div class="clear-both"></div>
            </div>
            
        </article>

        <!-- Recommended Posts -->
        @if($recentPosts->count() > 0)
        <div class="mb-8">
            <h3 class="text-lg font-black text-gray-900 font-montserrat mb-4">Artikel Terkait Lainnya</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($recentPosts as $recent)
                <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all group flex flex-row items-center p-3 gap-3">
                    <a href="{{ route('blog.show', $recent->slug) }}" class="flex-shrink-0 w-24 h-24 sm:w-28 sm:h-28 bg-gray-50 rounded-lg overflow-hidden flex items-center justify-center">
                        @if($recent->thumbnail)
                            <img src="{{ Storage::url($recent->thumbnail) }}" alt="{{ $recent->title }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                        @endif
                    </a>
                    <div class="flex flex-col justify-center flex-grow min-w-0">
                        <h4 class="font-bold text-[13px] sm:text-sm text-gray-900 mb-1.5 leading-tight group-hover:text-brand-600 transition-colors line-clamp-2">
                            <a href="{{ route('blog.show', $recent->slug) }}">{{ $recent->title }}</a>
                        </h4>
                        <div class="text-[10px] text-gray-500 font-medium flex items-center gap-1">
                            <i class='bx bx-calendar'></i> {{ $recent->published_at ? $recent->published_at->format('d M Y') : $recent->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Mobile Bottom Navigation -->
    <x-mobile-bottom-nav />

</body>
</html>
