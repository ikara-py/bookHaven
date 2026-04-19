@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-12">
        <a href="{{ route('seller.books.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-(--color-muted) hover:text-(--color-primary) mb-8 transition-colors group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            Back to Collection
        </a>
        <h1 class="text-4xl font-serif mb-4 leading-tight">Edit <span class="text-(--color-primary)">Listing</span></h1>
        <p class="text-(--color-muted) font-medium">Update titled details, pricing, or stock for your book.</p>
    </div>

    <form action="{{ route('seller.books.update', $book) }}" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf
        @method('PATCH')

        <div class="bg-(--color-surface) p-8 rounded-3xl border border-(--color-border) shadow-sm space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="title" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) ml-1">Book Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required 
                        class="w-full bg-(--color-bg) border border-(--color-border) rounded-2xl px-5 py-4 focus:outline-none focus:border-(--color-primary) transition-colors placeholder:text-(--color-accent)">
                    @error('title') <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="type" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) ml-1">Format Type</label>
                    <select name="type" id="type" required 
                        class="w-full bg-(--color-bg) border border-(--color-border) rounded-2xl px-5 py-4 focus:outline-none focus:border-(--color-primary) transition-colors appearance-none cursor-pointer">
                        <option value="physical" {{ old('type', $book->type) == 'physical' ? 'selected' : '' }}>Physical Book</option>
                        <option value="digital" {{ old('type', $book->type) == 'digital' ? 'selected' : '' }}>E-Book (Digital)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2" id="author_container">
                    <div class="flex items-center justify-between ml-1">
                        <label for="author_id" class="block text-xs font-black uppercase tracking-widest text-(--color-muted)">Author</label>
                        <button type="button" onclick="toggleNewAuthor(true)" id="btn_new_author" class="text-[10px] font-black uppercase tracking-widest text-(--color-primary) hover:underline">+ New Author</button>
                    </div>
                    
                    <div id="author_select_wrapper">
                        <select name="author_id" id="author_id" 
                            class="w-full bg-(--color-bg) border border-(--color-border) rounded-2xl px-5 py-4 focus:outline-none focus:border-(--color-primary) transition-colors appearance-none cursor-pointer">
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="author_input_wrapper" class="hidden space-y-2">
                        <div class="relative">
                            <input type="text" name="new_author_name" id="new_author_name" placeholder="Type author name..."
                                class="w-full bg-(--color-bg) border border-(--color-border) rounded-2xl px-5 py-4 focus:outline-none focus:border-(--color-primary) transition-colors placeholder:text-(--color-accent)">
                            <button type="button" onclick="toggleNewAuthor(false)" class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black uppercase tracking-widest text-(--color-muted) hover:text-(--color-text)">Cancel</button>
                        </div>
                    </div>
                    @error('author_id') <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror
                    @error('new_author_name') <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <script>
                    function toggleNewAuthor(isNew) {
                        const selectWrapper = document.getElementById('author_select_wrapper');
                        const inputWrapper = document.getElementById('author_input_wrapper');
                        const selectField = document.getElementById('author_id');
                        const inputField = document.getElementById('new_author_name');
                        const btnNew = document.getElementById('btn_new_author');

                        if (isNew) {
                            selectWrapper.classList.add('hidden');
                            inputWrapper.classList.remove('hidden');
                            selectField.value = '';
                            btnNew.classList.add('hidden');
                            inputField.focus();
                        } else {
                            selectWrapper.classList.remove('hidden');
                            inputWrapper.classList.add('hidden');
                            inputField.value = '';
                            btnNew.classList.remove('hidden');
                        }
                    }
                </script>

                <div class="space-y-2">
                    <label for="category_id" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) ml-1">Category</label>
                    <select name="category_id" id="category_id" required 
                        class="w-full bg-(--color-bg) border border-(--color-border) rounded-2xl px-5 py-4 focus:outline-none focus:border-(--color-primary) transition-colors appearance-none cursor-pointer">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) ml-1">Description</label>
                <textarea name="description" id="description" rows="5" 
                    class="w-full bg-(--color-bg) border border-(--color-border) rounded-2xl px-5 py-4 focus:outline-none focus:border-(--color-primary) transition-colors placeholder:text-(--color-accent) resize-none">{{ old('description', $book->description) }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="bg-(--color-surface) p-8 rounded-3xl border border-(--color-border) shadow-sm space-y-8">
                <h3 class="text-lg font-serif">Pricing & <span class="text-(--color-primary)">Inventory</span></h3>
                
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="price" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) ml-1">Sell Price ($)</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $book->price) }}" required 
                            class="w-full bg-(--color-bg) border border-(--color-border) rounded-2xl px-5 py-4 focus:outline-none focus:border-(--color-primary) transition-colors">
                    </div>
                    <div class="space-y-2">
                        <label for="original_price" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) ml-1">List Price ($)</label>
                        <input type="number" step="0.01" name="original_price" id="original_price" value="{{ old('original_price', $book->original_price) }}" 
                            class="w-full bg-(--color-bg) border border-(--color-border) rounded-2xl px-5 py-4 focus:outline-none focus:border-(--color-primary) transition-colors">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="stock" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) ml-1">Available Stock</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" required 
                        class="w-full bg-(--color-bg) border border-(--color-border) rounded-2xl px-5 py-4 focus:outline-none focus:border-(--color-primary) transition-colors">
                </div>
            </div>

            <div class="bg-(--color-surface) p-8 rounded-3xl border border-(--color-border) shadow-sm space-y-8">
                <h3 class="text-lg font-serif">Book <span class="text-(--color-primary)">Media</span></h3>
                
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) ml-1 mb-2">Change Image</label>
                        <div id="upload_zone" class="group relative border-2 border-dashed border-(--color-border) rounded-3xl p-8 transition-all hover:border-(--color-primary)/30 bg-(--color-bg)/50 text-center cursor-pointer overflow-hidden {{ $book->cover ? 'p-0 border-solid border-(--color-primary)/30' : '' }}">
                            <input type="file" name="cover" id="cover" accept="image/*" onchange="previewImage(this)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                            
                            <div id="preview_container" class="{{ $book->cover ? '' : 'hidden' }} absolute inset-0 z-10 bg-(--color-surface)">
                                <img id="image_preview" src="{{ $book->cover_url }}" alt="Preview" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                    <span class="text-white text-xs font-black uppercase tracking-widest">Change Image</span>
                                </div>
                            </div>

                            <div id="upload_prompt" class="space-y-2 {{ $book->cover ? 'opacity-0' : '' }}">
                                <div class="mx-auto w-10 h-10 bg-(--color-primary)/10 text-(--color-primary) rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                </div>
                                <span class="text-xs font-bold block">Replace Cover</span>
                            </div>
                        </div>

                        <div id="selection_indicator" class="hidden flex items-center gap-2 mt-3 ml-1 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            <span class="text-[10px] font-black uppercase tracking-widest">New Image Selected</span>
                        </div>
                    </div>
                    @error('cover') <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror

                    <!-- Digital File Upload (Conditional) -->
                    <div id="digital_asset_section" class="hidden pt-8 border-t border-(--color-border) space-y-4 animate-slide-down">
                        <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) ml-1 mb-2 italic">Digital Asset (PDF)</label>
                        <div class="relative group">
                            <input type="file" name="ebook_file" id="ebook_file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div id="pdf_status_zone" class="{{ $book->pdf_path ? 'bg-emerald-50 border-emerald-200' : 'bg-(--color-bg)' }} border border-(--color-border) group-hover:border-(--color-primary)/50 rounded-2xl px-6 py-5 flex items-center justify-between transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 {{ $book->pdf_path ? 'bg-emerald-500/10 text-emerald-600' : 'bg-red-500/10 text-red-500' }} rounded-xl flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    </div>
                                    <div>
                                        <p id="pdf_name" class="text-sm font-bold text-(--color-text)">
                                            {{ $book->pdf_path ? basename($book->pdf_path) : 'Upload eBook PDF' }}
                                        </p>
                                        <p id="pdf_info" class="text-[10px] text-(--color-muted) font-medium uppercase tracking-widest">
                                            {{ $book->pdf_path ? 'Current File Attached' : 'Max File Size: 10MB' }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-(--color-primary) group-hover:underline">Replace File</span>
                            </div>
                        </div>
                        @error('ebook_file') <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <script>
                function previewImage(input) {
                    const preview = document.getElementById('image_preview');
                    const container = document.getElementById('preview_container');
                    const prompt = document.getElementById('upload_prompt');
                    const indicator = document.getElementById('selection_indicator');
                    const zone = document.getElementById('upload_zone');

                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            container.classList.remove('hidden');
                            prompt.classList.add('opacity-0');
                            indicator.classList.remove('hidden');
                            zone.classList.remove('p-8');
                            zone.classList.add('p-0', 'border-solid', 'border-(--color-primary)/50');
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                // Digital Asset Toggle & PDF Preview
                document.addEventListener('DOMContentLoaded', function() {
                    const typeSelect = document.getElementById('type');
                    const digitalSection = document.getElementById('digital_asset_section');
                    const ebookInput = document.getElementById('ebook_file');
                    const pdfName = document.getElementById('pdf_name');
                    const pdfInfo = document.getElementById('pdf_info');
                    const statusZone = document.getElementById('pdf_status_zone');

                    function toggleDigital() {
                        if (typeSelect.value === 'digital') {
                            digitalSection.classList.remove('hidden');
                        } else {
                            digitalSection.classList.add('hidden');
                        }
                    }

                    typeSelect.addEventListener('change', toggleDigital);
                    toggleDigital(); // Initial check

                    ebookInput.addEventListener('change', function() {
                        if (this.files && this.files[0]) {
                            const file = this.files[0];
                            pdfName.textContent = file.name;
                            pdfInfo.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB • New PDF Ready';
                            statusZone.classList.remove('bg-emerald-50', 'border-emerald-200');
                            statusZone.classList.add('bg-blue-500/10', 'border-blue-500/20');
                        }
                    });
                });
            </script>
        </div>

        <style>
            @keyframes slideDown {
                from { transform: translateY(-10px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
            .animate-slide-down {
                animation: slideDown 0.3s ease-out forwards;
            }
        </style>

        <div class="flex items-center justify-end gap-6 pt-8">
            <a href="{{ route('seller.books.index') }}" class="text-sm font-bold text-(--color-muted) hover:text-(--color-text) transition-colors">Discard Changes</a>
            <button type="submit" class="bg-(--color-charcoal) text-white px-10 py-5 rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl hover-lift">
                Update Listing
            </button>
        </div>
    </form>
</div>
@endsection
