<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/LKtech.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LK Tech') }}</title>

    <!-- Modern Fonts: Inter for clean, legible typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons (Boxicons) -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Tailwind Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                    colors: {
                        natural: {
                            50: '#f6f8f7', // Calm light background
                            100: '#edf1f0',
                            200: '#dae3e0',
                            300: '#c0cfca',
                            400: '#9fb3ad',
                            500: '#819891',
                            600: '#667b75',
                            700: '#53635f', // Main text
                            800: '#45514f', // Headings
                            900: '#3a4442',
                        },
                        brand: {
                            50: '#f0fdfa', // Teal light
                            100: '#ccfbf1',
                            500: '#14b8a6', // Main brand (Teal)
                            600: '#0d9488',
                            700: '#0f766e',
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.04)',
                        'soft-hover': '0 10px 25px -4px rgba(0, 0, 0, 0.08)',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        body {
            background-color: #f8faf9; /* Very soft, natural off-white */
            color: #45514f;
        }

        .card-natural {
            background-color: #ffffff;
            border: 1px solid rgba(0,0,0,0.03);
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
        }
    </style>
</head>
<body class="font-sans antialiased text-natural-700 selection:bg-brand-500 selection:text-white" x-data="{ sidebarOpen: window.innerWidth >= 1024 }" @resize.window="if(window.innerWidth >= 1024) { sidebarOpen = true } else { sidebarOpen = false }">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        @include('layouts.navigation')

        <!-- Main Content Wrapper -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden bg-natural-50 transition-all duration-300 ease-in-out">
            
            <!-- Top Header -->
            <header class="sticky top-0 z-30 flex items-center justify-between h-[72px] px-4 bg-white/90 backdrop-blur-md border-b border-natural-200 sm:px-6 lg:px-8 shadow-sm transition-all duration-300">
                <div class="flex items-center gap-4 flex-1 min-w-0">
                    <!-- Hamburger Toggle -->
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-natural-600 rounded-lg hover:bg-natural-100 focus:outline-none focus:ring-2 focus:ring-brand-500 transition shrink-0">
                        <i class='bx bx-menu text-2xl'></i>
                    </button>
                    
                    <!-- Dynamic Page Header -->
                    <div class="hidden sm:flex items-center w-full truncate">
                        @if (isset($header))
                            <div class="w-full flex items-center">
                                {{ $header }}
                            </div>
                        @else
                            <div class="text-natural-600">
                                <x-breadcrumbs />
                            </div>
                        @endif
                    </div>
                </div>

            </header>

            <!-- Page Content -->
            <main class="flex-1 px-4 py-4 sm:px-6 lg:px-8 w-full max-w-7xl mx-auto flex flex-col">

                @if (session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 flex items-center gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
                        <i class='bx bx-check-circle text-2xl text-teal-500'></i>
                        <span class="flex-1 font-medium">{{ session('success') }}</span>
                        <button @click="show = false" class="text-teal-600 hover:text-teal-800"><i class='bx bx-x text-xl'></i></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 flex items-center gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
                        <i class='bx bx-error-circle text-2xl text-red-500'></i>
                        <span class="flex-1 font-medium">{{ session('error') }}</span>
                        <button @click="show = false" class="text-red-600 hover:text-red-800"><i class='bx bx-x text-xl'></i></button>
                    </div>
                @endif

                {{ $slot }}
            </main>

            <footer class="shrink-0 border-t border-natural-200 bg-white no-print print:hidden">
                <div class="px-4 py-3 sm:px-6 lg:px-8 text-center text-[10px] text-natural-400 font-medium tracking-wide">
                    © {{ date('Y') }} LK Tech. Sistem Profesional & Terpercaya.
                </div>
            </footer>




        </div>
    </div>
    <script>
        let searchTimeout = null;
        function debounceSubmit() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const form = document.getElementById('filterForm');
                if (form) form.submit();
            }, 500);
        }
    </script>
</body>
</html>
