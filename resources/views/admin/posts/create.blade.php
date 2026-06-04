<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('posts.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class='bx bx-arrow-back text-xl'></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tulis Artikel Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8" id="post-form">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Kolom Utama -->
                        <div class="md:col-span-2 space-y-6">
                            
                            <div>
                                <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Artikel <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                       placeholder="Contoh: Tips Memilih Laptop untuk Desain Grafis">
                                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="excerpt" class="block text-sm font-bold text-gray-700 mb-1">Cuplikan Singkat (Opsional)</label>
                                <textarea name="excerpt" id="excerpt" rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                          placeholder="Akan tampil di halaman depan sebagai pengantar singkat...">{{ old('excerpt') }}</textarea>
                                @error('excerpt') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-bold text-gray-700 mb-1">Isi Artikel <span class="text-red-500">*</span></label>
                                <!-- Quill Editor Container -->
                                <div id="editor-container" class="h-96 rounded-b-lg"></div>
                                <input type="hidden" name="content" id="content" value="{{ old('content') }}">
                                @error('content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                        </div>

                        <!-- Kolom Samping -->
                        <div class="space-y-6">
                            
                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Publikasi</h3>
                                
                                <label class="flex items-center gap-3 cursor-pointer mb-6">
                                    <div class="relative">
                                        <input type="checkbox" name="is_published" value="1" class="sr-only" {{ old('is_published', true) ? 'checked' : '' }}>
                                        <div class="block bg-gray-300 w-10 h-6 rounded-full transition-colors toggle-bg"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 font-bold toggle-label">Langsung Tayang (Publish)</span>
                                </label>

                                <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 rounded-lg shadow-sm transition-colors">
                                    Simpan Artikel
                                </button>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Foto Sampul (Thumbnail)</h3>
                                
                                <label for="thumbnail" class="relative cursor-pointer block mt-1 px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-white group overflow-hidden hover:border-brand-500 transition-colors text-center" id="thumbnail-preview-container">
                                    <input id="thumbnail" name="thumbnail" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewImage(event)">
                                    
                                    <div class="space-y-1 relative z-10 transition-opacity duration-300" id="thumbnail-upload-text">
                                        <i class='bx bx-image-add text-4xl text-gray-400 group-hover:text-brand-500 transition-colors'></i>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <span class="font-bold text-brand-600 group-hover:text-brand-500">Upload/Ganti Foto</span>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, WEBP up to 2MB</p>
                                    </div>

                                    <img id="thumbnail-preview" src="#" alt="Preview" class="hidden absolute inset-0 w-full h-full object-cover group-hover:opacity-40 transition-opacity duration-300">
                                    
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-300 pointer-events-none" id="thumbnail-hover-overlay">
                                        <span class="bg-black/70 text-white px-3 py-1.5 rounded-lg text-sm font-bold flex items-center gap-1 shadow-lg"><i class='bx bx-edit'></i> Ganti Foto</span>
                                    </div>
                                </label>
                                @error('thumbnail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Quill CSS & JS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    
    <style>
        input:checked ~ .toggle-bg { background-color: #2563eb; }
        input:checked ~ .dot { transform: translateX(100%); }
        .ql-toolbar.ql-snow { border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; border-color: #d1d5db; font-family: 'Inter', sans-serif; }
        .ql-container.ql-snow { border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; border-color: #d1d5db; font-family: 'Inter', sans-serif; font-size: 1rem; }
    </style>

    <script>
        // Initialize Quill editor
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image', 'video', 'blockquote', 'code-block'],
                    ['clean']
                ]
            },
            placeholder: 'Mulai menulis artikel Anda di sini...'
        });

        // Set initial content if exists (from old input)
        const oldContent = document.querySelector('#content').value;
        if (oldContent) {
            quill.root.innerHTML = oldContent;
        }

        // On form submit, populate hidden input with HTML content
        document.getElementById('post-form').onsubmit = function() {
            var contentInput = document.querySelector('#content');
            contentInput.value = quill.root.innerHTML;
        };

        // Toggle Label Logic
        const checkbox = document.querySelector('input[name="is_published"]');
        const toggleLabel = document.querySelector('.toggle-label');
        
        checkbox.addEventListener('change', function() {
            if(this.checked) {
                toggleLabel.textContent = 'Langsung Tayang (Publish)';
                toggleLabel.classList.add('text-gray-700');
                toggleLabel.classList.remove('text-gray-400');
            } else {
                toggleLabel.textContent = 'Simpan sebagai Draft';
                toggleLabel.classList.remove('text-gray-700');
                toggleLabel.classList.add('text-gray-400');
            }
        });

        // Image Preview
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('thumbnail-preview');
                var uploadText = document.getElementById('thumbnail-upload-text');
                var overlay = document.getElementById('thumbnail-hover-overlay');
                
                output.src = reader.result;
                output.classList.remove('hidden');
                uploadText.classList.add('opacity-0'); 
                
                // Show hover overlay functionality after image is uploaded
                document.getElementById('thumbnail-preview-container').addEventListener('mouseenter', function() {
                    overlay.classList.remove('opacity-0');
                });
                document.getElementById('thumbnail-preview-container').addEventListener('mouseleave', function() {
                    overlay.classList.add('opacity-0');
                });
            }
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>
