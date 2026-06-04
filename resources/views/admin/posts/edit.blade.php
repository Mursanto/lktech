<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('posts.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class='bx bx-arrow-back text-xl'></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Artikel
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8" id="post-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Kolom Utama -->
                        <div class="md:col-span-2 space-y-6">
                            
                            <div>
                                <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Artikel <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="excerpt" class="block text-sm font-bold text-gray-700 mb-1">Cuplikan Singkat (Opsional)</label>
                                <textarea name="excerpt" id="excerpt" rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500">{{ old('excerpt', $post->excerpt) }}</textarea>
                                @error('excerpt') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-bold text-gray-700 mb-1">Isi Artikel <span class="text-red-500">*</span></label>
                                <!-- Quill Editor Container -->
                                <div id="editor-container" class="h-96 rounded-b-lg"></div>
                                <input type="hidden" name="content" id="content" value="{{ old('content', $post->content) }}">
                                @error('content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                        </div>

                        <!-- Kolom Samping -->
                        <div class="space-y-6">
                            
                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Publikasi</h3>
                                
                                <label class="flex items-center gap-3 cursor-pointer mb-6">
                                    <div class="relative">
                                        <input type="checkbox" name="is_published" value="1" class="sr-only" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                                        <div class="block bg-gray-300 w-10 h-6 rounded-full transition-colors toggle-bg"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform"></div>
                                    </div>
                                    <span class="text-sm font-bold {{ old('is_published', $post->is_published) ? 'text-gray-700' : 'text-gray-400' }} toggle-label">
                                        {{ old('is_published', $post->is_published) ? 'Langsung Tayang (Publish)' : 'Simpan sebagai Draft' }}
                                    </span>
                                </label>

                                <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 rounded-lg shadow-sm transition-colors">
                                    Perbarui Artikel
                                </button>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Foto Sampul (Thumbnail)</h3>
                                
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-white relative group overflow-hidden" id="thumbnail-preview-container">
                                    <div class="space-y-1 text-center {{ $post->thumbnail ? 'opacity-0' : '' }}" id="thumbnail-upload-text">
                                        <i class='bx bx-image-add text-4xl text-gray-400'></i>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="thumbnail" class="relative cursor-pointer bg-white rounded-md font-medium text-brand-600 hover:text-brand-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-500">
                                                <span>Upload/Ganti Foto</span>
                                                <input id="thumbnail" name="thumbnail" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewImage(event)">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, WEBP up to 2MB</p>
                                    </div>
                                    <img id="thumbnail-preview" src="{{ $post->thumbnail ? Storage::url($post->thumbnail) : '#' }}" alt="Preview" class="{{ $post->thumbnail ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover">
                                </div>
                                <p class="text-xs text-gray-500 mt-2">*Biarkan kosong jika tidak ingin mengubah foto sampul.</p>
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
                    ['link', 'blockquote', 'code-block'],
                    ['clean']
                ]
            },
            placeholder: 'Mulai menulis artikel Anda di sini...'
        });

        // Set initial content if exists (from old input or database)
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
                
                output.src = reader.result;
                output.classList.remove('hidden');
                uploadText.classList.add('opacity-0'); // Hide text but keep clickable area
            }
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>
