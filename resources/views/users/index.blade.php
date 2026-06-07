<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-xl font-bold text-natural-900 tracking-tight leading-none">Manajemen User</h2>
                <p class="text-natural-500 text-[10px] mt-0.5">Kelola data pengguna, hak akses, dan kredensial sistem.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('users.create') }}" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 rounded-xl text-white text-xs font-bold hover:bg-indigo-700 transition-all shadow-md">
                    <i class='bx bx-user-plus text-lg'></i>
                    Tambah User
                </a>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col h-full space-y-4">
        <div class="bg-white rounded-3xl shadow-sm border border-natural-100/50 overflow-hidden flex-grow flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-natural-50/50 border-b border-natural-100">
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider">Identitas User</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider">Role Utama</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider">Akses Modul</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider text-center">Terdaftar</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50">
                        @forelse ($users as $user)
                        <tr class="hover:bg-natural-50/30 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-[12px] font-bold text-natural-900 leading-tight">{{ $user->name }}</div>
                                        <div class="text-[9px] font-medium text-natural-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[9px] font-bold border
                                            @if($role->name === 'Admin') bg-rose-50 border-rose-100 text-rose-600
                                            @elseif($role->name === 'Staff') bg-emerald-50 border-emerald-100 text-emerald-600
                                            @elseif($role->name === 'Teknisi') bg-amber-50 border-amber-100 text-amber-600
                                            @else bg-natural-100 border-natural-100 text-natural-600
                                            @endif uppercase tracking-wider">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1">
                                    @php
                                        $hasInventory = $user->hasRole('Admin') || $user->hasRole('Staff') || $user->hasRole('Teknisi');
                                        $hasSales = $user->hasRole('Admin') || $user->hasRole('Staff');
                                        $hasService = $user->hasRole('Admin') || $user->hasRole('Teknisi') || $user->hasRole('Staff') || $user->hasRole('Kasir') || $user->hasRole('Sales');
                                        $hasRental = $user->hasRole('Admin') || $user->hasRole('Staff') || $user->hasRole('Kasir') || $user->hasRole('Sales');
                                        $hasBlog = $user->hasPermissionTo('access_blog') || $user->hasRole('Admin');
                                        $hasSettings = $user->hasPermissionTo('access_settings') || $user->hasRole('Admin');
                                        $hasRakitPc = $user->hasPermissionTo('access_rakit_pc') || $user->hasRole('Admin');
                                    @endphp
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        <div class="w-6 h-6 rounded flex items-center justify-center {{ $hasInventory ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-400' }}" title="Inventaris">
                                            <i class='bx bx-box text-xs'></i>
                                        </div>
                                        <div class="w-6 h-6 rounded flex items-center justify-center {{ $hasSales ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-400' }}" title="Penjualan">
                                            <i class='bx bx-cart text-xs'></i>
                                        </div>
                                        <div class="w-6 h-6 rounded flex items-center justify-center {{ $hasService ? 'bg-amber-100 text-amber-600' : 'bg-gray-100 text-gray-400' }}" title="Servis">
                                            <i class='bx bx-wrench text-xs'></i>
                                        </div>
                                        <div class="w-6 h-6 rounded flex items-center justify-center {{ $hasRental ? 'bg-cyan-100 text-cyan-600' : 'bg-gray-100 text-gray-400' }}" title="Sewa Laptop">
                                            <i class='bx bx-laptop text-xs'></i>
                                        </div>
                                        <div class="w-6 h-6 rounded flex items-center justify-center {{ $hasRakitPc ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-400' }}" title="Rakit PC">
                                            <i class='bx bx-desktop text-xs'></i>
                                        </div>
                                        <div class="w-6 h-6 rounded flex items-center justify-center {{ $hasBlog ? 'bg-pink-100 text-pink-600' : 'bg-gray-100 text-gray-400' }}" title="Blog / Artikel">
                                            <i class='bx bx-news text-xs'></i>
                                        </div>
                                        <div class="w-6 h-6 rounded flex items-center justify-center {{ $hasSettings ? 'bg-fuchsia-100 text-fuchsia-600' : 'bg-gray-100 text-gray-400' }}" title="Pengaturan Web">
                                            <i class='bx bx-cog text-xs'></i>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <p class="text-[10px] font-bold text-natural-800">{{ $user->created_at->format('d M Y') }}</p>
                                <p class="text-[8px] text-natural-400 font-medium tracking-tight uppercase">Reg: #{{ $user->id }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex justify-end gap-1">
                                    <a href="{{ route('users.edit', $user->id) }}" class="p-2 text-natural-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                        <i class='bx bx-edit-alt text-lg'></i>
                                    </a>
                                    
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-natural-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                            <i class='bx bx-trash text-lg'></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-natural-400 italic">Belum ada user lainnya.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-auto px-6 py-4 bg-natural-50/30 border-t border-natural-100">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
