<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class='bx bx-cart-alt text-emerald-600'></i> Kasir — Tambah Penjualan
            </h2>
            <nav class="text-sm font-medium text-gray-500">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center"><a href="{{ route('dashboard') }}" class="hover:text-brand-600 text-xs">Dashboard</a><i class='bx bx-chevron-right mx-1 text-xs'></i></li>
                    <li class="flex items-center"><a href="{{ route('sales.index') }}" class="hover:text-brand-600 text-xs">Penjualan</a><i class='bx bx-chevron-right mx-1 text-xs'></i></li>
                    <li class="text-gray-800 font-bold text-xs">Tambah</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    @if(session('error'))
        <div class="fixed top-16 right-4 bg-red-600 text-white p-3 rounded shadow-lg max-w-sm z-50 text-xs">
            <strong><i class='bx bx-error-circle'></i> Gagal!</strong> {{ session('error') }}
        </div>
    @endif

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Select2 compact sizing */
        .select2-container--default .select2-selection--single {
            height: 28px !important; border-radius: 4px !important;
            border-color: #d1d5db !important; background: white !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px !important; padding-left: 8px !important; font-size: 11px !important; color: #374151 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px !important;
        }
        .select2-dropdown { font-size: 11px !important; z-index: 9999 !important; }
        .select2-search__field { font-size: 11px !important; }
        /* Hide native select but keep it accessible for form submission */
        .native-select-hidden { position: absolute; opacity: 0; pointer-events: none; width: 1px; height: 1px; }
    </style>

    <div class="py-4 h-[calc(100vh-65px)] overflow-hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full flex flex-col">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex-grow flex flex-col overflow-hidden">
                {{-- novalidate: kita pakai JS validation sendiri agar tidak konflik dengan Select2 --}}
                <form action="{{ route('sales.store') }}" method="POST" id="saleForm" novalidate
                    class="flex-grow flex flex-col md:flex-row overflow-hidden">
                    @csrf

                    <!-- ===== LEFT: Data Operasional ===== -->
                    <div class="w-full md:w-[62%] lg:w-[65%] p-4 md:p-5 overflow-y-auto border-r border-gray-100 scrollbar-hide flex flex-col gap-3">
                        <h3 class="text-sm font-bold text-emerald-700 uppercase tracking-wider border-b border-emerald-100 pb-1">Data Operasional</h3>

                        <!-- 1. Informasi Pelanggan -->
                        <div class="bg-gradient-to-br from-slate-50 to-white rounded-lg p-3 border border-slate-200">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-xs font-bold text-gray-800 uppercase flex items-center gap-1">
                                    <i class='bx bx-user text-emerald-600'></i> Informasi Pelanggan
                                </h4>
                                <label class="inline-flex items-center cursor-pointer bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 hover:bg-emerald-100 transition shadow-sm">
                                    <input type="checkbox" id="new_customer_toggle" name="is_new_customer" value="1" class="form-checkbox h-3 w-3 text-emerald-600 rounded">
                                    <span class="ml-1.5 text-[10px] font-bold text-emerald-800 uppercase">Pelanggan Baru</span>
                                </label>
                            </div>

                            <!-- Existing Customer -->
                            <div id="existing_customer_area" class="grid grid-cols-3 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Nama Pelanggan</label>
                                    <select name="customer_id" id="customer_id"
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500">
                                        <option value="" data-email="" data-phone="">-- Pilih (Opsional) --</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" data-email="{{ $customer->email }}" data-phone="{{ $customer->phone }}">
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Email (Auto)</label>
                                    <input type="email" id="customer_email" readonly class="w-full border border-gray-200 rounded px-2 py-1 text-xs bg-gray-100 text-gray-600">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Telepon (Auto)</label>
                                    <input type="text" id="customer_phone" readonly class="w-full border border-gray-200 rounded px-2 py-1 text-xs bg-gray-100 text-gray-600">
                                </div>
                            </div>

                            <!-- New Customer (hidden by default) -->
                            <div id="new_customer_area" class="hidden grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Nama Pelanggan Baru *</label>
                                    <input type="text" name="new_customer_name" id="new_customer_name"
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500"
                                        placeholder="Nama lengkap">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Nomor Telepon *</label>
                                    <input type="text" name="new_customer_phone"
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500"
                                        placeholder="0812-xxxx-xxxx">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Email</label>
                                    <input type="email" name="new_customer_email"
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500"
                                        placeholder="opsional@email.com">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Alamat</label>
                                    <input type="text" name="new_customer_address"
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-white focus:ring-1 focus:ring-emerald-500"
                                        placeholder="Jl. No. Rumah, Kota">
                                </div>
                            </div>
                        </div>

                        <!-- 2. Pilih Produk -->
                        <div class="bg-white rounded-lg p-3 border border-slate-200 flex flex-col flex-grow min-h-0">
                            <h4 class="text-xs font-bold text-gray-800 uppercase mb-2 flex items-center gap-1 border-b border-slate-100 pb-1 shrink-0">
                                <i class='bx bx-cart text-emerald-600'></i> Pilih Produk
                            </h4>

                            <!-- Table Headers -->
                            <div class="grid grid-cols-12 gap-2 px-1 pb-1 text-[9px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 mb-2 shrink-0">
                                <div class="col-span-6">Produk</div>
                                <div class="col-span-2 text-center">Qty</div>
                                <div class="col-span-3 text-right pr-1">Subtotal</div>
                                <div class="col-span-1"></div>
                            </div>

                            <!-- Product Rows Container -->
                            <div id="products-container" class="flex flex-col gap-2 flex-grow min-h-0 pr-0.5">
                                <!-- First row injected by JS on load -->
                            </div>

                            <!-- Add Row Button -->
                            <div class="mt-2 pt-2 border-t border-slate-100 shrink-0">
                                <button type="button" id="add-product-btn"
                                    class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-700 rounded border border-slate-300 font-bold text-xs hover:bg-slate-200 transition gap-1">
                                    <i class='bx bx-plus'></i> Tambah Baris
                                </button>
                                <span id="row-error" class="ml-3 text-[10px] text-red-500 hidden">⚠️ Pilih produk pada semua baris sebelum menyimpan.</span>
                            </div>
                        </div>
                    </div>

                    <!-- ===== RIGHT: Ringkasan & Aksi ===== -->
                    <div class="w-full md:w-[38%] lg:w-[35%] p-4 md:p-5 bg-gray-50 flex flex-col gap-3 overflow-y-auto scrollbar-hide">
                        <h3 class="text-sm font-bold text-emerald-700 uppercase tracking-wider border-b border-emerald-100 pb-1">Ringkasan Penjualan</h3>

                        <!-- Grand Total -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm">
                            <div class="space-y-2">
                                <div class="flex justify-between items-center p-2 rounded bg-slate-50 border border-slate-100">
                                    <span class="text-xs font-bold text-slate-600">Total Item:</span>
                                    <span id="total-qty" class="text-sm font-black text-slate-800">0</span>
                                </div>
                                <div class="flex flex-col items-center p-3 bg-emerald-50 rounded border border-emerald-100">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Grand Total</span>
                                    <span id="grand-total" class="text-2xl font-extrabold text-emerald-600 w-full text-center">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm">
                            <h4 class="text-[10px] font-bold text-gray-500 uppercase mb-2">Informasi Pembayaran</h4>
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 mb-0.5">Metode Pembayaran</label>
                                    <select name="payment_method" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 focus:ring-1 focus:ring-emerald-500">
                                        <option value="cash">💵 Tunai (Cash)</option>
                                        <option value="transfer">🏦 Transfer Bank</option>
                                        <option value="qris">📱 QRIS</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 mb-0.5">Catatan</label>
                                    <textarea name="notes" rows="2" class="w-full border border-gray-300 rounded px-2 py-1 text-xs bg-gray-50 resize-none focus:ring-1 focus:ring-emerald-500" placeholder="Catatan tambahan..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Live Summary Items -->
                        <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm flex-grow overflow-y-auto min-h-[150px]">
                            <h4 class="text-[10px] font-bold text-gray-500 uppercase mb-1.5">Daftar Item</h4>
                            <div id="summary-items" class="text-xs text-gray-400 italic">Belum ada produk dipilih...</div>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-2 pt-2 border-t border-gray-200 shrink-0">
                            <button type="submit" id="submit-btn"
                                class="w-full px-4 py-3 bg-emerald-600 text-white rounded-lg font-black text-xs shadow-lg hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 transform transition-all uppercase tracking-widest flex justify-center items-center gap-1.5">
                                <i class='bx bx-check-circle text-lg'></i> Selesaikan Penjualan
                            </button>
                            <a href="{{ route('sales.index') }}"
                                class="w-full px-4 py-1.5 bg-white border border-gray-300 text-gray-600 rounded font-bold text-xs shadow-sm hover:bg-gray-50 transition uppercase flex justify-center items-center text-center">
                                Batal & Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="fixed bottom-4 right-4 bg-red-600 text-white p-3 rounded shadow-lg max-w-sm z-50 text-xs">
            <strong class="block mb-1"><i class='bx bx-error-circle'></i> Error Validasi:</strong>
            <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    (function($) {
        // =============================================
        // DATA: Product list from PHP (encoded once)
        // =============================================
        // Data produk disiapkan oleh controller — aman untuk Blade parser
        const PRODUCTS = @json($productsJson);

        let rowCount = 0;

        // =============================================
        // Build a single product row DOM element
        // =============================================
        function buildRow(index) {
            const row = document.createElement('div');
            row.className = 'product-row grid grid-cols-12 gap-2 items-center py-1';
            row.dataset.index = index;

            // --- Product select wrapper (for Select2 attachment) ---
            const prodCol = document.createElement('div');
            prodCol.className = 'col-span-6 relative';

            // Native hidden select (carries the value for form submission)
            const nativeSel = document.createElement('select');
            nativeSel.name = `items[${index}][product_id]`;
            nativeSel.className = 'native-select-hidden product-native-select';
            nativeSel.innerHTML = '<option value="">-- Pilih --</option>';
            PRODUCTS.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.dataset.price = p.price;
                opt.dataset.stock = p.stock;
                opt.dataset.text  = p.text;
                opt.textContent   = p.text;
                nativeSel.appendChild(opt);
            });

            // Visible Select2 trigger select (NOT submitted — no name)
            const displaySel = document.createElement('select');
            displaySel.className = 'product-display-select w-full';
            displaySel.innerHTML = '<option value="">-- Cari Produk (Ketik Merk/SN) --</option>';
            PRODUCTS.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.dataset.price = p.price;
                opt.dataset.stock = p.stock;
                opt.dataset.typeCategory = p.type_category;
                opt.dataset.sn = p.sn;
                opt.textContent   = p.text;
                displaySel.appendChild(opt);
            });

            prodCol.appendChild(nativeSel);
            prodCol.appendChild(displaySel);

            // --- Qty ---
            const qtyCol = document.createElement('div');
            qtyCol.className = 'col-span-2';
            const qtyInput = document.createElement('input');
            qtyInput.type = 'number';
            qtyInput.name = `items[${index}][quantity]`;
            qtyInput.min = '1'; qtyInput.value = '1';
            qtyInput.className = 'qty-input w-full border border-gray-300 rounded px-1 py-1 text-xs text-center focus:ring-1 focus:ring-emerald-500';
            qtyCol.appendChild(qtyInput);

            // --- Subtotal ---
            const subCol = document.createElement('div');
            subCol.className = 'col-span-3';
            const subInput = document.createElement('input');
            subInput.type = 'text'; subInput.readOnly = true;
            subInput.className = 'subtotal-display w-full border border-gray-200 rounded px-2 py-1 text-xs bg-slate-50 font-semibold text-right text-slate-700';
            subCol.appendChild(subInput);

            // --- Remove button ---
            const remCol = document.createElement('div');
            remCol.className = 'col-span-1 flex justify-center';
            const remBtn = document.createElement('button');
            remBtn.type = 'button'; remBtn.className = 'remove-btn text-red-400 hover:text-red-600 p-1 rounded transition';
            remBtn.innerHTML = '<i class="bx bx-trash text-sm pointer-events-none"></i>';
            if (index === 0) remBtn.style.visibility = 'hidden'; // hide trash on first row
            remCol.appendChild(remBtn);

            row.appendChild(prodCol);
            row.appendChild(qtyCol);
            row.appendChild(subCol);
            row.appendChild(remCol);

            // --- SN Verification (for hardware) ---
            const snCol = document.createElement('div');
            snCol.className = 'col-span-12 mt-1 hidden sn-verification-container';
            snCol.innerHTML = `
                <div class="flex items-center gap-2">
                    <label class="text-[10px] font-bold text-emerald-700 uppercase whitespace-nowrap">Verifikasi SN *</label>
                    <input type="text" name="items[${index}][serial_number]" class="sn-input w-full border border-emerald-300 rounded px-2 py-1 text-[10px] focus:ring-1 focus:ring-emerald-500" placeholder="Ketik/Scan Serial Number" disabled>
                </div>
            `;
            row.appendChild(snCol);

            return { row, nativeSel, displaySel, qtyInput, subInput, remBtn, snCol };
        }

        // =============================================
        // Add a row and initialize Select2 on it
        // =============================================
        function addRow() {
            const { row, nativeSel, displaySel, qtyInput, subInput, remBtn, snCol } = buildRow(rowCount);
            document.getElementById('products-container').appendChild(row);

            // Init Select2 on the DISPLAY select (no name — only for UI)
            $(displaySel).select2({
                placeholder: 'Ketik merk / model / SN...',
                allowClear: true,
                width: '100%',
                dropdownParent: $(displaySel).parent()
            });

            // When user picks from Select2 display select → sync value to native hidden select
            $(displaySel).on('select2:select select2:unselecting', function() {
                const val = $(this).val();
                nativeSel.value = val || '';

                const opt = this.options[this.selectedIndex];
                if (opt && opt.dataset.typeCategory === 'hardware') {
                    snCol.classList.remove('hidden');
                    snCol.querySelector('input').disabled = false;
                } else {
                    snCol.classList.add('hidden');
                    snCol.querySelector('input').disabled = true;
                }

                recalcRow(row, qtyInput, subInput);
                updateTotals();
            });

            // Qty change
            qtyInput.addEventListener('input', function() {
                recalcRow(row, qtyInput, subInput);
                updateTotals();
            });

            // Remove
            remBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.product-row').length > 1) {
                    $(displaySel).select2('destroy');
                    row.remove();
                    updateTotals();
                }
            });

            rowCount++;
        }

        // =============================================
        // Recalculate a single row's subtotal
        // =============================================
        function recalcRow(row, qtyInput, subInput) {
            const nativeSel = row.querySelector('.product-native-select');
            const selOpt    = nativeSel ? nativeSel.options[nativeSel.selectedIndex] : null;
            const price     = selOpt ? (parseFloat(selOpt.dataset.price) || 0) : 0;
            const stock     = selOpt ? (parseInt(selOpt.dataset.stock)   || 0) : 0;
            let   qty       = parseInt(qtyInput.value) || 0;

            if (price > 0 && stock > 0 && qty > stock) {
                alert('⚠️ Stok tidak mencukupi! Sisa stok: ' + stock);
                qty = stock;
                qtyInput.value = stock;
            }

            const sub = price * qty;
            subInput.value = sub > 0 ? 'Rp ' + sub.toLocaleString('id-ID') : '';
            return { qty, sub, name: selOpt ? selOpt.dataset.text : '' };
        }

        // =============================================
        // Recalculate Grand Total + Summary Panel
        // =============================================
        function updateTotals() {
            let totalQty = 0, grandTotal = 0;
            const lines = [];

            document.querySelectorAll('.product-row').forEach(row => {
                const qtyInput = row.querySelector('.qty-input');
                const subInput = row.querySelector('.subtotal-display');
                const { qty, sub, name } = recalcRow(row, qtyInput, subInput);
                totalQty   += qty;
                grandTotal += sub;
                if (sub > 0 && name) {
                    const shortName = name.split('—')[0].trim();
                    lines.push(
                        `<div class="flex flex-col py-1.5 border-b border-dashed border-gray-100 gap-1">
                            <span class="truncate w-full text-gray-800 text-[11px] font-bold">${shortName}</span>
                            <div class="flex justify-between items-center w-full text-[10px]">
                                <span class="text-gray-500 font-medium">Qty: ${qty}</span>
                                <span class="font-extrabold text-emerald-600">Rp ${sub.toLocaleString('id-ID')}</span>
                            </div>
                        </div>`
                    );
                }
            });

            document.getElementById('total-qty').textContent  = totalQty;
            document.getElementById('grand-total').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
            document.getElementById('summary-items').innerHTML = lines.length
                ? lines.join('')
                : '<span class="italic text-gray-400 text-xs">Belum ada produk dipilih...</span>';
        }

        // =============================================
        // Customer Toggle
        // =============================================
        function initCustomerToggle() {
            const toggleNew    = document.getElementById('new_customer_toggle');
            const existingArea = document.getElementById('existing_customer_area');
            const newArea      = document.getElementById('new_customer_area');
            const existingSel  = document.getElementById('customer_id');
            const newNameInp   = document.getElementById('new_customer_name');

            toggleNew.addEventListener('change', function() {
                if (this.checked) {
                    existingArea.classList.add('hidden');
                    newArea.classList.remove('hidden');
                } else {
                    existingArea.classList.remove('hidden');
                    newArea.classList.add('hidden');
                }
            });

            existingSel.addEventListener('change', function() {
                const sel = this.options[this.selectedIndex];
                document.getElementById('customer_email').value = sel.getAttribute('data-email') || '';
                document.getElementById('customer_phone').value = sel.getAttribute('data-phone') || '';
            });
        }

        // =============================================
        // Form Submit Validation (JS, no browser required)
        // =============================================
        function initFormValidation() {
            document.getElementById('saleForm').addEventListener('submit', function(e) {
                const rows   = document.querySelectorAll('.product-row');
                let   valid  = true;
                const errEl  = document.getElementById('row-error');

                rows.forEach(row => {
                    const nativeSel = row.querySelector('.product-native-select');
                    if (!nativeSel || !nativeSel.value) valid = false;
                });

                if (!valid) {
                    e.preventDefault();
                    errEl.classList.remove('hidden');
                    // scroll product container into view
                    document.getElementById('products-container').scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    errEl.classList.add('hidden');
                }
            });
        }

        // =============================================
        // Bootstrap on DOM ready
        // =============================================
        $(document).ready(function() {
            initCustomerToggle();
            initFormValidation();

            // Add first row
            addRow();

            // "+ Tambah Baris" button
            document.getElementById('add-product-btn').addEventListener('click', addRow);
        });

    })(jQuery);
    </script>
</x-app-layout>
