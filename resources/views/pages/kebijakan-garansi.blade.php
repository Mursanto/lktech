<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kebijakan Garansi - LKTech TN SEREAL</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- Header (Simple Tokopedia Style) -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 gap-4">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/LKtech.png') }}" alt="LKTech Logo" class="h-7 w-auto">
                        <span class="font-montserrat font-black text-xl tracking-tight text-blue-900 hidden sm:block">LKTech TN SEREAL</span>
                    </a>
                </div>
                <div class="flex-shrink-0 flex items-center gap-3">
                    <a href="{{ route('katalog.index') }}" class="text-sm font-semibold text-gray-600 hover:text-brand-600">Ke Katalog</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10 lg:py-16">
        
        <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Banner Placeholder -->
            <div class="w-full h-40 md:h-56 bg-gray-200 flex items-center justify-center bg-gradient-to-r from-amber-400 to-orange-500 relative">
                <i class='bx bx-check-shield text-6xl text-white/40 absolute right-10 -bottom-6'></i>
                <h1 class="text-3xl md:text-5xl font-black text-white font-montserrat z-10 drop-shadow-md">Kebijakan Garansi</h1>
            </div>

            <div class="p-8 md:p-12 prose max-w-none text-gray-600 leading-relaxed">
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-8">
                    <p class="text-amber-800 font-medium m-0 text-sm">
                        <i class='bx bx-info-circle mr-1'></i> Catatan: Syarat dan ketentuan garansi di bawah ini dibuat untuk melindungi hak Anda sebagai pembeli dan menjaga transparansi transaksi di LKTech.
                    </p>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-montserrat">Masa Berlaku Garansi</h2>
                <p class="mb-6">
                    Kami memberikan garansi mesin selama 1 (satu) bulan dan garansi perangkat lunak (software) selama 1 (satu) minggu, terhitung sejak tanggal pembelian yang tercantum pada nota.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-montserrat">Syarat Klaim Garansi</h2>
                <ul class="space-y-3 mb-6 list-none p-0">
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check text-emerald-500 text-xl mt-0.5'></i>
                        <span>Nota pembelian wajib dilampirkan atau ditunjukkan pada saat pengajuan klaim.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check text-emerald-500 text-xl mt-0.5'></i>
                        <span>Segel garansi toko yang terletak pada bagian bawah laptop harus dalam keadaan utuh dan tidak rusak atau sobek.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check text-emerald-500 text-xl mt-0.5'></i>
                        <span>Kerusakan tidak disebabkan oleh faktor kelalaian pengguna (human error), seperti terjatuh, terkena air, konsleting listrik rumah, atau modifikasi sepihak.</span>
                    </li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-montserrat">Prosedur Pengembalian / Servis</h2>
                <p class="mb-6">
                    Pelanggan dapat membawa unit laptop beserta kelengkapannya (charger dan tas) langsung ke toko kami. Selanjutnya, teknisi kami akan melakukan pemeriksaan menyeluruh dalam waktu 1–3 hari kerja, sebelum memberikan keputusan berupa perbaikan atau penggantian unit (jika stok tersedia).
                </p>
            </div>
        </div>
        
    </main>

    <!-- Footer -->
    <x-footer />

</body>
</html>
