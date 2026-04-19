@extends('layouts.app')

@section('content')
    <div class="mb-16 text-center">
        <h1 class="text-4xl font-serif mb-4 leading-tight tracking-tight">Browse by <span class="text-(--color-primary)">Category</span></h1>
        <p class="text-(--color-muted) max-w-xl mx-auto leading-relaxed text-lg">From gripping mysteries to insightful history, find exactly what you're looking for.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($categories as $category)
            <a href="{{ route('books.index', ['category_id' => $category->id]) }}" class="group block p-8 bg-(--color-surface) border border-(--color-border) rounded-3xl hover-lift hover:border-(--color-primary)/20 transition-all">
                <div class="flex items-start justify-between mb-8">
                    <div class="w-14 h-14 bg-(--color-bg) rounded-2xl flex items-center justify-center border border-(--color-border) group-hover:bg-(--color-primary) group-hover:border-(--color-primary) transition-all group-hover:shadow-[0_10px_20px_-5px_rgba(245,48,3,0.3)]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-text) group-hover:text-white transition-colors">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-black uppercase tracking-widest text-(--color-muted) bg-(--color-bg) px-3 py-1 rounded-full border border-(--color-border)">
                        {{ $category->books_count }} Books
                    </span>
                </div>
                
                <h3 class="text-xl font-bold text-(--color-text) mb-2 group-hover:text-(--color-primary) transition-colors">{{ $category->name }}</h3>
                <p class="text-sm text-(--color-muted) line-clamp-2 leading-relaxed font-medium">{{ $category->description ?? 'Explore our curated collection of ' . strtolower($category->name) . ' books.' }}</p>
                
                <div class="mt-8 flex items-center gap-2 text-xs font-black uppercase tracking-widest text-(--color-primary) opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0">
                    <span>Explore Collection</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </a>
        @endforeach
    </div>
@endsection
