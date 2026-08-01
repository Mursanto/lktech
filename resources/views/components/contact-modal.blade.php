<!-- Modal Form Hubungi Kami -->
<div x-data="{ showContactModal: false }" 
     @open-contact-modal.window="showContactModal = true"
     x-show="showContactModal" 
     class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4" x-cloak>
    <!-- Modal Backdrop -->
    <div class="fixed inset-0" @click="showContactModal = false"></div>
    
    <!-- Modal Content -->
    <div x-show="showContactModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 overflow-hidden z-10 border border-brand-100 max-h-full overflow-y-auto">
         
        <!-- Decorative Blue/Cyan header bar -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-blue-500 to-cyan-500"></div>
        
        <div class="absolute top-4 right-4">
            <button @click="showContactModal = false" class="text-gray-400 hover:text-gray-600 focus:outline-none p-1 rounded-full hover:bg-gray-100 transition">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <div class="text-center mb-8 mt-2">
            <img src="{{ asset('images/LKtech.png') }}" alt="LKTech" class="h-10 mx-auto mb-4">
            <h3 class="text-2xl font-black text-gray-800">Hubungi Kami</h3>
            <p class="text-sm text-gray-500 mt-1">Kami siap membantu pengadaan dan kemitraan Anda</p>
        </div>

        <form action="{{ route('katalog.contact') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class='bx bx-user text-gray-400 text-lg'></i>
                    </div>
                    <input type="text" name="name" required class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white" placeholder="Masukkan nama Anda">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class='bx bx-envelope text-gray-400 text-lg'></i>
                    </div>
                    <input type="email" name="email" required pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title="Harap masukkan format email yang valid dengan domain yang benar" class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white" placeholder="contoh@email.com">
                </div>
                <p class="text-[10px] text-gray-500 mt-1 font-medium">* Pastikan email valid (misal: @gmail.com) agar kami dapat membalas pesan Anda.</p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp / Telepon <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class='bx bxl-whatsapp text-gray-400 text-lg'></i>
                    </div>
                    <input type="tel" name="phone" required pattern="^[0-9+\-\s()]*$" title="Harap masukkan nomor telepon yang valid (hanya angka dan simbol +, -, spasi, tanda kurung yang diperbolehkan)" class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white" placeholder="08xxxxxxxxxx">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pesan & Kebutuhan <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                        <i class='bx bx-message-square-dots text-gray-400 text-lg'></i>
                    </div>
                    <textarea name="message" required rows="4" class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white resize-none" placeholder="Ceritakan kebutuhan pengadaan, servis, atau pertanyaan Anda di sini..."></textarea>
                </div>
            </div>
            
            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center items-center gap-2 py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                    <i class='bx bx-send'></i> Kirim Pesan
                </button>
            </div>
        </form>
    </div>
</div>
