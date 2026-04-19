@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-12 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.books.index') }}" class="text-xs font-black uppercase tracking-widest text-(--color-muted) hover:text-(--color-primary) flex items-center gap-2 mb-4 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Back to Inventory
            </a>
            <h1 class="text-3xl font-serif mb-2">Edit <span class="text-(--color-primary)">Book</span></h1>
            <p class="text-(--color-muted) font-medium italic">Internal administrative override for: <strong>{{ $book->title }}</strong></p>
        </div>

        <div class="h-16 w-16 rounded-2xl border border-(--color-border) bg-(--color-surface) p-1 overflow-hidden shadow-sm">
            @if($book->cover_url)
                <img src="{{ $book->cover_url }}" alt="Cover" class="w-full h-full object-cover rounded-xl">
            @else
                <div class="w-full h-full bg-(--color-bg) flex items-center justify-center rounded-xl text-(--color-muted)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                </div>
            @endif
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 text-red-700 rounded-2xl shadow-sm">
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PATCH')

        <div class="bg-(--color-surface) p-8 rounded-3xl border border-(--color-border) shadow-sm">
            <h3 class="text-sm font-black uppercase tracking-widest text-(--color-muted) mb-8">Basic Information</h3>
            
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="isbn" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">ISBN</label>
                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium">
                    </div>
                    <div>
                        <label for="page_count" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Page Count</label>
                        <input type="number" name="page_count" id="page_count" value="{{ old('page_count', $book->page_count) }}" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Description</label>
                    <textarea name="description" id="description" rows="5" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium">{{ old('description', $book->description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-(--color-surface) p-8 rounded-3xl border border-(--color-border) shadow-sm">
            <h3 class="text-sm font-black uppercase tracking-widest text-(--color-muted) mb-8">Classification & Author</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="category_id" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Category</label>
                    <select name="category_id" id="category_id" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium appearance-none">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="author_id" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Author</label>
                    <select name="author_id" id="author_id" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium appearance-none">
                        <option value="">Select Author...</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="language" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Language</label>
                    <input type="text" name="language" id="language" value="{{ old('language', $book->language) }}" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium" placeholder="e.g. English">
                </div>

                <div>
                    <label for="publication_year" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Pub. Year</label>
                    <input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year', $book->publication_year) }}" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium">
                </div>
            </div>
        </div>

        <div class="bg-(--color-surface) p-8 rounded-3xl border border-(--color-border) shadow-sm">
            <h3 class="text-sm font-black uppercase tracking-widest text-(--color-muted) mb-8">Stock & Pricing</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="lg:col-span-1">
                    <label for="price" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $book->price) }}" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium">
                </div>
                <div class="lg:col-span-1">
                    <label for="original_price" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Original ($)</label>
                    <input type="number" step="0.01" name="original_price" id="original_price" value="{{ old('original_price', $book->original_price) }}" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium">
                </div>
                <div class="lg:col-span-1">
                    <label for="stock" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Stock Level</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium">
                </div>
                <div class="lg:col-span-1">
                    <label for="status" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Visibility</label>
                    <select name="status" id="status" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium appearance-none">
                        <option value="active" {{ old('status', $book->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $book->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-(--color-surface) p-8 rounded-3xl border border-(--color-border) shadow-sm">
            <h3 class="text-sm font-black uppercase tracking-widest text-(--color-muted) mb-8">Media Assets</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="cover" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Cover Image</label>
                    <input type="file" name="cover" id="cover" class="w-full text-xs font-medium file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-(--color-primary)/10 file:text-(--color-primary) hover:file:bg-(--color-primary)/20 transition-all cursor-pointer">
                    <p class="text-[10px] text-(--color-muted) mt-3 leading-relaxed uppercase tracking-tighter">Recommended: 800x1200px. JPG, PNG or WebP max 2MB.</p>
                </div>

                <div>
                    <label for="type" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">Product Format</label>
                    <select name="type" id="type" class="w-full px-4 py-3 bg-(--color-bg) border border-(--color-border) rounded-xl focus:outline-none focus:ring-2 focus:ring-(--color-primary)/20 focus:border-(--color-primary) transition-all font-medium appearance-none">
                        <option value="physical" {{ old('type', $book->type) == 'physical' ? 'selected' : '' }}>Physical Copy</option>
                        <option value="digital" {{ old('type', $book->type) == 'digital' ? 'selected' : '' }}>Digital eBook</option>
                    </select>
                </div>
            </div>

            <div id="ebook-upload-container" class="mt-8 {{ old('type', $book->type) == 'digital' ? '' : 'hidden' }}">
                <label for="ebook_file" class="block text-xs font-black uppercase tracking-widest text-(--color-charcoal) mb-2">E-book File (PDF)</label>
                <input type="file" name="ebook_file" id="ebook_file" class="w-full text-xs font-medium file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition-all cursor-pointer">
                @if($book->pdf_path)
                    <p class="text-xs text-green-600 mt-2 font-bold">Existing file: {{ basename($book->pdf_path) }}</p>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('admin.books.index') }}" class="px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest text-(--color-muted) hover:text-(--color-text) transition-all">Cancel Changes</a>
            <button type="submit" class="px-12 py-4 bg-(--color-text) text-(--color-bg) rounded-2xl text-xs font-black uppercase tracking-widest hover:opacity-90 hover:scale-[1.02] transition-all shadow-lg active:scale-95">
                Commit Updates
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('type').addEventListener('change', function() {
        const ebookContainer = document.getElementById('ebook-upload-container');
        if (this.value === 'digital') {
            ebookContainer.classList.remove('hidden');
        } else {
            ebookContainer.classList.add('hidden');
        }
    });
</script>
@endsection
