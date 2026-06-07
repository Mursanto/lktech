<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-natural-900 tracking-tight">
            {{ __('Tambah User Baru') }}
        </h2>
    </x-slot>

    <div class="card-natural mt-6 max-w-3xl mx-auto">
        <div class="p-8">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="space-y-6">
                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-natural-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                            class="block w-full bg-natural-50 border border-natural-200 rounded-xl text-natural-900 placeholder-natural-400 focus:border-brand-500 focus:ring-brand-500 focus:bg-white sm:text-sm transition-all p-3 font-medium shadow-sm">
                        @error('name') <span class="text-sm text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-natural-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="block w-full bg-natural-50 border border-natural-200 rounded-xl text-natural-900 placeholder-natural-400 focus:border-brand-500 focus:ring-brand-500 focus:bg-white sm:text-sm transition-all p-3 font-medium shadow-sm">
                        @error('email') <span class="text-sm text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-bold text-natural-700 mb-2">Kata Sandi</label>
                            <input type="password" name="password" id="password" required
                                class="block w-full bg-natural-50 border border-natural-200 rounded-xl text-natural-900 placeholder-natural-400 focus:border-brand-500 focus:ring-brand-500 focus:bg-white sm:text-sm transition-all p-3 font-medium shadow-sm">
                            @error('password') <span class="text-sm text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-natural-700 mb-2">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="block w-full bg-natural-50 border border-natural-200 rounded-xl text-natural-900 placeholder-natural-400 focus:border-brand-500 focus:ring-brand-500 focus:bg-white sm:text-sm transition-all p-3 font-medium shadow-sm">
                        </div>
                    </div>

                    <!-- Roles -->
                    <div>
                        <label class="block text-sm font-bold text-natural-700 mb-3">Hak Akses (Role)</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach($roles as $role)
                            <label class="relative flex cursor-pointer rounded-xl border border-natural-200 bg-natural-50 p-4 hover:bg-white hover:border-brand-300 transition-all shadow-sm">
                                <div class="flex w-full items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="text-sm">
                                            <p id="role-{{ $role->id }}-label" class="font-bold text-natural-800">
                                                {{ $role->name }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex h-5 items-center">
                                        <input id="role-{{ $role->id }}" name="roles[]" value="{{ $role->name }}" type="checkbox"
                                               class="h-5 w-5 rounded border-natural-300 bg-white text-brand-600 focus:ring-brand-500 transition-colors"
                                               {{ (is_array(old('roles')) && in_array($role->name, old('roles'))) ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('roles') <span class="text-sm text-red-500 mt-2 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Direct Permissions -->
                    <div>
                        <label class="block text-sm font-bold text-natural-700 mb-3">Akses Ekstra (Opsional)</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Access Blog -->
                            <label class="relative flex cursor-pointer rounded-xl border border-natural-200 bg-natural-50 p-4 hover:bg-white hover:border-brand-300 transition-all shadow-sm">
                                <div class="flex w-full items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center">
                                            <i class='bx bx-news text-lg'></i>
                                        </div>
                                        <div class="text-sm">
                                            <p class="font-bold text-natural-800">Blog / Artikel</p>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex h-5 items-center">
                                        <input name="permissions[]" value="access_blog" type="checkbox"
                                               class="h-5 w-5 rounded border-natural-300 bg-white text-brand-600 focus:ring-brand-500 transition-colors"
                                               {{ (is_array(old('permissions')) && in_array('access_blog', old('permissions'))) ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </label>

                            <!-- Access Settings -->
                            <label class="relative flex cursor-pointer rounded-xl border border-natural-200 bg-natural-50 p-4 hover:bg-white hover:border-brand-300 transition-all shadow-sm">
                                <div class="flex w-full items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                                            <i class='bx bx-cog text-lg'></i>
                                        </div>
                                        <div class="text-sm">
                                            <p class="font-bold text-natural-800">Pengaturan Web</p>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex h-5 items-center">
                                        <input name="permissions[]" value="access_settings" type="checkbox"
                                               class="h-5 w-5 rounded border-natural-300 bg-white text-brand-600 focus:ring-brand-500 transition-colors"
                                               {{ (is_array(old('permissions')) && in_array('access_settings', old('permissions'))) ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </label>

                            <!-- Access Rakit PC -->
                            <label class="relative flex cursor-pointer rounded-xl border border-natural-200 bg-natural-50 p-4 hover:bg-white hover:border-brand-300 transition-all shadow-sm">
                                <div class="flex w-full items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                            <i class='bx bx-desktop text-lg'></i>
                                        </div>
                                        <div class="text-sm">
                                            <p class="font-bold text-natural-800">Rakit PC</p>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex h-5 items-center">
                                        <input name="permissions[]" value="access_rakit_pc" type="checkbox"
                                               class="h-5 w-5 rounded border-natural-300 bg-white text-brand-600 focus:ring-brand-500 transition-colors"
                                               {{ (is_array(old('permissions')) && in_array('access_rakit_pc', old('permissions'))) ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 border-t border-natural-100 pt-6">
                    <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-white border border-natural-200 rounded-xl text-sm font-bold text-natural-600 hover:bg-natural-50 hover:text-natural-900 transition-colors shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-brand-600 border border-brand-700 rounded-xl text-sm font-bold text-white hover:bg-brand-700 hover:shadow-md transition-all shadow-sm">
                        Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
