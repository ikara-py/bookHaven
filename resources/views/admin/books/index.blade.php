@extends('layouts.app')

@section('content')
    <div class="mb-12 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif mb-2">Book <span class="text-(--color-primary)">Management</span></h1>
            <p class="text-(--color-muted) font-medium">Review and manage the platform's book catalog.</p>
        </div>
        
        <div class="flex flex-col md:flex-row items-center gap-4">
            <form action="{{ route('admin.books.index') }}" method="GET" class="flex items-center w-full max-w-lg bg-(--color-surface) border border-(--color-border) rounded-2xl pl-4 pr-1.5 py-1.5 hover:border-(--color-primary)/50 focus-within:border-(--color-primary) transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-(--color-muted) ml-2" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search Title, ISBN or Author..." 
                    value="{{ request('search') }}"
                    class="w-full px-4 py-1 text-sm bg-transparent outline-none placeholder-(--color-muted) text-(--color-text)"
                >
                @if(request('search'))
                    <a href="{{ route('admin.books.index') }}" class="mr-3 text-(--color-muted) hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </a>
                @endif
                <button type="submit" class="bg-(--color-text) text-(--color-bg) text-[10px] font-black uppercase tracking-widest px-6 py-2.5 rounded-xl hover:opacity-90 transition-all active:scale-[0.95]">Search</button>
            </form>
            
            <span class="text-xs font-black uppercase tracking-widest text-(--color-text) bg-(--color-bg) px-4 py-2 rounded-full border border-(--color-border) shadow-sm">
                {{ $books->total() }} Total Books
            </span>
        </div>
    </div>

    <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) overflow-hidden shadow-sm">
        <div class="hidden lg:block">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-(--color-bg)/50 border-b border-(--color-border)">
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Book Details</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Category</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Stock / Price</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Seller</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted) text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-(--color-border)">
                    @forelse($books as $book)
                        <tr class="hover:bg-(--color-bg)/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-16 bg-(--color-bg) rounded-lg flex items-center justify-center border border-(--color-border) overflow-hidden shrink-0">
                                        @if($book->cover_url)
                                            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" class="text-(--color-muted)" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('books.show', $book->id) }}" class="font-bold text-(--color-text) hover:text-(--color-primary) hover:underline">{{ Str::limit($book->title, 40) }}</a>
                                        <p class="text-xs text-(--color-muted) font-medium">by {{ $book->author->name ?? 'Unknown' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded bg-(--color-bg) border border-(--color-border)">
                                    {{ $book->category->name ?? 'None' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <p class="font-bold text-(--color-text)">${{ number_format($book->price, 2) }}</p>
                                    <p class="text-xs {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }} font-bold">
                                        {{ $book->stock > 0 ? $book->stock . ' In Stock' : 'Out of Stock' }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-(--color-text)">{{ $book->seller->full_name ?? '---' }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="relative inline-block text-left">
                                    <button data-dropdown-toggle="book-dropdown-{{ $book->id }}" class="p-2 hover:bg-(--color-bg) rounded-full transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-muted)"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                    </button>
                                    
                                    <div id="book-dropdown-{{ $book->id }}" data-dropdown class="hidden absolute right-0 mt-2 w-48 bg-(--color-surface) border border-(--color-border) rounded-2xl shadow-xl z-50 overflow-hidden">
                                        <a href="{{ route('books.show', $book->id) }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-(--color-text) hover:bg-(--color-bg) transition-colors border-b border-(--color-border)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                            View Listing
                                        </a>
                                        <a href="{{ route('admin.books.edit', $book->id) }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-(--color-primary) hover:bg-(--color-bg) transition-colors border-b border-(--color-border)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                            Edit Details
                                        </a>
                                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Delete this book permanently?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-red-600 hover:bg-red-500/10 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                                Delete Book
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-(--color-muted)">No books found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="lg:hidden divide-y divide-(--color-border)">
            @forelse($books as $book)
                <div class="p-5 space-y-4">
                    <div class="flex gap-4">
                        <div class="w-20 h-28 bg-(--color-bg) rounded-xl flex items-center justify-center border border-(--color-border) overflow-hidden shrink-0 shadow-sm">
                            @if($book->cover_url)
                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="text-(--color-muted)" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                            @endif
                        </div>
                        <div class="flex-grow min-w-0">
                            <div class="flex justify-between items-start gap-2">
                                <h4 class="font-bold text-(--color-text) leading-tight truncate">{{ $book->title }}</h4>
                                <div class="relative shrink-0">
                                    <button data-dropdown-toggle="book-dropdown-mobile-{{ $book->id }}" class="p-1.5 bg-(--color-bg) rounded-lg border border-(--color-border)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-muted)"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                    </button>
                                    <div id="book-dropdown-mobile-{{ $book->id }}" data-dropdown class="hidden absolute right-0 mt-2 w-48 bg-(--color-surface) border border-(--color-border) rounded-2xl shadow-2xl z-50 overflow-hidden">
                                        <a href="{{ route('books.show', $book->id) }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-(--color-text) border-b border-(--color-border)">View Listing</a>
                                        <a href="{{ route('admin.books.edit', $book->id) }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-(--color-primary) border-b border-(--color-border)">Edit Details</a>
                                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full text-left px-4 py-3 text-xs font-bold text-red-600">Delete Book</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <p class="text-[10px] text-(--color-muted) font-medium mt-1">by {{ $book->author->name ?? 'Unknown' }}</p>
                            
                            <div class="mt-3 space-y-1.5">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-(--color-muted)">Price</span>
                                    <span class="font-black text-(--color-text)">${{ number_format($book->price, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-(--color-muted)">Stock</span>
                                    <span class="font-bold {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $book->stock }} units</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-(--color-border)/50">
                        <span class="text-[10px] font-black uppercase tracking-widest bg-(--color-bg) px-2 py-1 rounded border border-(--color-border)">{{ $book->category->name ?? 'None' }}</span>
                        <span class="text-[10px] text-(--color-muted) font-medium">Seller: <span class="text-(--color-text) font-bold">{{ $book->seller->full_name ?? '---' }}</span></span>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-(--color-muted)">No books found.</div>
            @endforelse
        </div>
    </div>
        
        @if($books->hasPages())
            <div class="px-6 py-4 bg-(--color-bg) border-t border-(--color-border)">
                {{ $books->links() }}
            </div>
        @endif
    </div>
@endsection
