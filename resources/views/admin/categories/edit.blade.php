@extends('layouts.app')

@section('content')
    <div class="mb-12">
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-(--color-muted) hover:text-(--color-primary) mb-6 transition-colors group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            Back to Categories
        </a>
        <h1 class="text-3xl font-serif mb-2">Edit <span class="text-(--color-primary)">{{ $category->name }}</span></h1>
        <p class="text-(--color-muted) font-medium">Any changes made here will update the category site-wide instantly.</p>
    </div>

    <div class="max-w-2xl bg-(--color-surface) rounded-3xl border border-(--color-border) p-8 shadow-sm">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Category Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors" required>
                @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="parent_id" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Parent Category (Optional)</label>
                <select id="parent_id" name="parent_id" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors cursor-pointer appearance-none">
                    <option value="">None (Top Level Category)</option>
                    @foreach($allCategories as $parentOpt)
                        <option value="{{ $parentOpt->id }}" {{ old('parent_id', $category->parent_id) == $parentOpt->id ? 'selected' : '' }}>
                            {{ $parentOpt->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors resize-none">{{ old('description', $category->description) }}</textarea>
                @error('description') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 border-t border-(--color-border) flex items-center justify-end gap-4">
                <a href="{{ route('admin.categories.index') }}" class="text-sm font-bold text-(--color-muted) hover:text-(--color-text) transition-colors">Cancel</a>
                <button type="submit" class="bg-(--color-text) text-(--color-bg) px-8 py-3 rounded-xl font-bold hover:opacity-90 transition-all active:scale-[0.98]">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection
