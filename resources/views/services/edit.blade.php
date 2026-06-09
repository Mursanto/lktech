<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Service #{{ $service->id }}
            </h2>
            <div class="flex items-center gap-3">
                <span class="px-2 py-1 text-[10px] font-black rounded uppercase
                    {{ $service->status == 'done' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' :
                       ($service->status == 'process' ? 'bg-blue-100 text-blue-700 border border-blue-200' :
                       ($service->status == 'cancelled' ? 'bg-red-100 text-red-700 border border-red-200' :
                       'bg-yellow-100 text-yellow-700 border border-yellow-200')) }}">
                    {{ strtoupper($service->status) }}
                </span>
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
                        <li class="text-gray-800 font-bold text-xs">Edit #{{ $service->id }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-4 h-[calc(100vh-65px)] overflow-hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full flex flex-col">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex-grow flex flex-col overflow-hidden">
                <form action="{{ route('services.update', $service->id) }}" method="POST" class="flex-grow flex flex-col md:flex-row overflow-hidden" 
                      x-data="{ 
                          items: {{ json_encode($service->items->count() > 0 ? $service->items : [['device_name' => $service->device_name, 'serial_number' => $service->serial_number, 'equipment_details' => $service->equipment_details, 'complaint' => $service->complaint, 'service_charge' => $service->service_fee, 'spareparts' => []]]) }},
                          get totalPartsCost() {
                              return this.items.reduce((sum, item) => {
                                  return sum + (item.spareparts ? item.spareparts.reduce((pSum, part) => pSum + (parseFloat(part.price) || 0), 0) : 0);
                              }, 0);
                          },
                          get totalServiceFee() {
                              return this.items.reduce((sum, item) => sum + (parseFloat(item.service_charge) || 0), 0);
                          },
                          get grandTotal() {
                              return this.totalPartsCost + this.totalServiceFee;
                          }
                      }">
                    @csrf
                    @method('PUT')

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

                            <div id="existing_customer_area">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                    <div class="md:col-span-1">
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Nama Pelanggan *</label>
                                        <select name="customer_id" id="customer_id" required class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500">
                                            <option value="">-- Pilih --</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    data-address="{{ $customer->address }}"
                                                    data-phone="{{ $customer->phone }}"
                                                    data-email="{{ $customer->email }}"
                                                    {{ $service->customer_id == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Telepon</label>
                                        <input type="text" id="customer_phone" readonly class="w-full border border-gray-200 rounded px-2 py-1 text-xs bg-gray-100 text-gray-600" value="{{ $service->customer->phone ?? '' }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Email</label>
                                        <input type="email" id="customer_email" name="customer_email" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 focus:ring-1 focus:ring-emerald-500" value="{{ $service->customer->email ?? '' }}">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Alamat</label>
                                        <input type="text" id="customer_address" readonly class="w-full border border-gray-200 rounded px-2 py-1 text-xs bg-gray-100 text-gray-600" value="{{ $service->customer->address ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div id="new_customer_area" class="hidden">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                    <div class="md:col-span-1">
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

                        <!-- 2. Detail Perangkat & Keluhan (Dynamic Array) -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-3 border border-blue-100">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-xs font-bold text-gray-800 uppercase">Perangkat & Keluhan</h4>
                                <button type="button" @click="if(items.length < 10) items.push({ device_name: '', serial_number: '', equipment_details: '', complaint: '', service_charge: 0, spareparts: [] })" 
                                        x-show="items.length < 10"
                                        class="px-2 py-1 bg-blue-600 text-white text-[10px] font-bold rounded shadow hover:bg-blue-700 transition">
                                    + Tambah Perangkat (Maks 10)
                                </button>
                            </div>
                            
                            <template x-for="(item, index) in items" :key="index">
                                <div class="bg-white p-3 rounded border border-gray-200 mb-4 shadow-sm relative">
                                    <div class="absolute top-2 right-2" x-show="items.length > 1">
                                        <button type="button" @click="items.splice(index, 1)" class="text-red-500 hover:text-red-700">
                                            <i class='bx bx-trash text-sm'></i>
                                        </button>
                                    </div>
                                    <h5 class="text-[10px] font-bold text-blue-800 uppercase mb-2 border-b pb-1" x-text="'Perangkat #' + (index + 1)"></h5>
                                    
                                    <!-- Meta Perangkat -->
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mb-2">
                                        <div class="md:col-span-1">
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Model / Type *</label>
                                            <input type="text" :name="'items['+index+'][device_name]'" x-model="item.device_name" required class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500" placeholder="Cth: ThinkPad T470s">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Serial No / IMEI</label>
                                            <input type="text" :name="'items['+index+'][serial_number]'" x-model="item.serial_number" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500" placeholder="SN: ...">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Kelengkapan Unit</label>
                                            <input type="text" :name="'items['+index+'][equipment_details]'" x-model="item.equipment_details" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500" placeholder="Laptop, Charger, Tas">
                                        </div>
                                    </div>

                                    <!-- Service Action -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mb-3">
                                        <div class="md:col-span-2">
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Keluhan / Kendala *</label>
                                            <input type="text" :name="'items['+index+'][complaint]'" x-model="item.complaint" required class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500" placeholder="Deskripsi keluhan pelanggan...">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-emerald-600 uppercase mb-0.5">Biaya Jasa *</label>
                                            <div class="relative">
                                                <span class="absolute left-2 top-1 text-xs text-gray-400 font-bold">Rp</span>
                                                <input type="number" :name="'items['+index+'][service_charge]'" x-model.number="item.service_charge" required min="0" class="w-full border border-gray-300 rounded pl-7 pr-2 py-1 text-xs text-right font-bold bg-white focus:ring-1 focus:ring-emerald-500">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Spareparts Nested Array -->
                                    <div class="bg-gray-50 rounded border border-gray-200 p-2">
                                        <div class="flex justify-between items-center mb-2">
                                            <label class="block text-[10px] font-bold text-gray-600 uppercase">Spareparts / Suku Cadang</label>
                                            <button type="button" @click="item.spareparts.push({ name: '', price: 0 })" class="text-[9px] font-bold bg-gray-200 hover:bg-gray-300 text-gray-700 px-2 py-0.5 rounded transition">
                                                + Tambah Sparepart
                                            </button>
                                        </div>
                                        <template x-for="(part, pIndex) in item.spareparts" :key="pIndex">
                                            <div class="flex items-center gap-2 mb-1">
                                                <input type="text" :name="'items['+index+'][spareparts]['+pIndex+'][name]'" x-model="part.name" required class="flex-grow border border-gray-300 rounded px-2 py-1 text-[10px] bg-white focus:ring-1 focus:ring-emerald-500" placeholder="Nama Sparepart (cth: SSD 512GB)">
                                                <div class="relative w-1/3">
                                                    <span class="absolute left-2 top-1 text-[10px] text-gray-400">Rp</span>
                                                    <input type="number" :name="'items['+index+'][spareparts]['+pIndex+'][price]'" x-model.number="part.price" required min="0" class="w-full border border-gray-300 rounded pl-6 pr-2 py-1 text-[10px] text-right font-bold bg-white focus:ring-1 focus:ring-emerald-500">
                                                </div>
                                                <button type="button" @click="item.spareparts.splice(pIndex, 1)" class="text-red-400 hover:text-red-600">
                                                    <i class='bx bx-x text-sm'></i>
                                                </button>
                                            </div>
                                        </template>
                                        <div x-show="item.spareparts.length === 0" class="text-[9px] text-gray-400 italic text-center py-1">
                                            Belum ada sparepart ditambahkan untuk perangkat ini.
                                        </div>
                                    </div>

                                </div>
                            </template>
                        </div>
                        
                        <!-- 3. Catatan Teknisi -->
                        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-lg p-3 border border-purple-100">
                            <h4 class="text-xs font-bold text-gray-800 uppercase mb-2">Catatan Teknisi</h4>
                            <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white resize-none focus:ring-1 focus:ring-emerald-500" placeholder="Catatan awal diagnosa atau instruksi khusus secara umum...">{{ $service->notes }}</textarea>
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
                                            <option value="{{ $technician->id }}" {{ $service->technician_id == $technician->id ? 'selected' : '' }}>
                                                {{ $technician->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 mb-0.5">Status *</label>
                                    <select name="status" required class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 font-bold focus:ring-1 focus:ring-emerald-500
                                        {{ $service->status == 'done' ? 'text-emerald-600' : ($service->status == 'process' ? 'text-blue-600' : ($service->status == 'cancelled' ? 'text-red-600' : 'text-yellow-600')) }}">
                                        <option value="pending"    {{ $service->status == 'pending'    ? 'selected' : '' }}>⏳ Menunggu / Antrian</option>
                                        <option value="process"   {{ $service->status == 'process'    ? 'selected' : '' }}>🔧 Sedang Diproses</option>
                                        <option value="done"      {{ $service->status == 'done'       ? 'selected' : '' }}>✅ Selesai (Done)</option>
                                        <option value="cancelled" {{ $service->status == 'cancelled'  ? 'selected' : '' }}>❌ Dibatalkan</option>
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
                                        <input type="number" readonly :value="totalPartsCost"
                                               class="w-full border border-gray-300 rounded pl-7 pr-2 py-1 text-xs text-right font-bold text-blue-600 bg-gray-100 focus:outline-none">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 mb-0.5">Biaya Jasa *</label>
                                    <div class="relative">
                                        <span class="absolute left-2 top-1 text-xs text-gray-400 font-bold">Rp</span>
                                        <input type="number" readonly :value="totalServiceFee"
                                               class="w-full border border-gray-300 rounded pl-7 pr-2 py-1 text-xs text-right font-bold text-emerald-600 bg-gray-100 focus:outline-none">
                                    </div>
                                </div>
                                <div class="pt-2 border-t mt-1">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Grand Total</label>
                                    <div class="text-xl font-black text-emerald-600 text-right" x-text="'Rp ' + grandTotal.toLocaleString('id-ID')">
                                        Rp 0
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Info -->
                        <div class="bg-brand-50 rounded-lg p-2.5 border border-brand-100 mb-3 text-[10px] text-brand-700 space-y-1">
                            <div class="flex justify-between"><span class="font-bold uppercase">Masuk:</span> <span>{{ $service->created_at ? $service->created_at->format('d M Y') : '-' }}</span></div>
                            <div class="flex justify-between"><span class="font-bold uppercase">Terakhir Update:</span> <span>{{ $service->updated_at ? $service->updated_at->format('d M Y H:i') : '-' }}</span></div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-auto space-y-2 pt-2 border-t border-gray-200">
                            <button type="submit" class="w-full px-4 py-2 bg-emerald-600 text-white rounded font-bold text-xs shadow hover:bg-emerald-700 transition uppercase flex justify-center items-center gap-1">
                                <i class='bx bx-check-circle text-sm'></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('services.show', $service->id) }}" class="w-full px-4 py-1.5 bg-white border border-brand-300 text-brand-600 rounded font-bold text-xs shadow-sm hover:bg-brand-50 transition uppercase flex justify-center items-center text-center">
                                <i class='bx bx-show mr-1'></i> Lihat Detail
                            </a>
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
            // Customer Toggle
            const toggleNew = document.getElementById('new_customer_toggle');
            const existArea = document.getElementById('existing_customer_area');
            const newArea   = document.getElementById('new_customer_area');
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

            // Auto-fill customer info
            existingSel.addEventListener('change', function() {
                const sel = this.options[this.selectedIndex];
                document.getElementById('customer_address').value = sel.getAttribute('data-address') || '';
                document.getElementById('customer_phone').value   = sel.getAttribute('data-phone')   || '';
                document.getElementById('customer_email').value   = sel.getAttribute('data-email')   || '';
            });

            // Grand Total auto-calc replaced by AlpineJS.
        });
    </script>
</x-app-layout>
