@extends('layouts.app')

@section('content')
    <div class="mb-12">
        <h1 class="text-4xl font-serif mb-4 leading-tight">My <span class="text-(--color-primary)">Favorites</span></h1>
        <p class="text-(--color-muted) max-w-2xl leading-relaxed text-lg">Your curated collection of stories. Highlighting the books that captured your imagination.</p>
    </div>

    @if($wishlist->books->isEmpty())
        <div class="text-center py-20 bg-(--color-accent)/10 rounded-3xl border-2 border-dashed border-(--color-accent)">
            <div class="w-20 h-20 bg-(--color-accent)/30 rounded-full flex items-center justify-center mx-auto mb-6 text-(--color-muted)">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Your wishlist is empty</h3>
            <p class="text-(--color-muted) mb-8">Start exploring our library and save the books you love!</p>
            <a href="{{ route('books.index') }}" class="bg-(--color-primary) text-white px-8 py-3 rounded-full font-black uppercase tracking-widest text-xs hover:shadow-xl transition-all hover:-translate-y-0.5 shadow-lg shadow-(--color-primary)/25">
                Browse Library
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
            @foreach($wishlist->books as $book)
                <div id="wishlist-item-{{ $book->id }}" class="group h-full flex flex-col bg-(--color-surface) border border-(--color-border) rounded-2xl p-4 overflow-hidden hover-lift hover:border-(--color-primary)/20 transition-all">
                    <div class="relative aspect-3/4 rounded-xl overflow-hidden mb-5 bg-(--color-accent)/30 group-hover:scale-[1.02] transition-transform duration-500 shadow-sm group-hover:shadow-md">
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        <div class="absolute top-3 right-3">
                            <form action="{{ route('wishlist.toggle') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit" class="p-2 bg-(--color-surface)/80 backdrop-blur-sm rounded-full shadow-sm hover:bg-(--color-surface) transition-all text-red-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grow flex flex-col">
                        <div class="mb-1 text-[11px] font-bold text-(--color-primary) uppercase tracking-wider">
                            {{ $book->category->name ?? 'Uncategorized' }}
                        </div>
                        <h3 class="text-base font-bold leading-tight mb-1 group-hover:text-(--color-primary) transition-colors line-clamp-2">
                            {{ $book->title }}
                        </h3>
                        <p class="text-sm text-(--color-muted) mb-4 italic">by {{ $book->author->name ?? 'Unknown Author' }}</p>
                        
                        <div class="mt-auto flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-lg font-bold text-(--color-text)">${{ number_format($book->price, 2) }}</span>
                            </div>
                            
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="flex items-center gap-2 bg-(--color-text) text-(--color-bg) px-4 py-2 rounded-xl text-xs font-bold hover:opacity-90 transition-all shadow-sm active:scale-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                    Add
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
