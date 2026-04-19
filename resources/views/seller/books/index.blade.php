@extends('layouts.app')

@section('content')
<div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
        <h1 class="text-4xl font-serif mb-4 leading-tight">My <span class="text-(--color-primary)">Collection</span></h1>
        <p class="text-(--color-muted) font-medium">Manage your active listings and track inventory levels.</p>
    </div>
    <a href="{{ route('seller.books.create') }}" class="inline-flex items-center gap-3 bg-(--color-charcoal) text-white px-8 py-4 rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl hover-lift">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        New Listing
    </a>
</div>

@if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-800 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3 animate-fade-in">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-(--color-surface) border border-(--color-border) rounded-3xl overflow-hidden shadow-sm">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-(--color-accent)/10">
                <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-(--color-muted)">Book Details</th>
                <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-(--color-muted)">Metrics</th>
                <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-(--color-muted)">Inventory</th>
                <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-(--color-muted)">Pricing</th>
                <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-(--color-muted) text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-(--color-border)">
            @forelse($books as $book)
                <tr class="hover:bg-(--color-accent)/5 transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-20 rounded-xl overflow-hidden bg-(--color-accent)/20 border border-(--color-border) shrink-0 shadow-sm">
                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="font-bold text-(--color-text) text-lg leading-tight group-hover:text-(--color-primary) transition-colors">{{ $book->title }}</h3>
                                <p class="text-sm text-(--color-muted) mt-1 font-medium">{{ optional($book->author)->name }}</p>
                                <span class="inline-block mt-2 px-2 py-0.5 bg-(--color-accent)/10 text-(--color-muted) text-[9px] font-black uppercase tracking-widest rounded-md border border-(--color-border)">
                                    {{ optional($book->category)->name }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2 text-xs text-(--color-muted) font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                {{ number_format($book->views) }} Views
                            </div>
                            <div class="text-xs text-emerald-600 font-bold flex items-center gap-2 uppercase tracking-wide">
                                {{ $book->status }}
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="h-2 w-16 bg-(--color-border) rounded-full overflow-hidden">
                                <div class="h-full bg-(--color-primary) transition-all" style="width: {{ min(($book->stock / 20) * 100, 100) }}%"></div>
                            </div>
                            <span class="text-sm font-black text-(--color-text)">{{ $book->stock }} <span class="text-(--color-muted) text-xs font-medium">left</span></span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="font-black text-(--color-text) text-lg">${{ number_format($book->price, 2) }}</div>
                        @if($book->original_price)
                            <div class="text-xs text-(--color-muted) line-through font-medium">${{ number_format($book->original_price, 2) }}</div>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('seller.books.edit', $book) }}" class="p-2 inline-flex items-center justify-center bg-(--color-surface) border border-(--color-border) rounded-xl text-(--color-muted) hover:text-(--color-primary) hover:border-(--color-primary)/30 transition-all shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="{{ route('seller.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Archive this listing?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 inline-flex items-center justify-center bg-(--color-surface) border border-(--color-border) rounded-xl text-(--color-muted) hover:text-red-500 hover:border-red-200 transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center">
                        <div class="max-w-sm mx-auto space-y-4">
                            <div class="p-4 bg-(--color-accent)/10 rounded-full w-20 h-20 flex items-center justify-center mx-auto text-(--color-muted)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                            </div>
                            <h3 class="text-xl font-serif">Store is Empty</h3>
                            <p class="text-(--color-muted) font-medium">You haven't listed any books yet. Start your journey as a seller today.</p>
                            <a href="{{ route('seller.books.create') }}" class="inline-block bg-(--color-primary)/10 text-(--color-primary) px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-(--color-primary) hover:text-white transition-all">List First Book</a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $books->links() }}
</div>
@endsection
