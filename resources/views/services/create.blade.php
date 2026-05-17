<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Service Baru
            </h2>
            <nav class="text-sm font-medium text-gray-500">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="hover:text-brand-600 text-xs">Dashboard</a>
                        <i class='bx bx-chevron-right mx-1 text-xs'></i>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('services.index') }}" class="hover:text-brand-600 text-xs">Services</a>
                        <i class='bx bx-chevron-right mx-1 text-xs'></i>
                    </li>
                    <li class="text-gray-800 font-bold text-xs">Tambah</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-4 h-[calc(100vh-65px)] overflow-hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full flex flex-col">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex-grow flex flex-col overflow-hidden">
                <form action="{{ route('services.store') }}" method="POST" class="flex-grow flex flex-col md:flex-row overflow-hidden">
                    @csrf

                    <!-- ===== LEFT PANEL: Data Operasional ===== -->
                    <div class="w-full md:w-[60%] lg:w-[65%] p-4 md:p-5 overflow-y-auto border-r border-gray-100 scrollbar-hide space-y-3">
                        <h3 class="text-sm font-bold text-brand-700 uppercase tracking-wider border-b pb-1">Data Operasional</h3>

                        <!-- 1. Informasi Pelanggan -->
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-lg p-3 border border-gray-200">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-xs font-bold text-gray-800 uppercase">Informasi Pelanggan</h4>
                                <label class="inline-flex items-center cursor-pointer bg-blue-50 px-2 py-0.5 rounded border border-blue-200 hover:bg-blue-100 transition shadow-sm">
                                    <input type="checkbox" id="new_customer_toggle" name="is_new_customer" value="1" class="form-checkbox h-3 w-3 text-blue-600 rounded">
                                    <span class="ml-1.5 text-[10px] font-bold text-gray-700 uppercase">Pelanggan Baru</span>
                                </label>
                            </div>

                            {{-- Existing Customer --}}
                            <div id="existing_customer_area">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Nama Pelanggan *</label>
                                        <select name="customer_id" id="customer_id" required class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500">
                                            <option value="">-- Pilih --</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" data-address="{{ $customer->address }}" data-phone="{{ $customer->phone }}" data-email="{{ $customer->email }}">
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Telepon</label>
                                        <input type="text" id="customer_phone" readonly class="w-full border border-gray-200 rounded px-2 py-1 text-xs bg-gray-100 text-gray-600">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Email</label>
                                        <input type="email" id="customer_email" readonly class="w-full border border-gray-200 rounded px-2 py-1 text-xs bg-gray-100 text-gray-600">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Alamat</label>
                                        <input type="text" id="customer_address" readonly class="w-full border border-gray-200 rounded px-2 py-1 text-xs bg-gray-100 text-gray-600">
                                    </div>
                                </div>
                            </div>

                            {{-- New Customer --}}
                            <div id="new_customer_area" class="hidden">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Nama Baru *</label>
                                        <input type="text" name="new_customer_name" id="new_customer_name" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500" placeholder="Nama lengkap">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Telepon *</label>
                                        <input type="text" name="new_customer_phone" id="new_customer_phone" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500" placeholder="0812...">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Email</label>
                                        <input type="email" name="new_customer_email" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500" placeholder="email@...">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Alamat</label>
                                        <input type="text" name="new_customer_address" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500" placeholder="Alamat lengkap">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Detail Perangkat (Manual Input) -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-3 border border-blue-100">
                            <h4 class="text-xs font-bold text-gray-800 uppercase mb-2">Detail Perangkat</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Model / Type *</label>
                                    <input type="text" name="device_name" required class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500" placeholder="Cth: ThinkPad T470s, Acer Aspire 5">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Serial Number / IMEI</label>
                                    <input type="text" name="serial_number" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500" placeholder="SN: ...">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Kelengkapan Unit</label>
                                    <input type="text" name="equipment_details" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500" placeholder="Laptop, Charger, Tas">
                                </div>
                            </div>
                        </div>

                        <!-- 3. Keluhan & Catatan Teknisi (Side-by-Side) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-3 border border-green-100">
                                <h4 class="text-xs font-bold text-gray-800 uppercase mb-2">Keluhan / Kendala *</h4>
                                <textarea name="complaint" required rows="4" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white resize-none focus:ring-1 focus:ring-emerald-500" placeholder="Deskripsikan masalah yang dilaporkan pelanggan..."></textarea>
                            </div>
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-lg p-3 border border-purple-100">
                                <h4 class="text-xs font-bold text-gray-800 uppercase mb-2">Catatan Teknisi</h4>
                                <textarea name="notes" rows="4" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white resize-none focus:ring-1 focus:ring-emerald-500" placeholder="Catatan awal diagnosa atau instruksi khusus..."></textarea>
                            </div>
                        </div>

                        <!-- 4. Sparepart Digunakan (Opsional, dari Inventaris) -->
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-lg p-3 border border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h4 class="text-xs font-bold text-gray-800 uppercase">Sparepart / Produk Digunakan <span class="text-gray-400 font-normal normal-case text-[10px]">(Opsional)</span></h4>
                                <span class="text-[9px] text-gray-400">Harga otomatis masuk ke Estimasi Suku Cadang</span>
                            </div>
                            <select name="parts[]" id="parts-select" multiple class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white h-20 focus:ring-1 focus:ring-emerald-500">
                                @foreach($groupedProducts as $category => $products)
                                    <optgroup label="{{ $category }}">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}"
                                                data-price="{{ $product->selling_price ?? 0 }}">
                                                {{ $product->brand }} {{ $product->model_series }} — Rp {{ number_format($product->selling_price ?? 0, 0, ',', '.') }} (Sisa: {{ $product->stock }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <p class="text-[9px] text-gray-400 mt-1">Tahan Ctrl (Windows) / Command (Mac) untuk pilih lebih dari satu. Stok akan otomatis dikurangi saat disimpan.</p>
                        </div>
                    </div>

                    <!-- ===== RIGHT PANEL: Admin & Biaya ===== -->
                    <div class="w-full md:w-[40%] lg:w-[35%] p-4 md:p-5 bg-gray-50 flex flex-col overflow-y-auto scrollbar-hide">
                        <h3 class="text-sm font-bold text-brand-700 uppercase tracking-wider mb-3 border-b pb-1">Admin & Biaya</h3>

                        <!-- Penugasan & Status -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 mb-3 shadow-sm">
                            <h4 class="text-[10px] font-bold text-gray-500 uppercase mb-2">Penugasan & Status</h4>
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 mb-0.5">Teknisi Bertugas *</label>
                                    <select name="technician_id" required class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 focus:ring-1 focus:ring-emerald-500">
                                        <option value="">-- Pilih --</option>
                                        @foreach($technicians as $technician)
                                            <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 mb-0.5">Status Awal *</label>
                                    <select name="status" required class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 font-bold text-yellow-600 focus:ring-1 focus:ring-emerald-500">
                                        <option value="pending">⏳ Menunggu / Antrian</option>
                                        <option value="process">🔧 Sedang Diproses</option>
                                        <option value="done">✅ Selesai (Done)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Ringkasan Biaya -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 mb-3 shadow-sm flex-grow">
                            <h4 class="text-[10px] font-bold text-gray-500 uppercase mb-2">Ringkasan Biaya</h4>
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 mb-0.5">Estimasi Suku Cadang</label>
                                    <div class="relative">
                                        <span class="absolute left-2 top-1 text-xs text-gray-400 font-bold">Rp</span>
                                        <input type="number" name="estimated_parts_cost" id="estimated_parts_cost" min="0" value="0"
                                               class="w-full border border-gray-300 rounded pl-7 pr-2 py-1 text-xs text-right font-bold text-blue-600 bg-gray-50 focus:ring-1 focus:ring-brand-500">
                                    </div>
                                    <p class="text-[9px] text-gray-400 mt-0.5">Otomatis terisi dari sparepart yang dipilih. Bisa diubah manual.</p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 mb-0.5">Biaya Jasa *</label>
                                    <div class="relative">
                                        <span class="absolute left-2 top-1 text-xs text-gray-400 font-bold">Rp</span>
                                        <input type="number" name="service_fee" id="service_fee" required min="0" value="0"
                                               class="w-full border border-gray-300 rounded pl-7 pr-2 py-1 text-xs text-right font-bold text-emerald-600 bg-gray-50 focus:ring-1 focus:ring-brand-500">
                                    </div>
                                </div>
                                <div class="pt-2 border-t mt-1">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Grand Total</label>
                                    <div id="grand-total" class="text-xl font-black text-emerald-600 text-right">Rp 0</div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-auto space-y-2 pt-2 border-t border-gray-200">
                            <button type="submit" class="w-full px-4 py-2 bg-emerald-600 text-white rounded font-bold text-xs shadow hover:bg-emerald-700 transition uppercase flex justify-center items-center gap-1">
                                <i class='bx bx-check-circle text-sm'></i> Simpan Servis
                            </button>
                            <a href="{{ route('services.index') }}" class="w-full px-4 py-1.5 bg-white border border-gray-300 text-gray-600 rounded font-bold text-xs shadow-sm hover:bg-gray-50 transition uppercase flex justify-center items-center text-center">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($errors->any() || session('error'))
        <div class="fixed bottom-4 right-4 bg-red-600 text-white p-3 rounded shadow-lg max-w-sm z-50 text-xs">
            <strong class="block mb-1"><i class='bx bx-error-circle'></i> Error:</strong>
            @if(session('error')) <p>{{ session('error') }}</p> @endif
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ---- Customer Toggle ----
            const toggleNew   = document.getElementById('new_customer_toggle');
            const existArea   = document.getElementById('existing_customer_area');
            const newArea     = document.getElementById('new_customer_area');
            const existingSel = document.getElementById('customer_id');

            toggleNew.addEventListener('change', function() {
                if (this.checked) {
                    existArea.classList.add('hidden');
                    newArea.classList.remove('hidden');
                    existingSel.removeAttribute('required');
                    document.getElementById('new_customer_name').setAttribute('required', 'true');
                    document.getElementById('new_customer_phone').setAttribute('required', 'true');
                } else {
                    existArea.classList.remove('hidden');
                    newArea.classList.add('hidden');
                    existingSel.setAttribute('required', 'true');
                    document.getElementById('new_customer_name').removeAttribute('required');
                    document.getElementById('new_customer_phone').removeAttribute('required');
                }
            });

            existingSel.addEventListener('change', function() {
                const sel = this.options[this.selectedIndex];
                document.getElementById('customer_address').value = sel.getAttribute('data-address') || '';
                document.getElementById('customer_phone').value   = sel.getAttribute('data-phone')   || '';
                document.getElementById('customer_email').value   = sel.getAttribute('data-email')   || '';
            });

            // ---- Auto-calculate cost from sparepart selection ----
            const partsSelect    = document.getElementById('parts-select');
            const partsInput     = document.getElementById('estimated_parts_cost');
            const serviceFeeInp  = document.getElementById('service_fee');
            const grandTotalDisp = document.getElementById('grand-total');

            function recalcFromParts() {
                let total = 0;
                Array.from(partsSelect.selectedOptions).forEach(opt => {
                    total += parseFloat(opt.getAttribute('data-price')) || 0;
                });
                partsInput.value = total;
                recalcGrandTotal();
            }

            function recalcGrandTotal() {
                const parts   = parseFloat(partsInput.value)    || 0;
                const fee     = parseFloat(serviceFeeInp.value) || 0;
                const total   = parts + fee;
                grandTotalDisp.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }

            partsSelect.addEventListener('change', recalcFromParts);
            partsInput.addEventListener('input', recalcGrandTotal);
            serviceFeeInp.addEventListener('input', recalcGrandTotal);
        });
    </script>
</x-app-layout>
