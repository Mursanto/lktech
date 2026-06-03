<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Data Sewa Laptop</h2>
            <nav class="text-sm font-medium text-gray-500">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center"><a href="{{ route('dashboard') }}" class="hover:text-brand-600 text-xs">Dashboard</a><i class='bx bx-chevron-right mx-1 text-xs'></i></li>
                    <li class="flex items-center"><a href="{{ route('rentals.index') }}" class="hover:text-brand-600 text-xs">Sewa</a><i class='bx bx-chevron-right mx-1 text-xs'></i></li>
                    <li class="text-gray-800 font-bold text-xs">Tambah</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-4 h-[calc(100vh-65px)] overflow-hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full flex flex-col">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex-grow flex flex-col overflow-hidden">
                <form method="POST" action="{{ route('rentals.store') }}" class="flex-grow flex flex-col md:flex-row overflow-hidden">
                    @csrf
                    <input type="hidden" name="is_new_customer" id="is_new_customer_input" value="0">

                    <!-- ===== LEFT: Data Pelanggan ===== -->
                    <div class="w-full md:w-1/2 p-4 md:p-5 overflow-y-auto border-r border-gray-100 scrollbar-hide flex flex-col gap-3">

                        <!-- Header with toggle -->
                        <div class="flex items-center justify-between border-b border-teal-100 pb-1">
                            <h3 class="text-sm font-bold text-teal-700 uppercase tracking-wider flex items-center gap-2">
                                <i class='bx bx-user text-teal-500'></i> Data Pelanggan
                            </h3>
                            <label class="inline-flex items-center cursor-pointer bg-blue-50 px-2 py-0.5 rounded border border-blue-200 hover:bg-blue-100 transition shadow-sm">
                                <input type="checkbox" id="new_customer_toggle" class="form-checkbox h-3 w-3 text-blue-600 rounded">
                                <span class="ml-1.5 text-[10px] font-bold text-gray-700 uppercase">Pelanggan Baru</span>
                            </label>
                        </div>

                        <!-- === EXISTING CUSTOMER AREA === -->
                        <div id="existing_customer_area" class="flex flex-col gap-3">
                            <div class="bg-teal-50 rounded-lg p-3 border border-teal-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Pilih Pelanggan *</label>
                                <select name="customer_id" id="customer_id" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500 focus:border-teal-500">
                                    <option value="">-- Cari Nama Pelanggan --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            data-phone="{{ $customer->phone }}"
                                            data-name="{{ $customer->name }}"
                                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} — {{ $customer->phone }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Nama (Auto)</label>
                                    <input type="text" id="display_name" readonly class="w-full border border-gray-200 rounded px-2 py-1 text-xs bg-gray-100 text-gray-600">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">No. HP (Auto)</label>
                                    <input type="text" id="display_phone" readonly class="w-full border border-gray-200 rounded px-2 py-1 text-xs bg-gray-100 text-gray-600">
                                </div>
                            </div>
                        </div>

                        <!-- === NEW CUSTOMER AREA (hidden by default) === -->
                        <div id="new_customer_area" class="hidden flex flex-col gap-2">
                            <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                                <p class="text-[10px] font-bold text-blue-600 uppercase mb-2 flex items-center gap-1"><i class='bx bx-user-plus'></i> Input Data Pelanggan Baru</p>
                                <div class="space-y-2">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Nama Lengkap *</label>
                                        <input type="text" name="new_customer_name" id="new_customer_name"
                                            value="{{ old('new_customer_name') }}"
                                            class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500"
                                            placeholder="Nama lengkap pelanggan">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">No. HP *</label>
                                        <input type="text" name="new_customer_phone" id="new_customer_phone"
                                            value="{{ old('new_customer_phone') }}"
                                            class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500"
                                            placeholder="0812-xxxx-xxxx">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Alamat</label>
                                        <input type="text" name="new_customer_address"
                                            value="{{ old('new_customer_address') }}"
                                            class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500"
                                            placeholder="Alamat lengkap (opsional)">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Status Sewa *</label>
                            <select name="status" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500 font-bold text-blue-600">
                                <option value="active"    {{ old('status', 'active') == 'active'    ? 'selected' : '' }}>🟢 Aktif (Sedang Disewa)</option>
                                <option value="completed" {{ old('status') == 'completed'            ? 'selected' : '' }}>✅ Selesai (Dikembalikan)</option>
                                <option value="overdue"   {{ old('status') == 'overdue'              ? 'selected' : '' }}>⚠️ Terlambat</option>
                            </select>
                        </div>

                        <!-- Notes (flexible height) -->
                        <div class="flex-grow flex flex-col">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Catatan Tambahan</label>
                            <textarea name="notes" class="flex-grow w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 resize-none focus:ring-1 focus:ring-teal-500 min-h-[60px]"
                                placeholder="Kondisi unit, jaminan, kelengkapan yang diserahkan...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- ===== RIGHT: Data Unit & Transaksi ===== -->
                    <div class="w-full md:w-1/2 p-4 md:p-5 bg-gray-50 flex flex-col gap-3 overflow-y-auto scrollbar-hide">
                        <h3 class="text-sm font-bold text-teal-700 uppercase tracking-wider border-b border-teal-100 pb-1 flex items-center gap-2">
                            <i class='bx bx-laptop text-teal-500'></i> Data Unit & Transaksi
                        </h3>

                        <!-- Pilih Unit -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Pilih Unit Laptop *</label>
                            <select name="product_id" id="product_id" required
                                class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 focus:ring-1 focus:ring-teal-500">
                                <option value="">-- Cari & Pilih Unit --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->brand }} {{ $product->model_series }} — SN: {{ $product->serial_number ?? 'N/A' }} (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Manual SN -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">SN / License Key</label>
                            <input type="text" name="manual_sn" value="{{ old('manual_sn') }}" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-teal-500" placeholder="Input SN fisik / Kode Lisensi Manual (Opsional)">
                        </div>

                        <!-- Tanggal -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Tanggal Pinjam *</label>
                                    <input type="date" name="rental_date" id="rental_date"
                                        value="{{ old('rental_date', date('Y-m-d')) }}" required
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 focus:ring-1 focus:ring-teal-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Tanggal Kembali *</label>
                                    <input type="date" name="return_date" id="return_date"
                                        value="{{ old('return_date', date('Y-m-d', strtotime('+1 day'))) }}" required
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 focus:ring-1 focus:ring-teal-500">
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <span class="inline-block bg-teal-50 text-teal-700 text-[10px] font-bold px-3 py-0.5 rounded border border-teal-200">
                                    Durasi: <span id="duration-days">1</span> Hari
                                </span>
                            </div>
                        </div>

                        <!-- Kalkulasi Harga -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm flex-grow">
                            <h4 class="text-[10px] font-bold text-gray-500 uppercase mb-2">Kalkulasi Biaya Sewa</h4>
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 mb-0.5">Harga Sewa per Hari *</label>
                                    <div class="relative">
                                        <span class="absolute left-2 top-1 text-xs text-gray-400 font-bold">Rp</span>
                                        <input type="number" name="daily_price" id="daily_price" min="0" step="1000"
                                            value="{{ old('daily_price', 0) }}"
                                            class="w-full border border-gray-300 rounded pl-7 pr-2 py-1 text-xs text-right font-bold text-blue-600 bg-gray-50 focus:ring-1 focus:ring-teal-500"
                                            placeholder="50000">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 mb-0.5">Harga Sewa Keseluruhan (Auto)</label>
                                    <div class="relative">
                                        <span class="absolute left-2 top-1 text-xs text-gray-400 font-bold">Rp</span>
                                        <input type="number" name="total_price" id="total_price" min="0" step="1000"
                                            value="{{ old('total_price', 0) }}" required
                                            class="w-full border border-gray-300 rounded pl-7 pr-2 py-1 text-xs text-right font-bold text-emerald-600 bg-emerald-50 focus:ring-1 focus:ring-teal-500">
                                    </div>
                                    <p class="text-[9px] text-gray-400 mt-0.5">= Harga/Hari × Durasi. Bisa diubah manual.</p>
                                </div>
                                <div class="pt-2 border-t">
                                    <div id="total-display" class="text-xl font-black text-emerald-600 text-right">Rp 0</div>
                                    <p class="text-[9px] text-gray-400 text-right">Total yang harus dibayar</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-2 pt-2 border-t border-gray-200">
                            <button type="submit" class="w-full px-4 py-2 bg-teal-600 text-white rounded font-bold text-xs shadow hover:bg-teal-700 transition uppercase flex justify-center items-center gap-1">
                                <i class='bx bx-save text-sm'></i> Simpan Data Sewa
                            </button>
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
            <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ---- New Customer Toggle ----
        const toggle         = document.getElementById('new_customer_toggle');
        const existingArea   = document.getElementById('existing_customer_area');
        const newArea        = document.getElementById('new_customer_area');
        const hiddenInput    = document.getElementById('is_new_customer_input');
        const customerSel    = document.getElementById('customer_id');
        const newNameInp     = document.getElementById('new_customer_name');
        const newPhoneInp    = document.getElementById('new_customer_phone');

        toggle.addEventListener('change', function() {
            if (this.checked) {
                existingArea.classList.add('hidden');
                newArea.classList.remove('hidden');
                hiddenInput.value = '1';
                customerSel.removeAttribute('required');
                newNameInp.setAttribute('required', 'true');
                newPhoneInp.setAttribute('required', 'true');
            } else {
                existingArea.classList.remove('hidden');
                newArea.classList.add('hidden');
                hiddenInput.value = '0';
                customerSel.setAttribute('required', 'true');
                newNameInp.removeAttribute('required');
                newPhoneInp.removeAttribute('required');
            }
        });

        // ---- Existing Customer Auto-fill ----
        const displayName  = document.getElementById('display_name');
        const displayPhone = document.getElementById('display_phone');

        customerSel.addEventListener('change', function() {
            const sel = this.options[this.selectedIndex];
            displayName.value  = sel.getAttribute('data-name')  || '';
            displayPhone.value = sel.getAttribute('data-phone') || '';
        });
        if (customerSel.value) customerSel.dispatchEvent(new Event('change'));

        // ---- Date Calc ----
        const rentalDate   = document.getElementById('rental_date');
        const returnDate   = document.getElementById('return_date');
        const dailyPrice   = document.getElementById('daily_price');
        const totalPrice   = document.getElementById('total_price');
        const totalDisplay = document.getElementById('total-display');
        const durationDays = document.getElementById('duration-days');

        function getDays() {
            const d1 = new Date(rentalDate.value);
            const d2 = new Date(returnDate.value);
            if (isNaN(d1) || isNaN(d2) || d2 < d1) return 1;
            return Math.max(1, Math.round((d2 - d1) / (1000 * 60 * 60 * 24)));
        }

        function recalc() {
            const days  = getDays();
            const price = parseFloat(dailyPrice.value) || 0;
            const total = days * price;
            durationDays.textContent = days;
            totalPrice.value = total;
            totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        rentalDate.addEventListener('change', recalc);
        returnDate.addEventListener('change', recalc);
        dailyPrice.addEventListener('input', recalc);
        totalPrice.addEventListener('input', function() {
            totalDisplay.textContent = 'Rp ' + (parseFloat(this.value) || 0).toLocaleString('id-ID');
        });

        recalc();
    });
    </script>
</x-app-layout>
