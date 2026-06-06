<!-- 4 Info Cards Section -->
<div class="flex overflow-x-auto snap-x snap-mandatory gap-4 md:grid md:grid-cols-2 lg:grid-cols-4 md:overflow-visible hide-scrollbar py-2">
    <!-- Kartu 1: Penjualan -->
    <div class="group min-w-[85%] sm:min-w-[45%] md:min-w-0 snap-center md:snap-align-none bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-300">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-3">
            <i class='bx bx-laptop text-2xl'></i>
        </div>
        <h3 class="font-bold text-gray-900 text-[15px] mb-1">Penjualan Laptop Second</h3>
        <div class="max-h-10 group-hover:max-h-40 overflow-hidden transition-all duration-500 ease-in-out">
            <p class="text-[13px] text-gray-500 leading-relaxed">Temukan laptop second berkualitas premium dengan harga bersahabat. Setiap unit telah melewati Quality Control yang ketat dan dilengkapi garansi after-sales terpercaya demi kenyamanan Anda.</p>
        </div>
    </div>
    
    <!-- Kartu 2: Servis & Maintenance -->
    <div class="group min-w-[85%] sm:min-w-[45%] md:min-w-0 snap-center md:snap-align-none bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-300">
        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-3">
            <i class='bx bx-wrench text-2xl'></i>
        </div>
        <h3 class="font-bold text-gray-900 text-[15px] mb-1">Servis & Maintenance</h3>
        <div class="max-h-10 group-hover:max-h-40 overflow-hidden transition-all duration-500 ease-in-out">
            <p class="text-[13px] text-gray-500 leading-relaxed">Solusi perbaikan dan perawatan berkala untuk laptop maupun komputer instansi Anda. Dikerjakan langsung oleh teknisi ahli secara cepat, tepat, dan bergaransi penuh.</p>
        </div>
    </div>
    
    <!-- Kartu 3: Sewa Perangkat IT -->
    <div class="group min-w-[85%] sm:min-w-[45%] md:min-w-0 snap-center md:snap-align-none bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-300">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-3">
            <i class='bx bx-calendar text-2xl'></i>
        </div>
        <h3 class="font-bold text-gray-900 text-[15px] mb-1">Sewa Perangkat IT</h3>
        <div class="max-h-10 group-hover:max-h-40 overflow-hidden transition-all duration-500 ease-in-out">
            <p class="text-[13px] text-gray-500 leading-relaxed">Dukung kelancaran operasional acara dan bisnis Anda dengan layanan sewa perangkat IT harian, bulanan, hingga tahunan. Spesifikasi tangguh dengan penawaran harga yang sangat kompetitif.</p>
        </div>
    </div>

    <!-- Kartu 4: Kemitraan (Clickable) -->
    <button x-data @click="$dispatch('open-contact-modal')" type="button" class="group min-w-[85%] sm:min-w-[45%] md:min-w-0 snap-center md:snap-align-none text-left w-full bg-brand-50 border border-brand-100 rounded-2xl p-5 shadow-sm hover:bg-brand-100 hover:shadow-md transition-all duration-300 flex flex-col h-full">
        <div class="w-12 h-12 bg-white text-brand-600 rounded-xl flex items-center justify-center mb-3 shadow-sm group-hover:scale-110 transition-transform">
            <i class='bx bx-support text-2xl'></i>
        </div>
        <h3 class="font-bold text-brand-900 text-[15px] mb-1 group-hover:text-brand-700 transition-colors">Kemitraan & Partai Besar</h3>
        <div class="max-h-10 group-hover:max-h-40 overflow-hidden transition-all duration-500 ease-in-out">
            <p class="text-[13px] text-brand-700 leading-relaxed mb-2">Butuh pengadaan unit dalam jumlah banyak atau kontrak maintenance untuk instansi? Klik di sini untuk penawaran khusus!</p>
        </div>
        <div class="flex items-center text-xs font-bold text-brand-600 gap-1 group-hover:gap-2 transition-all mt-auto">
            Hubungi Kami <i class='bx bx-right-arrow-alt text-base'></i>
        </div>
    </button>
</div>
