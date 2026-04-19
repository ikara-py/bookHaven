@extends('layouts.app')

@section('content')
    <div class="mb-8 md:mb-12">
        <h1 class="text-3xl md:text-4xl font-serif mb-4 leading-tight">Explore Our <span class="text-(--color-primary)">Library</span></h1>
        <p class="text-(--color-muted) max-w-2xl leading-relaxed text-base md:text-lg">Discover your next favorite story. From timeless classics to modern masterpieces, your journey begins here.</p>
    </div>

    @if($topBooks->isNotEmpty())
    <div class="mb-12 relative w-[100vw] left-[50%] right-[50%] -ml-[50vw] -mr-[50vw] bg-(--color-accent)/5 overflow-hidden py-10 border-y border-(--color-border)">
        <div class="absolute top-0 left-0 w-24 md:w-64 h-full bg-gradient-to-r from-(--color-bg) to-transparent z-10 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-24 md:w-64 h-full bg-gradient-to-l from-(--color-bg) to-transparent z-10 pointer-events-none"></div>
        
        <div class="text-[10px] md:text-xs font-black uppercase tracking-widest text-(--color-primary) absolute top-3 pl-4 md:pl-[calc(50vw-min(50vw,768px))] z-20">★ Current Top Sellers</div>
        
        <div class="flex animate-marquee w-max gap-4 md:gap-6 items-center cursor-pointer mt-6">
            @foreach(array_merge($topBooks->all(), $topBooks->all()) as $topBook)
                <a href="{{ route('books.show', $topBook) }}" class="flex-none group/marquee flex items-center gap-3 md:gap-4 bg-(--color-surface) border border-(--color-border) rounded-2xl p-3 md:p-4 hover:border-(--color-primary)/30 shadow-sm hover:shadow-md transition-all w-[280px] md:w-[320px]">
                    <img src="{{ $topBook->cover_url }}" alt="Cover" class="w-14 h-20 md:w-16 md:h-24 object-cover rounded-lg shadow-sm group-hover/marquee:-translate-y-1 transition-transform">
                    <div class="flex flex-col overflow-hidden w-full">
                        <span class="text-(--color-text) font-bold truncate text-sm md:text-base mb-0.5 group-hover/marquee:text-(--color-primary) transition-colors">{{ $topBook->title }}</span>
                        <span class="text-(--color-muted) text-[10px] md:text-xs truncate italic">by {{ $topBook->author->name ?? 'Unknown' }}</span>
                        <div class="mt-2 md:mt-3 flex items-center gap-2">
                            <span class="bg-(--color-primary)/10 text-(--color-primary) text-[9px] md:text-[10px] font-black uppercase tracking-widest px-2 md:px-2.5 py-1 rounded-full">{{ number_format($topBook->downloads) }} Downloads</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <div class="mb-8 md:mb-12 pb-6 md:pb-8 border-b border-(--color-border)">
        <form action="{{ route('books.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 md:gap-6 items-center justify-between">
            <div class="flex items-center w-full max-w-lg bg-(--color-surface) border border-(--color-border) rounded-2xl pl-4 pr-1.5 py-1.5 hover:border-(--color-primary)/50 focus-within:border-(--color-primary) transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="text-(--color-muted) ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search titles, authors..." 
                    value="{{ request('search') }}"
                    class="w-full px-3 md:px-4 py-1 text-sm bg-transparent outline-none placeholder-(--color-muted) text-(--color-text)"
                >
                <button type="submit" class="bg-(--color-text) text-(--color-bg) text-[10px] md:text-[11px] font-black uppercase tracking-widest px-4 md:px-6 py-2.5 rounded-xl hover:opacity-90 transition-all active:scale-[0.95]">Search</button>
            </div>

            <div class="flex gap-2 w-full md:w-auto">
                <select name="category_id" onchange="this.form.submit()" class="text-xs md:text-sm bg-(--color-surface) border border-(--color-border) px-3 md:px-4 py-2 rounded-full outline-none focus:border-(--color-primary) transition-all w-full md:w-auto cursor-pointer">
                    <option value="">Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                
                <select name="type" onchange="this.form.submit()" class="text-xs md:text-sm bg-(--color-surface) border border-(--color-border) px-3 md:px-4 py-2 rounded-full outline-none focus:border-(--color-primary) transition-all w-full md:w-auto cursor-pointer">
                    <option value="">Formats</option>
                    <option value="physical" {{ request('type') == 'physical' ? 'selected' : '' }}>Physical</option>
                    <option value="digital" {{ request('type') == 'digital' ? 'selected' : '' }}>Digital</option>
                </select>
            </div>
        </form>
    </div>

    @if($books->isEmpty())
        <div class="text-center py-20 bg-(--color-accent)/10 rounded-2xl border-2 border-dashed border-(--color-accent)">
            <p class="text-(--color-muted) text-lg mb-4">We couldn't find any books matching your search.</p>
            <a href="{{ route('books.index') }}" class="text-(--color-primary) font-medium hover:underline">Clear all filters</a>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-8">
            @foreach($books as $book)
                <div class="group h-full flex flex-col bg-(--color-surface) border border-(--color-border) rounded-2xl p-3 md:p-4 overflow-hidden hover-lift hover:border-(--color-primary)/20 transition-all">
                    <div class="relative aspect-3/4 rounded-xl overflow-hidden mb-4 md:mb-5 bg-(--color-accent)/30 group-hover:scale-[1.02] transition-transform duration-500 shadow-sm group-hover:shadow-md">
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        
                        <div class="absolute top-2 left-2 md:top-3 md:left-3 flex flex-col gap-1 md:gap-2">
                             @if($book->type == 'digital')
                                <span class="bg-indigo-500/90 backdrop-blur-sm text-white px-2 md:px-3 py-1 rounded-full text-[8px] md:text-[10px] font-bold uppercase tracking-widest shadow-lg">E-book</span>
                             @endif
                             @if($book->stock <= 5 && $book->type != 'digital' && $book->stock > 0)
                                <span class="bg-amber-500/90 backdrop-blur-sm text-white px-2 md:px-3 py-1 rounded-full text-[8px] md:text-[10px] font-bold uppercase tracking-widest shadow-lg">Low Stock</span>
                             @endif
                        </div>

                        @auth
                            @if(!auth()->user()->isAdmin())
                                <div class="absolute top-2 right-2 md:top-3 md:right-3">
                                    <button 
                                        onclick="toggleWishlist({{ $book->id }}, this)" 
                                        class="p-1.5 md:p-2 bg-(--color-surface)/80 backdrop-blur-sm rounded-full shadow-sm hover:bg-(--color-surface) transition-all group/heart"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                                            class="md:w-[18px] md:h-[18px]"
                                            viewBox="0 0 24 24" 
                                            fill="{{ in_array($book->id, $wishlistBookIds) ? 'currentColor' : 'none' }}" 
                                            stroke="currentColor" 
                                            stroke-width="2" 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round"
                                            class="{{ in_array($book->id, $wishlistBookIds) ? 'text-red-500' : 'text-(--color-muted) group-hover/heart:text-red-500' }} transition-colors"
                                        >
                                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <div class="grow flex flex-col">
                        <div class="mb-1 text-[9px] md:text-[11px] font-bold text-(--color-primary) uppercase tracking-wider">
                            {{ $book->category->name ?? 'Uncategorized' }}
                        </div>
                        <h3 class="text-sm md:text-base font-bold leading-tight mb-1 group-hover:text-(--color-primary) transition-colors line-clamp-2">
                            {{ $book->title }}
                        </h3>
                        <p class="text-[12px] md:text-sm text-(--color-muted) mb-3 md:mb-4 italic">by {{ $book->author->name ?? 'Unknown Author' }}</p>
                        
                        <div class="mt-auto flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-base md:text-lg font-bold text-(--color-text)">${{ number_format($book->price, 2) }}</span>
                                @if($book->original_price)
                                    <span class="text-[10px] md:text-xs text-(--color-muted) line-through">${{ number_format($book->original_price, 2) }}</span>
                                @endif
                            </div>
                            
                            <a href="{{ route('books.show', $book) }}" class="p-1.5 md:p-2 border border-(--color-border) rounded-full hover:bg-(--color-primary) hover:text-white hover:border-(--color-primary) transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="md:w-[18px] md:h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 md:mt-20">
            {{ $books->links() }}
        </div>
    @endif

    <script>
        function toggleWishlist(bookId, btn) {
            const svg = btn.querySelector('svg');
            const isAdding = svg.getAttribute('fill') === 'none';

            fetch('{{ route('wishlist.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ book_id: bookId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    if (isAdding) {
                        svg.setAttribute('fill', 'currentColor');
                        svg.classList.remove('text-(--color-muted)');
                        svg.classList.add('text-red-500');
                    } else {
                        svg.setAttribute('fill', 'none');
                        svg.classList.remove('text-red-500');
                        svg.classList.add('text-(--color-muted)');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
