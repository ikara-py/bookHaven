@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-1 md:px-0">
    <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-(--color-muted) hover:text-(--color-primary) mb-6 md:mb-12 transition-colors group">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
        Back to Library
    </a>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-16">
        <div class="md:col-span-5 relative">
            <div class="aspect-[3/4.5] rounded-3xl overflow-hidden shadow-2xl border border-(--color-border) bg-(--color-accent)/20 md:sticky md:top-32">
                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
            </div>
        </div>

        <div class="md:col-span-7 space-y-10">
            <div class="space-y-4 md:space-y-6">
                <span class="inline-block px-3 py-1 md:px-4 md:py-1.5 bg-(--color-accent)/10 text-(--color-primary) text-[9px] md:text-[10px] font-black uppercase tracking-widest rounded-full mb-2 md:mb-6 border border-(--color-primary)/10">
                    {{ $book->category->name ?? 'Uncategorized' }}
                </span>
                <h1 class="text-3xl md:text-5xl font-serif mb-2 md:mb-4 leading-tight text-(--color-text) tracking-tight">{{ $book->title }}</h1>
                <p class="text-lg md:text-xl text-(--color-muted) italic font-medium">by {{ $book->author->name ?? 'Unknown Author' }}</p>
            </div>

            <div class="flex items-center gap-4 md:gap-8 py-6 border-y border-(--color-border)">
                <div class="flex flex-col">
                    <span class="text-[10px] md:text-xs uppercase font-bold tracking-widest text-(--color-muted) mb-1">Price</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl md:text-3xl font-black text-(--color-text)">${{ number_format($book->price, 2) }}</span>
                        @if($book->original_price)
                            <span class="text-sm md:text-lg text-(--color-muted) line-through">${{ number_format($book->original_price, 2) }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="h-10 w-px bg-(--color-border)"></div>

                <div class="flex flex-col">
                    <span class="text-[10px] md:text-xs uppercase font-bold tracking-widest text-(--color-muted) mb-1">Format</span>
                    <span class="text-base md:text-lg font-bold text-(--color-text) capitalize">{{ $book->type }}</span>
                </div>

                <div class="h-10 w-px bg-(--color-border)"></div>

                <div class="flex flex-col">
                    <span class="text-[10px] md:text-xs uppercase font-bold tracking-widest text-(--color-muted) mb-1">Stock</span>
                    <span class="text-base md:text-lg font-bold @if($book->stock <= 0) text-red-500 @else text-(--color-text) @endif">
                        {{ $book->stock > 0 ? $book->stock . ' Left' : 'Out' }}
                    </span>
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="text-xs font-black uppercase tracking-widest text-(--color-text)">Synopsis</h3>
                <div class="text-(--color-muted) leading-relaxed text-lg whitespace-pre-wrap font-medium">{{ $book->description ?? 'No description available for this book yet.' }}</div>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-6">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold uppercase text-(--color-muted)">Language</span>
                    <p class="text-sm font-bold text-(--color-text) uppercase tracking-tight">{{ $book->language ?? 'N/A' }}</p>
                </div>
                <div class="space-y-1">
                    <span class="text-[10px] font-bold uppercase text-(--color-muted)">Page Count</span>
                    <p class="text-sm font-bold text-(--color-text) tracking-tight">{{ $book->page_count ?? 'N/A' }} Pages</p>
                </div>
                <div class="space-y-1">
                    <span class="text-[10px] font-bold uppercase text-(--color-muted)">Publication Year</span>
                    <p class="text-sm font-bold text-(--color-text) tracking-tight">{{ $book->publication_year ?? 'N/A' }}</p>
                </div>
                <div class="space-y-1">
                    <span class="text-[10px] font-bold uppercase text-(--color-muted)">Sold By</span>
                    <p class="text-sm font-bold text-(--color-primary) hover:underline cursor-pointer">{{ $book->seller->full_name ?? 'The Book Haven' }}</p>
                </div>
            </div>

            <div class="pt-4 md:pt-8 space-y-6">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <div class="flex flex-col gap-1.5 w-full md:w-auto">
                        <span class="text-[10px] font-black uppercase text-(--color-muted) tracking-widest ml-1">Select Quantity</span>
                        <div class="flex items-center bg-(--color-accent)/10 border border-(--color-border) rounded-2xl p-1 shadow-inner h-14 w-full md:w-[150px]">
                            <button type="button" onclick="decrementQty()" class="flex-1 md:w-12 h-full flex items-center justify-center text-(--color-muted) hover:text-(--color-primary) hover:bg-(--color-surface) rounded-xl transition-all disabled:opacity-30 disabled:cursor-not-allowed" id="qty-minus" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                            </button>
                            <span id="qty-display" class="w-12 text-center font-black text-lg tabular-nums">1</span>
                            <button type="button" onclick="incrementQty()" class="flex-1 md:w-12 h-full flex items-center justify-center text-(--color-muted) hover:text-(--color-primary) hover:bg-(--color-surface) rounded-xl transition-all disabled:opacity-30 disabled:cursor-not-allowed" id="qty-plus" @if($book->stock <= 1) disabled @endif>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="grow pt-0 md:pt-4">
                        <div class="flex items-center gap-2 text-xs font-bold @if($book->stock > 5) text-green-600 @else text-amber-600 @endif mb-1">
                            <div class="w-2 h-2 rounded-full bg-current animate-pulse"></div>
                            <span>{{ $book->stock > 0 ? "In Stock ({$book->stock})" : 'Sold Out' }}</span>
                        </div>
                        <p class="text-[10px] text-(--color-muted) uppercase tracking-tighter">Ready for immediate priority shipping</p>
                    </div>
                </div>

                @if(auth()->check() && auth()->user()->isAdmin())
                    <div class="flex flex-col sm:flex-row gap-4 w-full">
                        <a href="{{ route('admin.books.edit', $book->id) }}" class="flex-1 bg-(--color-text) text-(--color-bg) py-5 rounded-2xl font-black text-lg hover:opacity-90 transition-all shadow-[0_20px_50px_rgba(0,0,0,0.1)] active:scale-[0.98] text-center">
                            Edit Book
                        </a>
                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this book?');" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 text-white py-5 rounded-2xl font-black text-lg hover:bg-red-700 transition-all shadow-[0_20px_50px_rgba(220,38,38,0.15)] active:scale-[0.98]">
                                Delete Book
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex gap-4">
                        <form action="{{ route('cart.add') }}" method="POST" class="grow">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <input type="hidden" name="quantity" id="quantity-input" value="1">
                            <button class="w-full bg-(--color-text) text-(--color-bg) py-5 rounded-2xl font-black text-lg hover:opacity-90 transition-all shadow-[0_20px_50px_rgba(0,0,0,0.15)] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed" @if($book->stock <= 0) disabled @endif>
                                {{ $book->stock > 0 ? 'Add to Collection' : 'Sold Out' }}
                            </button>
                        </form>

                        @auth
                        @if(!auth()->user()->isSeller())
                        <button 
                            onclick="toggleWishlist({{ $book->id }}, this)"
                            class="p-5 rounded-2xl border border-(--color-border) hover:border-(--color-primary) transition-all group/heart"
                            title="Add to Wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{ $isInWishlist ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ $isInWishlist ? 'text-(--color-primary)' : 'text-(--color-muted)' }} group-hover/heart:text-(--color-primary) transition-colors"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                        </button>
                        @endif
                        @endauth
                    </div>
                @endif
            </div>

            <div class="mt-12 pt-12 border-t border-(--color-border) grid grid-cols-2 gap-8">
                <div>
                    <span class="block text-[10px] font-black uppercase text-(--color-muted) tracking-widest mb-1">Book Identity</span>
                    <p class="text-sm font-bold text-(--color-text)">ISBN: {{ $book->isbn }}</p>
                </div>
                <div>
                    <span class="block text-[10px] font-black uppercase text-(--color-muted) tracking-widest mb-1">Pages</span>
                    <p class="text-sm font-bold text-(--color-text)">{{ $book->page_count ?? '---' }} Pages</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-12 md:mt-20 pt-8 md:pt-16 border-t border-(--color-border)">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h2 class="text-2xl md:text-3xl font-serif text-(--color-text) mb-2">Reader Reviews</h2>
                <div class="flex items-center gap-3">
                    <div class="flex items-center text-amber-400">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 md:w-5 md:h-5 {{ $i <= round($book->averageRating()) ? 'fill-current' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        @endfor
                    </div>
                    <span class="text-base md:text-lg font-bold text-(--color-text)">{{ number_format($book->averageRating(), 1) }}</span>
                    <span class="text-xs md:text-sm text-(--color-muted)">({{ $book->reviewsCount() }})</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-7 space-y-8">
                @forelse($book->reviews as $review)
                    <div class="bg-(--color-accent)/5 border border-(--color-border) rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-(--color-primary)/10 flex items-center justify-center font-bold text-(--color-primary)">
                                    {{ substr($review->user->full_name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-(--color-text)">{{ $review->user->full_name }}</h4>
                                    <span class="text-xs text-(--color-muted)">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    @endfor
                                </div>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');" class="flex items-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-700 hover:bg-(--color-primary)/5 p-2 rounded-lg transition-all" title="Delete Review">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <p class="text-(--color-text) leading-relaxed">
                            {{ $review->comment }}
                        </p>
                    </div>
                @empty
                    <div class="text-center py-12 bg-(--color-accent)/5 rounded-3xl border border-dashed border-(--color-border)">
                        <span class="text-(--color-muted) font-medium">No reviews yet. Be the first to share your thoughts!</span>
                    </div>
                @endforelse
            </div>

            <div class="lg:col-span-5">
                @auth
                    @if($book->isPurchasedBy(auth()->id()))
                        @if(!$book->reviews->contains('user_id', auth()->id()))
                            <div class="bg-(--color-accent)/10 p-8 rounded-3xl border border-(--color-border) sticky top-32">
                                <h3 class="text-xl font-bold text-(--color-text) mb-6">Write a Review</h3>
                                <form action="{{ route('reviews.store', $book) }}" method="POST" class="space-y-6">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-bold text-(--color-muted) mb-3">Your Rating</label>
                                        <div class="flex items-center gap-2 flex-row-reverse justify-end peer border p-4 rounded-xl border-(--color-border) bg-(--color-surface)">
                                            @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" class="peer hidden" required>
                                                <label for="rating-{{ $i }}" class="cursor-pointer text-gray-300 peer-checked:text-amber-400 hover:text-amber-400 transition-colors">
                                                    <svg class="w-8 h-8 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                    <div>
                                        <label for="comment" class="block text-sm font-bold text-(--color-muted) mb-2">Your Thoughts</label>
                                        <textarea name="comment" id="comment" rows="4" class="w-full bg-(--color-surface) border border-(--color-border) rounded-xl p-4 text-(--color-text) focus:ring-2 focus:ring-(--color-primary) focus:border-transparent outline-none transition-all resize-none" placeholder="What did you think of the book?"></textarea>
                                    </div>
                                    <button type="submit" class="w-full bg-(--color-text) text-(--color-bg) py-4 rounded-xl font-bold hover:opacity-90 transition-all shadow-xl active:scale-[0.98]">Submit Review</button>
                                </form>
                            </div>
                        @else
                            <div class="bg-(--color-accent)/10 p-8 rounded-3xl border border-(--color-border) text-center">
                                <span class="w-12 h-12 bg-green-500/10 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                                </span>
                                <h3 class="text-xl font-bold text-(--color-text) mb-2">Review Submitted</h3>
                                <p class="text-(--color-muted)">Thank you for sharing your thoughts on this book!</p>
                            </div>
                        @endif
                    @else
                        <div class="bg-(--color-accent)/5 p-8 rounded-3xl border border-dashed border-(--color-border) text-center">
                            <h3 class="text-xl font-bold text-(--color-text) mb-3">Verified Purchase Required</h3>
                            <p class="text-(--color-muted) mb-0 font-medium italic text-sm">
                                To ensure the highest quality of feedback, only readers who have purchased and received this book can leave a review.
                            </p>
                        </div>
                    @endif
                @else
                    <div class="bg-(--color-accent)/10 p-8 rounded-3xl border border-(--color-border) text-center">
                        <h3 class="text-xl font-bold text-(--color-text) mb-3">Join the discussion</h3>
                        <p class="text-(--color-muted) mb-6">You must be logged in to leave a review for this book.</p>
                        <a href="{{ route('login') }}" class="inline-block w-full bg-(--color-text) text-(--color-bg) py-4 rounded-xl font-bold hover:opacity-90 transition-all">Log In to Review</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>

<style>
    .flex-row-reverse > label:hover,
    .flex-row-reverse > label:hover ~ label {
        color: #fbbf24 !important;
    }
</style>

<script>
    const maxStock = {{ $book->stock }};
    const qtyDisplay = document.getElementById('qty-display');
    const qtyInput = document.getElementById('quantity-input');
    const btnMinus = document.getElementById('qty-minus');
    const btnPlus = document.getElementById('qty-plus');

    function updateQty(newVal) {
        if (!qtyDisplay) return;
        qtyDisplay.textContent = newVal;
        qtyInput.value = newVal;
        
        btnMinus.disabled = (newVal <= 1);
        btnPlus.disabled = (newVal >= maxStock);
    }

    function incrementQty() {
        let current = parseInt(qtyDisplay.textContent);
        if(current < maxStock) updateQty(current + 1);
    }

    function decrementQty() {
        let current = parseInt(qtyDisplay.textContent);
        if(current > 1) updateQty(current - 1);
    }

    function toggleWishlist(bookId, btn) {
        const svg = btn.querySelector('svg');
        
        fetch('{{ route('wishlist.toggle') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ book_id: bookId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'added') {
                svg.setAttribute('fill', 'currentColor');
                svg.classList.remove('text-(--color-muted)');
                svg.classList.add('text-(--color-primary)');
            } else {
                svg.setAttribute('fill', 'none');
                svg.classList.add('text-(--color-muted)');
                svg.classList.remove('text-(--color-primary)');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
