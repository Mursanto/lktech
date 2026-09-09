<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-natural-900 tracking-tight">
            {{ __('Edit User') }}: <span class="text-brand-600">{{ $user->name }}</span>
        </h2>
    </x-slot>

    <div class="card-natural mt-6 max-w-3xl mx-auto">
        <div class="p-8">
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-natural-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="block w-full bg-natural-50 border border-natural-200 rounded-xl text-natural-900 placeholder-natural-400 focus:border-brand-500 focus:ring-brand-500 focus:bg-white sm:text-sm transition-all p-3 font-medium shadow-sm">
                        @error('name') <span class="text-sm text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-natural-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="block w-full bg-natural-50 border border-natural-200 rounded-xl text-natural-900 placeholder-natural-400 focus:border-brand-500 focus:ring-brand-500 focus:bg-white sm:text-sm transition-all p-3 font-medium shadow-sm">
                        @error('email') <span class="text-sm text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl mt-4 shadow-sm">
                        <div class="flex gap-3">
                            <i class='bx bx-info-circle text-2xl text-amber-500 shrink-0'></i>
                            <p class="text-sm text-amber-800 font-medium pt-0.5">Kosongkan kolom sandi di bawah ini jika Anda tidak ingin mengubah sandi pengguna.</p>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-bold text-natural-700 mb-2">Kata Sandi Baru</label>
                            <input type="password" name="password" id="password"
                                class="block w-full bg-natural-50 border border-natural-200 rounded-xl text-natural-900 placeholder-natural-400 focus:border-brand-500 focus:ring-brand-500 focus:bg-white sm:text-sm transition-all p-3 font-medium shadow-sm">
                            @error('password') <span class="text-sm text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-natural-700 mb-2">Konfirmasi Sandi Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="block w-full bg-natural-50 border border-natural-200 rounded-xl text-natural-900 placeholder-natural-400 focus:border-brand-500 focus:ring-brand-500 focus:bg-white sm:text-sm transition-all p-3 font-medium shadow-sm">
                        </div>
                    </div>

                    <!-- Roles -->
                    <div>
                        <label class="block text-sm font-bold text-natural-700 mb-3">Hak Akses (Role)</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            @foreach($roles as $role)
                            <label class="relative flex cursor-pointer rounded-lg border border-natural-200 bg-natural-50 px-3 py-2.5 hover:bg-white hover:border-brand-300 transition-all shadow-sm items-center gap-3">
                                <input id="role-{{ $role->id }}" name="roles[]" value="{{ $role->name }}" type="checkbox"
                                       class="h-4 w-4 rounded border-natural-300 bg-white text-brand-600 focus:ring-brand-500 transition-colors cursor-pointer"
                                       {{ (is_array(old('roles')) && in_array($role->name, old('roles'))) || in_array($role->name, $userRoles) ? 'checked' : '' }}>
                                <span id="role-{{ $role->id }}-label" class="font-bold text-natural-800 text-sm cursor-pointer select-none">
                                    {{ $role->name }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                        @error('roles') <span class="text-sm text-red-500 mt-2 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Direct Permissions -->
                    <div>
                        <label class="block text-sm font-bold text-natural-700 mb-3">Akses Ekstra (Opsional)</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <!-- Access Blog -->
                            <label class="relative flex cursor-pointer rounded-lg border border-natural-200 bg-natural-50 px-3 py-2.5 hover:bg-white hover:border-brand-300 transition-all shadow-sm items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-6 h-6 rounded-md bg-pink-50 text-pink-600 flex items-center justify-center">
                                        <i class='bx bx-news text-base'></i>
                                    </div>
                                    <span class="font-bold text-natural-800 text-sm select-none">Blog / Artikel</span>
                                </div>
                                <input name="permissions[]" value="access_blog" type="checkbox"
                                       class="h-4 w-4 rounded border-natural-300 bg-white text-brand-600 focus:ring-brand-500 transition-colors cursor-pointer"
                                       {{ (is_array(old('permissions')) && in_array('access_blog', old('permissions'))) || in_array('access_blog', $userPermissions) ? 'checked' : '' }}>
                            </label>

                            <!-- Access Settings -->
                            <label class="relative flex cursor-pointer rounded-lg border border-natural-200 bg-natural-50 px-3 py-2.5 hover:bg-white hover:border-brand-300 transition-all shadow-sm items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-6 h-6 rounded-md bg-purple-50 text-purple-600 flex items-center justify-center">
                                        <i class='bx bx-cog text-base'></i>
                                    </div>
                                    <span class="font-bold text-natural-800 text-sm select-none">Pengaturan Web</span>
                                </div>
                                <input name="permissions[]" value="access_settings" type="checkbox"
                                       class="h-4 w-4 rounded border-natural-300 bg-white text-brand-600 focus:ring-brand-500 transition-colors cursor-pointer"
                                       {{ (is_array(old('permissions')) && in_array('access_settings', old('permissions'))) || in_array('access_settings', $userPermissions) ? 'checked' : '' }}>
                            </label>

                            <!-- Access Rakit PC -->
                            <label class="relative flex cursor-pointer rounded-lg border border-natural-200 bg-natural-50 px-3 py-2.5 hover:bg-white hover:border-brand-300 transition-all shadow-sm items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                        <i class='bx bx-desktop text-base'></i>
                                    </div>
                                    <span class="font-bold text-natural-800 text-sm select-none">Rakit PC</span>
                                </div>
                                <input name="permissions[]" value="access_rakit_pc" type="checkbox"
                                       class="h-4 w-4 rounded border-natural-300 bg-white text-brand-600 focus:ring-brand-500 transition-colors cursor-pointer"
                                       {{ (is_array(old('permissions')) && in_array('access_rakit_pc', old('permissions'))) || in_array('access_rakit_pc', $userPermissions) ? 'checked' : '' }}>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 border-t border-natural-100 pt-6">
                    <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-white border border-natural-200 rounded-xl text-sm font-bold text-natural-600 hover:bg-natural-50 hover:text-natural-900 transition-colors shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-brand-600 border border-brand-700 rounded-xl text-sm font-bold text-white hover:bg-brand-700 hover:shadow-md transition-all shadow-sm">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
