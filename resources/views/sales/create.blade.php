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

    <style>
        /* ============================================================
           Custom Fast-Search Product Dropdown
        ============================================================ */
        .prod-search-wrap { position: relative; }
        .prod-search-input {
            width: 100%; border: 1.5px solid #d1d5db; border-radius: 6px;
            padding: 5px 28px 5px 8px; font-size: 11px; color: #374151;
            background: #fff; outline: none; transition: border-color .15s, box-shadow .15s;
            cursor: text;
        }
        .prod-search-input:focus { border-color: #10b981; box-shadow: 0 0 0 2px rgba(16,185,129,.15); }
        .prod-search-input.has-value { border-color: #10b981; background: #f0fdf4; font-weight: 600; }
        .prod-clear-btn {
            position: absolute; right: 6px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: #9ca3af;
            font-size: 14px; line-height: 1; padding: 0; display: none;
        }
        .prod-clear-btn:hover { color: #ef4444; }
        .prod-dropdown {
            position: absolute; top: calc(100% + 2px); left: 0; right: 0;
            background: #fff; border: 1.5px solid #10b981; border-radius: 6px;
            box-shadow: 0 8px 24px rgba(0,0,0,.12); z-index: 9999;
            max-height: 240px; overflow-y: auto; display: none;
        }
        .prod-dropdown.open { display: block; }
        .prod-dropdown-search {
            position: sticky; top: 0; background: #fff; padding: 6px 8px;
            border-bottom: 1px solid #f1f5f9;
        }
        .prod-dropdown-search input {
            width: 100%; border: 1px solid #d1d5db; border-radius: 4px;
            padding: 4px 8px; font-size: 11px; outline: none;
            background: #f9fafb;
        }
        .prod-dropdown-search input:focus { border-color: #10b981; background: #fff; }
        .prod-option {
            padding: 6px 10px; font-size: 11px; cursor: pointer;
            border-bottom: 1px solid #f9fafb; color: #374151;
            transition: background .1s;
        }
        .prod-option:last-child { border-bottom: none; }
        .prod-option:hover, .prod-option.active { background: #ecfdf5; color: #065f46; }
        .prod-option .prod-highlight { color: #059669; font-weight: 700; }
        .prod-option .prod-badge {
            display: inline-block; font-size: 9px; padding: 1px 5px;
            border-radius: 999px; margin-left: 4px; font-weight: 700;
        }
        .prod-badge-stock { background: #dcfce7; color: #166534; }
        .prod-badge-lowstock { background: #fef9c3; color: #854d0e; }
        .prod-badge-nostock { background: #fee2e2; color: #991b1b; }
        .prod-empty { padding: 12px; text-align: center; color: #9ca3af; font-size: 11px; }
        .prod-category-header {
            padding: 4px 10px; font-size: 9px; font-weight: 800; letter-spacing: .08em;
            text-transform: uppercase; color: #6b7280; background: #f8fafc;
            border-bottom: 1px solid #f1f5f9;
        }
        /* Date badge */
        .date-badge {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 9px; font-weight: 800; letter-spacing: .06em;
            text-transform: uppercase; padding: 2px 7px; border-radius: 999px;
        }
        .date-badge-today { background: #dcfce7; color: #166534; }
        .date-badge-backdate { background: #fef3c7; color: #92400e; }
        /* Scrollbar hide */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
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

                        <!-- 2. Tanggal Transaksi -->
                        <div class="bg-gradient-to-br from-amber-50 to-white rounded-lg p-3 border border-amber-200">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-xs font-bold text-gray-800 uppercase flex items-center gap-1">
                                    <i class='bx bx-calendar text-amber-500'></i> Tanggal Transaksi
                                </h4>
                                <span id="date-badge" class="date-badge date-badge-today">
                                    <i class='bx bx-check-circle'></i> Hari ini
                                </span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex-1">
                                    <input type="datetime-local" name="transaction_date" id="transaction_date"
                                        class="w-full border border-amber-300 rounded px-2 py-1.5 text-xs bg-white focus:ring-1 focus:ring-amber-400 focus:border-amber-400"
                                        value="{{ now()->format('Y-m-d\TH:i') }}"
                                        max="{{ now()->format('Y-m-d\TH:i') }}">
                                </div>
                                <button type="button" id="reset-date-btn"
                                    class="flex-shrink-0 px-3 py-1.5 bg-amber-100 text-amber-700 border border-amber-300 rounded text-[10px] font-bold uppercase hover:bg-amber-200 transition hidden">
                                    <i class='bx bx-reset'></i> Hari ini
                                </button>
                            </div>
                            <p class="text-[9px] text-amber-600 mt-1.5 flex items-center gap-1">
                                <i class='bx bx-info-circle'></i>
                                Ubah tanggal jika ingin melakukan input transaksi backdate (tanggal yang sudah lewat).
                            </p>
                        </div>

                        <!-- 3. Pilih Produk -->
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

    <script>
    (function() {
        // =============================================
        // DATA: Product list from PHP
        // =============================================
        const PRODUCTS = @json($productsJson);

        let rowCount = 0;

        // =============================================
        // Helper: escape HTML
        // =============================================
        function escHtml(str) {
            return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        }
        function regEsc(str) {
            return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }
        function highlight(text, query) {
            if (!query) return escHtml(text);
            const re = new RegExp('(' + regEsc(query) + ')', 'gi');
            return escHtml(text).replace(re, '<span class="prod-highlight">$1</span>');
        }

        // =============================================
        // Multi-word search filter
        // =============================================
        function filterProducts(query) {
            if (!query || !query.trim()) return PRODUCTS;
            const terms = query.trim().toLowerCase().split(/\s+/);
            return PRODUCTS.filter(p => {
                const hay = p.text.toLowerCase();
                return terms.every(t => hay.includes(t));
            });
        }

        // =============================================
        // Build custom fast-search dropdown
        // =============================================
        function buildCustomSelect(index, nativeSel, onSelect) {
            const wrap = document.createElement('div');
            wrap.className = 'prod-search-wrap';

            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'prod-search-input';
            input.placeholder = 'Ketik merk / model / SN...';
            input.autocomplete = 'off';

            const clearBtn = document.createElement('button');
            clearBtn.type = 'button';
            clearBtn.className = 'prod-clear-btn';
            clearBtn.innerHTML = '<i class="bx bx-x"></i>';
            clearBtn.title = 'Hapus pilihan';

            const dropdown = document.createElement('div');
            dropdown.className = 'prod-dropdown';

            const ddSearchWrap = document.createElement('div');
            ddSearchWrap.className = 'prod-dropdown-search';
            const ddSearch = document.createElement('input');
            ddSearch.type = 'text';
            ddSearch.placeholder = '\uD83D\uDD0D Cari produk...';
            ddSearch.autocomplete = 'off';
            ddSearchWrap.appendChild(ddSearch);
            dropdown.appendChild(ddSearchWrap);

            const listWrap = document.createElement('div');
            dropdown.appendChild(listWrap);

            wrap.appendChild(input);
            wrap.appendChild(clearBtn);
            wrap.appendChild(dropdown);

            function renderList(query) {
                listWrap.innerHTML = '';
                const results = filterProducts(query);
                if (results.length === 0) {
                    listWrap.innerHTML = '<div class="prod-empty">Produk tidak ditemukan</div>';
                    return;
                }
                const groups = {};
                results.forEach(p => {
                    const cat = p.category || 'Lainnya';
                    if (!groups[cat]) groups[cat] = [];
                    groups[cat].push(p);
                });
                Object.keys(groups).forEach(cat => {
                    const hdr = document.createElement('div');
                    hdr.className = 'prod-category-header';
                    hdr.textContent = cat;
                    listWrap.appendChild(hdr);
                    groups[cat].forEach(p => {
                        const opt = document.createElement('div');
                        opt.className = 'prod-option';
                        opt.dataset.id = p.id;
                        let stockBadge = '';
                        if (p.stock > 5) {
                            stockBadge = '<span class="prod-badge prod-badge-stock">Stok: ' + p.stock + '</span>';
                        } else if (p.stock > 0) {
                            stockBadge = '<span class="prod-badge prod-badge-lowstock">Stok: ' + p.stock + '</span>';
                        } else {
                            stockBadge = '<span class="prod-badge prod-badge-nostock">Habis</span>';
                        }
                        const displayText = p.text.replace(/\(Stok: \d+\)/, '').trim();
                        opt.innerHTML = highlight(displayText, query) + stockBadge;
                        opt.addEventListener('mousedown', function(e) {
                            e.preventDefault();
                            selectProduct(p);
                        });
                        listWrap.appendChild(opt);
                    });
                });
            }

            function openDropdown() {
                renderList(ddSearch.value || '');
                dropdown.classList.add('open');
                ddSearch.value = '';
                ddSearch.focus();
            }
            function closeDropdown() {
                dropdown.classList.remove('open');
            }
            function selectProduct(p) {
                input.value = p.text.replace(/\(Stok: \d+\)/, '').trim();
                input.classList.add('has-value');
                clearBtn.style.display = 'block';
                nativeSel.value = p.id;
                closeDropdown();
                onSelect(p);
            }
            function clearSelection() {
                input.value = '';
                input.classList.remove('has-value');
                clearBtn.style.display = 'none';
                nativeSel.value = '';
                onSelect(null);
            }

            input.addEventListener('click', openDropdown);
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeDropdown();
                else if (!dropdown.classList.contains('open')) openDropdown();
            });
            ddSearch.addEventListener('input', function() { renderList(this.value); });
            ddSearch.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') { closeDropdown(); }
                if (e.key === 'Enter') {
                    const first = listWrap.querySelector('.prod-option');
                    if (first) first.dispatchEvent(new MouseEvent('mousedown'));
                }
            });
            clearBtn.addEventListener('click', clearSelection);
            document.addEventListener('mousedown', function(e) {
                if (!wrap.contains(e.target)) closeDropdown();
            }, true);

            renderList('');
            return wrap;
        }

        // =============================================
        // Build a single product row DOM element
        // =============================================
        function buildRow(index) {
            const row = document.createElement('div');
            row.className = 'product-row grid grid-cols-12 gap-2 items-center py-1';
            row.dataset.index = index;

            const prodCol = document.createElement('div');
            prodCol.className = 'col-span-6 relative';

            // Native hidden select (carries value for form submission)
            const nativeSel = document.createElement('select');
            nativeSel.name = 'items[' + index + '][product_id]';
            nativeSel.className = 'product-native-select';
            nativeSel.style.cssText = 'position:absolute;opacity:0;pointer-events:none;width:1px;height:1px;';
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

            const customSelect = buildCustomSelect(index, nativeSel, function(product) {
                nativeSel.value = product ? product.id : '';
                recalcRow(row, qtyInput, subInput);
                updateTotals();
            });

            prodCol.appendChild(nativeSel);
            prodCol.appendChild(customSelect);

            // Qty
            const qtyCol = document.createElement('div');
            qtyCol.className = 'col-span-2';
            const qtyInput = document.createElement('input');
            qtyInput.type = 'number';
            qtyInput.name = 'items[' + index + '][quantity]';
            qtyInput.min = '1'; qtyInput.value = '1';
            qtyInput.className = 'qty-input w-full border border-gray-300 rounded px-1 py-1 text-xs text-center focus:ring-1 focus:ring-emerald-500';
            qtyCol.appendChild(qtyInput);

            // Subtotal
            const subCol = document.createElement('div');
            subCol.className = 'col-span-3';
            const subInput = document.createElement('input');
            subInput.type = 'text'; subInput.readOnly = true;
            subInput.className = 'subtotal-display w-full border border-gray-200 rounded px-2 py-1 text-xs bg-slate-50 font-semibold text-right text-slate-700';
            subCol.appendChild(subInput);

            // Remove btn
            const remCol = document.createElement('div');
            remCol.className = 'col-span-1 flex justify-center';
            const remBtn = document.createElement('button');
            remBtn.type = 'button'; remBtn.className = 'remove-btn text-red-400 hover:text-red-600 p-1 rounded transition';
            remBtn.innerHTML = '<i class="bx bx-trash text-sm pointer-events-none"></i>';
            if (index === 0) remBtn.style.visibility = 'hidden';
            remCol.appendChild(remBtn);

            row.appendChild(prodCol);
            row.appendChild(qtyCol);
            row.appendChild(subCol);
            row.appendChild(remCol);

            // Manual SN
            const manualSnCol = document.createElement('div');
            manualSnCol.className = 'col-span-12 mt-1';
            manualSnCol.innerHTML =
                '<div class="flex items-center gap-2">' +
                    '<label class="text-[10px] font-bold text-slate-700 uppercase whitespace-nowrap w-24 text-right">SN / License Key</label>' +
                    '<input type="text" name="items[' + index + '][manual_sn]" class="w-full border border-slate-300 rounded px-2 py-1 text-[10px] focus:ring-1 focus:ring-emerald-500" placeholder="Input SN fisik / Kode Lisensi Manual (Opsional)">' +
                '</div>';
            row.appendChild(manualSnCol);

            return { row, nativeSel, qtyInput, subInput, remBtn };
        }

        // =============================================
        // Add a row
        // =============================================
        function addRow() {
            const { row, nativeSel, qtyInput, subInput, remBtn } = buildRow(rowCount);
            document.getElementById('products-container').appendChild(row);

            qtyInput.addEventListener('input', function() {
                recalcRow(row, qtyInput, subInput);
                updateTotals();
            });
            remBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.product-row').length > 1) {
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
                    const shortName = name.split('\u2014')[0].trim();
                    lines.push(
                        '<div class="flex flex-col py-1.5 border-b border-dashed border-gray-100 gap-1">' +
                            '<span class="truncate w-full text-gray-800 text-[11px] font-bold">' + escHtml(shortName) + '</span>' +
                            '<div class="flex justify-between items-center w-full text-[10px]">' +
                                '<span class="text-gray-500 font-medium">Qty: ' + qty + '</span>' +
                                '<span class="font-extrabold text-emerald-600">Rp ' + sub.toLocaleString('id-ID') + '</span>' +
                            '</div>' +
                        '</div>'
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
        // Date / Backdate logic
        // =============================================
        function initDateField() {
            const dateInput = document.getElementById('transaction_date');
            const dateBadge = document.getElementById('date-badge');
            const resetBtn  = document.getElementById('reset-date-btn');

            function todayStr() {
                const now = new Date();
                const pad = n => String(n).padStart(2,'0');
                return now.getFullYear()+'-'+pad(now.getMonth()+1)+'-'+pad(now.getDate())+'T'+pad(now.getHours())+':'+pad(now.getMinutes());
            }
            function checkDate() {
                const chosen = new Date(dateInput.value);
                const diffMin = (new Date() - chosen) / 60000;
                if (diffMin > 5) {
                    dateBadge.className = 'date-badge date-badge-backdate';
                    dateBadge.innerHTML = '<i class="bx bx-time-five"></i> Backdate';
                    resetBtn.classList.remove('hidden');
                } else {
                    dateBadge.className = 'date-badge date-badge-today';
                    dateBadge.innerHTML = '<i class="bx bx-check-circle"></i> Hari ini';
                    resetBtn.classList.add('hidden');
                }
            }
            dateInput.addEventListener('change', checkDate);
            resetBtn.addEventListener('click', function() {
                dateInput.value = todayStr();
                checkDate();
            });
            setInterval(function() { dateInput.max = todayStr(); }, 60000);
            checkDate();
        }

        // =============================================
        // Form Submit Validation
        // =============================================
        function initFormValidation() {
            document.getElementById('saleForm').addEventListener('submit', function(e) {
                const rows  = document.querySelectorAll('.product-row');
                let   valid = true;
                const errEl = document.getElementById('row-error');
                rows.forEach(row => {
                    const ns = row.querySelector('.product-native-select');
                    if (!ns || !ns.value) valid = false;
                });
                if (!valid) {
                    e.preventDefault();
                    errEl.classList.remove('hidden');
                    document.getElementById('products-container').scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    errEl.classList.add('hidden');
                }
            });
        }

        // =============================================
        // Bootstrap on DOM ready
        // =============================================
        document.addEventListener('DOMContentLoaded', function() {
            initCustomerToggle();
            initFormValidation();
            initDateField();
            addRow();
            document.getElementById('add-product-btn').addEventListener('click', addRow);
        });

    })();
    </script>
</x-app-layout>
