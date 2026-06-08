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

    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-10 pb-16 lg:pt-12 lg:pb-20 max-md:pb-24">
        <x-inner-page-header title="Kisah LKtech" subtitle="Mengenal lebih dekat perjalanan dan komitmen kami untuk Anda." />

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8 md:p-12 text-gray-600 leading-relaxed">
                    
                    <!-- 1. KISAH KAMI & PHOTO SECTION -->
                    <div class="mb-16 text-gray-700 leading-relaxed text-justify clearfix">
                        <img src="{{ asset('images/TentangKami.webp') }}" alt="Tim LKTech" class="float-left w-full sm:w-1/2 md:w-1/3 lg:w-80 h-auto object-cover rounded-2xl shadow-xl mr-6 mb-4 mt-2">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 font-montserrat">Kisah Kami</h2>
                        <p class="mb-4 text-gray-600">
                            LKTech adalah sebuah usaha mikro yang bergerak di bidang penjualan laptop bekas berkualitas premium. Kami tidak sekadar menjual perangkat, tetapi juga mengutamakan layanan purna jual (after sales) serta menerapkan proses quality control yang ketat. Dengan demikian, kami berkomitmen untuk memastikan bahwa setiap perangkat yang sampai ke tangan pelanggan tetap dalam kondisi prima dan berkualitas tinggi.
                        </p>
                        <p class="text-gray-600">
                            Di samping itu, LKTech juga melayani kebutuhan penyewaan laptop untuk berbagai keperluan, baik individu maupun instansi, serta menyediakan layanan servis laptop dan komputer yang dikerjakan oleh teknisi berpengalaman. Seluruh layanan kami hadir dengan prinsip kepercayaan, kemudahan, dan kepuasan pelanggan sebagai prioritas utama.
                        </p>
                    </div>

                    <!-- 2. VISI & MISI SECTION -->
                    <div class="max-w-4xl mx-auto mb-16 bg-blue-50 p-8 rounded-3xl shadow-sm border border-blue-100">
                        <h3 class="text-2xl font-bold mb-3 text-blue-900">Visi</h3>
                        <p class="mb-8 text-gray-700 leading-relaxed">
                            Menjadi mitra solusi teknologi informasi terpadu <em>(One-Stop IT Solution)</em> yang tepercaya, baik di wilayah Bogor dan sekitarnya, maupun di seluruh Nusantara, guna mendukung produktivitas harian dan pertumbuhan bisnis pelanggan.
                        </p>

                        <h3 class="text-2xl font-bold mb-3 text-blue-900">Misi</h3>
                        <p class="mb-4 text-gray-700">Untuk mewujudkan visi tersebut, LKtech berkomitmen untuk:</p>
                        <ul class="list-disc pl-6 space-y-4 text-gray-700">
                            <li><strong>Penyediaan Perangkat Andal:</strong> Menghadirkan perangkat keras berkualitas tinggi, mulai dari laptop second premium hingga perakitan PC custom yang disesuaikan dengan kebutuhan dan anggaran pelanggan.</li>
                            <li><strong>Solusi Digital Terdepan:</strong> Membantu UMKM dan perusahaan go-digital melalui jasa pembuatan website profesional yang modern, responsif, dan siap bersaing.</li>
                            <li><strong>Layanan Purna Jual & Servis Unggul:</strong> Memberikan dukungan teknis terbaik melalui layanan servis, maintenance, dan penyewaan IT dengan jaminan garansi yang transparan dan bertanggung jawab.</li>
                            <li><strong>Kualitas Tanpa Kompromi:</strong> Menerapkan proses Quality Control (QC) yang ketat di setiap produk dan layanan untuk memastikan kepuasan dan kepercayaan pelanggan selalu terjaga.</li>
                        </ul>
                    </div>

                    <!-- 3. MENGAPA MEMILIH KAMI SECTION -->
                    <div>
                        <h2 class="text-2xl font-bold text-center text-gray-900 mb-10 font-montserrat">Mengapa Memilih Kami?</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Card 1 -->
                            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow text-center group">
                                <div class="w-16 h-16 bg-emerald-50 group-hover:bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-5 transition-colors">
                                    <i class='bx bx-check-shield text-3xl'></i>
                                </div>
                                <h4 class="font-bold text-gray-900 mb-3 text-lg">Quality Control Ketat</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Setiap produk melewati 2 lapis pengujian teknis untuk memastikan performa dan fisik maksimal.</p>
                            </div>
                            <!-- Card 2 -->
                            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow text-center group">
                                <div class="w-16 h-16 bg-blue-50 group-hover:bg-blue-100 text-brand-500 rounded-full flex items-center justify-center mx-auto mb-5 transition-colors">
                                    <i class='bx bx-money text-3xl'></i>
                                </div>
                                <h4 class="font-bold text-gray-900 mb-3 text-lg">Harga Transparan</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Penawaran harga terbaik dan sangat bersaing di pasaran tanpa adanya biaya tersembunyi.</p>
                            </div>
                            <!-- Card 3 -->
                            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow text-center group">
                                <div class="w-16 h-16 bg-purple-50 group-hover:bg-purple-100 text-purple-500 rounded-full flex items-center justify-center mx-auto mb-5 transition-colors">
                                    <i class='bx bx-support text-3xl'></i>
                                </div>
                                <h4 class="font-bold text-gray-900 mb-3 text-lg">Layanan Purna Jual</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Dukungan teknisi (*after-sales*) yang ramah, cepat tanggap, dan senantiasa siap membantu.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Mobile Bottom Navigation -->
    <x-mobile-bottom-nav />

</body>
</html>
