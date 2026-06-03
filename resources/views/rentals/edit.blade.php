<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Sewa #{{ $rental->id }}</h2>
            <div class="flex items-center gap-3">
                <span class="px-2 py-0.5 text-[10px] font-black rounded uppercase
                    {{ $rental->status == 'active' ? 'bg-blue-100 text-blue-700 border border-blue-200' :
                       ($rental->status == 'completed' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' :
                       'bg-red-100 text-red-700 border border-red-200') }}">
                    {{ strtoupper($rental->status) }}
                </span>
                <nav class="text-sm font-medium text-gray-500">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center"><a href="{{ route('dashboard') }}" class="hover:text-brand-600 text-xs">Dashboard</a><i class='bx bx-chevron-right mx-1 text-xs'></i></li>
                        <li class="flex items-center"><a href="{{ route('rentals.index') }}" class="hover:text-brand-600 text-xs">Sewa</a><i class='bx bx-chevron-right mx-1 text-xs'></i></li>
                        <li class="text-gray-800 font-bold text-xs">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-4 h-[calc(100vh-65px)] overflow-hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full flex flex-col">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex-grow flex flex-col overflow-hidden">
                <form method="POST" action="{{ route('rentals.update', $rental->id) }}" class="flex-grow flex flex-col md:flex-row overflow-hidden">
                    @csrf
                    @method('PUT')

                    <!-- hidden fields to pass customer_id if selected -->
                    <input type="hidden" name="customer_id" id="customer_id_hidden" value="{{ $rental->customer_id }}">

                    <!-- ===== LEFT: Data Pelanggan ===== -->
                    <div class="w-full md:w-1/2 p-4 md:p-5 overflow-y-auto border-r border-gray-100 scrollbar-hide space-y-3">
                        <h3 class="text-sm font-bold text-teal-700 uppercase tracking-wider border-b border-teal-100 pb-1 flex items-center gap-2">
                            <i class='bx bx-user text-teal-500'></i> Data Pelanggan
                        </h3>

                        <!-- Pilih Pelanggan (overrides manual fields) -->
                        <div class="bg-teal-50 rounded-lg p-3 border border-teal-100">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Ganti Pelanggan (Opsional)</label>
                            <select id="customer_sel"
                                class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500">
                                <option value="">-- Cari dari Database --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        data-phone="{{ $customer->phone }}"
                                        data-name="{{ $customer->name }}"
                                        {{ $rental->customer_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} — {{ $customer->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Manual editable fields (pre-filled from DB, can be overridden) -->
                        <div class="grid grid-cols-1 gap-2">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Nama Pelanggan *</label>
                                <input type="text" name="customer_name" id="customer_name" required
                                    value="{{ old('customer_name', $rental->customer_name) }}"
                                    class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">No. HP *</label>
                                <input type="text" name="customer_phone" id="customer_phone" required
                                    value="{{ old('customer_phone', $rental->customer_phone) }}"
                                    class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500">
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Status Sewa *</label>
                            <select name="status" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500 font-bold
                                {{ $rental->status == 'active' ? 'text-blue-600' : ($rental->status == 'completed' ? 'text-emerald-600' : 'text-red-600') }}">
                                <option value="active"    {{ old('status', $rental->status) == 'active'    ? 'selected' : '' }}>🟢 Aktif (Sedang Disewa)</option>
                                <option value="completed" {{ old('status', $rental->status) == 'completed' ? 'selected' : '' }}>✅ Selesai (Dikembalikan)</option>
                                <option value="overdue"   {{ old('status', $rental->status) == 'overdue'   ? 'selected' : '' }}>⚠️ Terlambat</option>
                            </select>
                        </div>

                        <!-- Notes -->
                        <div class="flex-grow">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Catatan Tambahan</label>
                            <textarea name="notes" rows="5" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 resize-none focus:ring-1 focus:ring-teal-500"
                                placeholder="Kondisi unit, jaminan, kelengkapan...">{{ old('notes', $rental->notes) }}</textarea>
                        </div>
                    </div>

                    <!-- ===== RIGHT: Data Unit & Transaksi ===== -->
                    <div class="w-full md:w-1/2 p-4 md:p-5 bg-gray-50 flex flex-col overflow-y-auto scrollbar-hide space-y-3">
                        <h3 class="text-sm font-bold text-teal-700 uppercase tracking-wider border-b border-teal-100 pb-1 flex items-center gap-2">
                            <i class='bx bx-laptop text-teal-500'></i> Data Unit & Transaksi
                        </h3>

                        <!-- Unit Fields (manual edit) -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Nama Laptop *</label>
                                    <input type="text" name="laptop_name" required
                                        value="{{ old('laptop_name', $rental->laptop_name) }}"
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500"
                                        placeholder="Brand Model">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Serial Number</label>
                                    <input type="text" name="serial_number"
                                        value="{{ old('serial_number', $rental->serial_number) }}"
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500"
                                        placeholder="SN: ...">
                                </div>
                            </div>
                        </div>

                        <!-- Manual SN -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">SN / License Key</label>
                            <input type="text" name="manual_sn" value="{{ old('manual_sn', $rental->manual_sn) }}" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500" placeholder="Input SN fisik / Kode Lisensi Manual (Opsional)">
                        </div>

                        <!-- Tanggal -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Tanggal Pinjam *</label>
                                    <input type="date" name="rental_date" id="rental_date" required
                                        value="{{ old('rental_date', optional($rental->rental_date)->format('Y-m-d')) }}"
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 focus:ring-1 focus:ring-teal-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Tanggal Kembali *</label>
                                    <input type="date" name="return_date" id="return_date" required
                                        value="{{ old('return_date', optional($rental->return_date)->format('Y-m-d')) }}"
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 focus:ring-1 focus:ring-teal-500">
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <span class="inline-block bg-teal-50 text-teal-700 text-[10px] font-bold px-3 py-0.5 rounded border border-teal-200">
                                    Durasi: <span id="duration-days">-</span> Hari
                                </span>
                            </div>
                        </div>

                        <!-- Kalkulasi Harga -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm flex-grow">
                            <h4 class="text-[10px] font-bold text-gray-500 uppercase mb-2">Kalkulasi Biaya Sewa</h4>
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 mb-0.5">Harga Sewa per Hari</label>
                                    <div class="relative">
                                        <span class="absolute left-2 top-1 text-xs text-gray-400 font-bold">Rp</span>
                                        <input type="number" name="daily_price" id="daily_price" min="0" step="1000"
                                            value="{{ old('daily_price', round($rental->daily_price ?? 0)) }}"
                                            class="w-full border border-gray-300 rounded pl-7 pr-2 py-1 text-xs text-right font-bold text-blue-600 bg-gray-50 focus:ring-1 focus:ring-teal-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 mb-0.5">Harga Sewa Keseluruhan *</label>
                                    <div class="relative">
                                        <span class="absolute left-2 top-1 text-xs text-gray-400 font-bold">Rp</span>
                                        <input type="number" name="total_price" id="total_price" min="0" step="1000" required
                                            value="{{ old('total_price', round($rental->total_price)) }}"
                                            class="w-full border border-gray-300 rounded pl-7 pr-2 py-1 text-xs text-right font-bold text-emerald-600 bg-emerald-50 focus:ring-1 focus:ring-teal-500">
                                    </div>
                                    <p class="text-[9px] text-gray-400 mt-0.5">= Harga/Hari × Durasi. Bisa diubah manual.</p>
                                </div>
                                <div class="pt-2 border-t">
                                    <div id="total-display" class="text-xl font-black text-emerald-600 text-right">
                                        Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                    </div>
                                    <p class="text-[9px] text-gray-400 text-right">Total yang harus dibayar</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-2 pt-2 border-t border-gray-200">
                            <button type="submit" class="w-full px-4 py-2 bg-teal-600 text-white rounded font-bold text-xs shadow hover:bg-teal-700 transition uppercase flex justify-center items-center gap-1">
                                <i class='bx bx-save text-sm'></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('rentals.show', $rental->id) }}" class="w-full px-4 py-1.5 bg-white border border-teal-300 text-teal-600 rounded font-bold text-xs shadow-sm hover:bg-teal-50 transition uppercase flex justify-center items-center text-center">
                                <i class='bx bx-show mr-1'></i> Lihat Detail
                            </a>
                            <a href="{{ route('rentals.index') }}" class="w-full px-4 py-1.5 bg-white border border-gray-300 text-gray-600 rounded font-bold text-xs shadow-sm hover:bg-gray-50 transition uppercase flex justify-center items-center text-center">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="fixed bottom-4 right-4 bg-red-600 text-white p-3 rounded shadow-lg max-w-sm z-50 text-xs">
            <strong class="block mb-1"><i class='bx bx-error-circle'></i> Error:</strong>
            <ul class="list-disc list-inside">@foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customerSel  = document.getElementById('customer_sel');
            const customerName = document.getElementById('customer_name');
            const customerPh   = document.getElementById('customer_phone');
            const hiddenId     = document.getElementById('customer_id_hidden');
            const rentalDate   = document.getElementById('rental_date');
            const returnDate   = document.getElementById('return_date');
            const dailyPrice   = document.getElementById('daily_price');
            const totalPrice   = document.getElementById('total_price');
            const totalDisp    = document.getElementById('total-display');
            const durDays      = document.getElementById('duration-days');

            // Customer override
            customerSel.addEventListener('change', function() {
                const sel = this.options[this.selectedIndex];
                if (sel.value) {
                    customerName.value = sel.getAttribute('data-name')  || '';
                    customerPh.value   = sel.getAttribute('data-phone') || '';
                    hiddenId.value     = sel.value;
                }
            });

            function getDays() {
                const d1 = new Date(rentalDate.value);
                const d2 = new Date(returnDate.value);
                if (!d1 || !d2 || d2 < d1) return 1;
                return Math.max(1, Math.round((d2 - d1) / (1000 * 60 * 60 * 24)));
            }

            function recalc() {
                const days  = getDays();
                const price = parseFloat(dailyPrice.value) || 0;
                const total = days * price;
                durDays.textContent = days;
                if (price > 0) totalPrice.value = total;
                totalDisp.textContent = 'Rp ' + (parseFloat(totalPrice.value) || 0).toLocaleString('id-ID');
            }

            rentalDate.addEventListener('change', recalc);
            returnDate.addEventListener('change', recalc);
            dailyPrice.addEventListener('input', recalc);
            totalPrice.addEventListener('input', function() {
                totalDisp.textContent = 'Rp ' + (parseFloat(this.value) || 0).toLocaleString('id-ID');
            });

            recalc();
        });
    </script>
</x-app-layout>
