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
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tipe Kategori (Parent) *</label>
                        <select name="parent_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                            <option value="">-- Jadikan Kategori Utama (Parent) --</option>
                            @foreach(\App\Models\Category::whereNull('parent_id')->get() as $parent)
                                @if($parent->id != $category->id)
                                    <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-2">Pilih Kategori Utama untuk membuat Sub-Kategori. Kosongkan jika ingin membuat Kategori Utama baru.</p>
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
