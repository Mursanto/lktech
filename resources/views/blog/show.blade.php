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
        .prose h2, .prose h3 { font-family: 'Montserrat', sans-serif; font-weight: 800; color: #111827; margin-top: 2em; margin-bottom: 0.75em; }
        .prose h2 { font-size: 1.5rem; }
        .prose h3 { font-size: 1.25rem; }
        .prose p { margin-bottom: 1.5em; line-height: 1.8; color: #374151; font-size: 1.05rem; }
        .prose ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1.5em; }
        .prose ol { list-style-type: decimal; padding-left: 1.5em; margin-bottom: 1.5em; }
        .prose li { margin-bottom: 0.5em; line-height: 1.6; color: #374151; }
        .prose img { border-radius: 0.75rem; margin: 2em 0; max-width: 100%; height: auto; }
        .prose blockquote { border-left: 4px solid #3b82f6; padding-left: 1em; font-style: italic; color: #4b5563; background: #eff6ff; padding: 1em; border-radius: 0 0.5rem 0.5rem 0; margin-bottom: 1.5em; }
        .prose strong { color: #111827; font-weight: 700; }
    </style>
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
                    <a href="{{ route('blog.index') }}" class="hover:text-brand-600 transition-colors">Semua Artikel</a>
                    <a href="{{ route('katalog.index') }}" class="hover:text-brand-600 transition-colors">Katalog</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10 lg:py-16 max-md:pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex text-sm text-gray-500 mb-8 font-medium">
            <a href="{{ route('home') }}" class="hover:text-brand-600">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('blog.index') }}" class="hover:text-brand-600">Blog</a>
            <span class="mx-2">/</span>
            <span class="text-gray-400 cursor-default line-clamp-1">{{ $post->title }}</span>
        </nav>

        <article class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden mb-16">
            
            <!-- Hero Thumbnail -->
            <div class="w-full aspect-[21/9] bg-gray-100 overflow-hidden relative">
                @if($post->thumbnail)
                    <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-200">
                        <i class='bx bx-image-alt text-6xl'></i>
                    </div>
                @endif
            </div>

            <!-- Content Container -->
            <div class="p-6 md:p-12">
                <!-- Meta Info -->
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6 font-semibold">
                    <div class="flex items-center gap-1 bg-brand-50 text-brand-600 px-3 py-1.5 rounded-lg">
                        <i class='bx bx-calendar'></i>
                        {{ $post->published_at ? $post->published_at->format('d F Y') : $post->created_at->format('d F Y') }}
                    </div>
                    <div class="flex items-center gap-1 text-gray-400">
                        <i class='bx bx-user-circle'></i> Admin LKTech
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 font-montserrat leading-tight mb-8">
                    {{ $post->title }}
                </h1>

                <!-- Article Body -->
                <div class="prose max-w-none text-gray-700">
                    {!! $post->content !!}
                </div>
            </div>
            
        </article>

        <!-- Recommended Posts -->
        @if($recentPosts->count() > 0)
        <div class="mb-8">
            <h3 class="text-2xl font-black text-gray-900 font-montserrat mb-6">Artikel Terkait Lainnya</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($recentPosts as $recent)
                <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all group flex flex-col h-full">
                    <a href="{{ route('blog.show', $recent->slug) }}" class="block w-full h-36 bg-gray-100 overflow-hidden">
                        @if($recent->thumbnail)
                            <img src="{{ Storage::url($recent->thumbnail) }}" alt="{{ $recent->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @endif
                    </a>
                    <div class="p-4 flex flex-col flex-grow">
                        <h4 class="font-bold text-gray-900 mb-2 leading-tight group-hover:text-brand-600 transition-colors line-clamp-2">
                            <a href="{{ route('blog.show', $recent->slug) }}">{{ $recent->title }}</a>
                        </h4>
                        <div class="text-xs text-gray-500 font-medium mt-auto flex items-center gap-1">
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
