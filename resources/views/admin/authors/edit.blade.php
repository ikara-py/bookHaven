@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 md:px-0 mb-20">
        <a href="{{ route('admin.authors.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-(--color-muted) hover:text-(--color-primary) mb-6 transition-colors group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            Back to Authors
        </a>

        <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) overflow-hidden shadow-sm">
            <div class="p-6 md:p-10 border-b border-(--color-border) bg-(--color-bg)/50">
                <h1 class="text-2xl md:text-3xl font-serif mb-2">Edit <span class="text-(--color-primary)">{{ $author->name }}</span></h1>
                <p class="text-(--color-muted) font-medium">Update the details and biography for this author.</p>
            </div>

            <form action="{{ route('admin.authors.update', $author->id) }}" method="POST" class="p-6 md:p-10 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Author Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $author->name) }}" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors" required>
                    @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="country" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Country</label>
                    <input type="text" id="country" name="country" value="{{ old('country', $author->country) }}" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors">
                    @error('country') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_of_birth" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Birth Date</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $author->date_of_birth?->format('Y-m-d')) }}" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors">
                        @error('date_of_birth') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="date_of_death" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Death Date</label>
                        <input type="date" id="date_of_death" name="date_of_death" value="{{ old('date_of_death', $author->date_of_death?->format('Y-m-d')) }}" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors">
                        @error('date_of_death') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Biography</label>
                    <textarea id="description" name="description" rows="5" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors resize-none">{{ old('description', $author->description) }}</textarea>
                    @error('description') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-6 border-t border-(--color-border) flex items-center justify-end gap-4">
                    <a href="{{ route('admin.authors.index') }}" class="text-sm font-bold text-(--color-muted) hover:text-(--color-text) transition-colors">Cancel</a>
                    <button type="submit" class="bg-(--color-primary) text-white px-8 py-3 rounded-xl font-bold hover:bg-(--color-primary)/90 transition-all shadow-lg shadow-(--color-primary)/20 active:scale-[0.98]">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
