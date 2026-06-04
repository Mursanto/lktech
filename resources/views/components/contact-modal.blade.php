<!-- Modal Form Hubungi Kami -->
<div x-data="{ showContactModal: false }" 
     @open-contact-modal.window="showContactModal = true"
     x-show="showContactModal" 
     class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4" x-cloak>
    <div x-show="showContactModal"
         @click.outside="showContactModal = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col max-h-full">
         
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 flex-shrink-0">
            <h3 class="font-black text-lg text-gray-800 font-montserrat">Hubungi Kami</h3>
            <button @click="showContactModal = false" class="text-gray-400 hover:text-red-500 transition-colors">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <form action="{{ route('katalog.contact') }}" method="POST" class="p-6 space-y-4 overflow-y-auto">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow" placeholder="Masukkan nama Anda">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" required pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title="Harap masukkan format email yang valid dengan domain yang benar" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow" placeholder="contoh@email.com">
                <p class="text-[10px] text-gray-500 mt-1">* Pastikan email valid (misal: @gmail.com) agar kami dapat membalas pesan Anda.</p>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Pesan & Kebutuhan <span class="text-red-500">*</span></label>
                <textarea name="message" required rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow resize-none" placeholder="Ceritakan kebutuhan pengadaan, servis, atau pertanyaan Anda di sini..."></textarea>
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full bg-brand-600 text-white font-bold py-3 rounded-lg hover:bg-brand-700 transition-colors shadow-sm flex justify-center items-center gap-2">
                    <i class='bx bx-send'></i> Kirim Pesan
                </button>
            </div>
        </form>
    </div>
</div>
