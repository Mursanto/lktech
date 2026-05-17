<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kategori
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <form action="{{ route('categories.update', $category) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori *</label>
                        <input type="text" name="name" value="{{ $category->name }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tipe Kategori *</label>
                        <select name="type_category" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                            <option value="hardware" {{ $category->type_category == 'hardware' ? 'selected' : '' }}>Hardware (Laptop, PC, dll)</option>
                            <option value="peripheral" {{ $category->type_category == 'peripheral' ? 'selected' : '' }}>Peripheral (Mouse, Tas, RAM, SSD, dll)</option>
                            <option value="software" {{ $category->type_category == 'software' ? 'selected' : '' }}>Software (Lisensi Windows, Office, dll)</option>
                            <option value="service" {{ $category->type_category == 'service' ? 'selected' : '' }}>Service (Instalasi, Perbaikan, dll)</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-2">Tipe kategori menentukan tampilan form pada saat menambah produk baru.</p>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-brand-600 text-white rounded-lg text-sm font-bold shadow hover:bg-brand-700">Perbarui Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
