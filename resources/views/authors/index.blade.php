@extends('layouts.app')

@section('content')
    <div class="mb-16 text-center">
        <h1 class="text-4xl font-serif mb-4 leading-tight tracking-tight">Meet the <span class="text-(--color-primary)">Authors</span></h1>
        <p class="text-(--color-muted) max-w-xl mx-auto leading-relaxed text-lg">From world-renowned writers to rising stars, explore the minds behind the stories.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($authors as $author)
            <a href="{{ route('books.index', ['search' => $author->name]) }}" class="group block p-8 bg-(--color-surface) border border-(--color-border) rounded-3xl hover-lift hover:border-(--color-primary)/20 transition-all">
                <div class="flex items-start justify-between mb-8">
                    <div class="w-16 h-16 bg-(--color-accent)/20 rounded-full overflow-hidden border-2 border-(--color-border) shadow-xl group-hover:scale-105 transition-transform">
                        @if($author->profile_image)
                            <img src="{{ asset('storage/' . $author->profile_image) }}" alt="{{ $author->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-(--color-bg)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-muted)"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                        @endif
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-(--color-primary) bg-(--color-primary)/5 px-3 py-1 rounded-full border border-(--color-primary)/10">
                        {{ $author->books_count }} Titles
                    </span>
                </div>
                
                <h3 class="text-xl font-bold text-(--color-text) mb-1 group-hover:text-(--color-primary) transition-colors">{{ $author->name }}</h3>
                <p class="text-xs text-(--color-muted) italic mb-4">{{ $author->country ?? 'Global' }} Author</p>
                
                <p class="text-sm text-(--color-muted) line-clamp-3 leading-relaxed font-medium mb-8">
                    {{ $author->description ?? 'An influential author known for their compelling contributions to our library collection.' }}
                </p>
                
                <div class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-(--color-primary) opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-all lg:translate-x-[-10px] lg:group-hover:translate-x-0">
                    <span>View Bibliography</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </a>
        @endforeach
    </div>
@endsection
