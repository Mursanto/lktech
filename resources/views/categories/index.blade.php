<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Kategori
            </h2>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('categories.index') }}" class="flex items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kategori..." class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-brand-500 w-48">
                    <select name="filter" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-brand-500" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <option value="main" {{ request('filter') == 'main' ? 'selected' : '' }}>Hanya Kategori Utama</option>
                        @if(isset($mainCategories))
                            @foreach($mainCategories as $main)
                                <option value="{{ $main->id }}" {{ request('filter') == $main->id ? 'selected' : '' }}>Filter: {{ $main->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <button type="submit" class="hidden"></button>
                </form>
                <a href="{{ route('categories.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-lg font-bold text-sm shadow flex items-center gap-2">
                    <i class='bx bx-plus'></i> Tambah Kategori
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 h-[calc(100vh-65px)] overflow-hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full flex flex-col">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex-grow flex flex-col overflow-hidden">
                <div class="flex-grow overflow-y-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-50 text-gray-600 font-semibold text-[11px] uppercase tracking-wider sticky top-0 z-10">
                            <tr>
                                <th class="px-4 py-3 border-b">ID</th>
                                <th class="px-4 py-3 border-b">Nama Kategori</th>
                                <th class="px-4 py-3 border-b">Tipe Kategori (Induk)</th>
                                <th class="px-4 py-3 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500">#{{ $category->id }}</td>
                                <td class="px-4 py-3 font-bold text-gray-800">{{ $category->name }}</td>
                                <td class="px-4 py-3">
                                    @if($category->parent_id)
                                        <span class="px-2 py-1 bg-brand-50 text-brand-700 rounded text-[10px] font-bold">{{ $category->parent->name }}</span>
                                    @else
                                        <span class="px-2 py-1 bg-fuchsia-50 text-fuchsia-700 rounded text-[10px] font-bold uppercase">Kategori Utama</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800 transition-colors p-1 bg-blue-50 rounded" title="Edit">
                                            <i class='bx bx-edit-alt'></i>
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors p-1 bg-red-50 rounded" title="Hapus">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
