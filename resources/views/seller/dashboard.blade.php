@extends('layouts.app')

@section('content')
<div class="mb-8 md:mb-12 px-1">
    <h1 class="text-2xl md:text-4xl font-serif mb-4 leading-tight">
        <span class="text-(--color-primary)">{{ auth()->user()->sellerProfile?->store_name ?? 'Seller' }}</span> 
        <span class="block md:inline-block w-fit text-[10px] font-black uppercase tracking-widest bg-(--color-accent)/20 text-(--color-muted) px-3 py-1 rounded-full mt-2 md:mt-0 md:ml-4 md:align-middle">Store Dashboard</span>
    </h1>
    <p class="text-(--color-muted) font-medium text-sm md:text-base">Welcome back! Manage your inventory, track sales, and grow your bookstore.</p>
</div>

@if(!auth()->user()->sellerProfile?->is_approved)
<div class="mb-8 md:mb-12 p-4 md:p-6 bg-amber-500/10 border border-amber-500/20 rounded-3xl flex items-center gap-4 text-amber-600 shadow-sm">
    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    </div>
    <div>
        <p class="font-bold text-sm">Account Verification Pending</p>
        <p class="text-xs opacity-80">Your bookstore profile is currently being reviewed by our administration team. You will be able to publish new listings once approved!</p>
    </div>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8 mb-8 md:mb-12">
    <div class="bg-(--color-surface) p-6 md:p-8 rounded-3xl border border-(--color-border) hover-lift shadow-sm">
        <div class="flex items-center gap-4 md:gap-5 mb-3 md:mb-5">
            <div class="p-2.5 md:p-3 bg-(--color-primary)/10 text-(--color-primary) rounded-2xl shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="md:w-6 md:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M8 7h6"/><path d="M8 11h8"/></svg>
            </div>
            <h3 class="text-[10px] md:text-xs font-black uppercase tracking-widest text-(--color-muted)">Total Books</h3>
        </div>
        <div class="text-2xl md:text-4xl font-black text-(--color-text)">{{ number_format($stats['total_books']) }}</div>
    </div>

    <div class="bg-(--color-surface) p-6 md:p-8 rounded-3xl border border-(--color-border) hover-lift shadow-sm">
        <div class="flex items-center gap-4 md:gap-5 mb-3 md:mb-5">
            <div class="p-2.5 md:p-3 bg-amber-500/10 text-amber-500 rounded-2xl shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="md:w-6 md:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <h3 class="text-[10px] md:text-xs font-black uppercase tracking-widest text-(--color-muted)">Pending</h3>
        </div>
        <div class="text-2xl md:text-4xl font-black text-(--color-text)">{{ number_format($stats['pending_orders']) }}</div>
    </div>

    <div class="bg-(--color-surface) p-6 md:p-8 rounded-3xl border border-(--color-border) hover-lift shadow-sm">
        <div class="flex items-center gap-4 md:gap-5 mb-3 md:mb-5">
            <div class="p-2.5 md:p-3 bg-emerald-500/10 text-emerald-500 rounded-2xl shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="md:w-6 md:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <h3 class="text-[10px] md:text-xs font-black uppercase tracking-widest text-(--color-muted)">Earnings</h3>
        </div>
        <div class="text-2xl md:text-4xl font-black text-(--color-text)">${{ number_format($stats['total_earnings'], 2) }}</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <div class="lg:col-span-2">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-serif">Recent <span class="text-(--color-primary)">Sales</span></h2>
            <a href="{{ route('seller.orders.index') }}" class="text-sm font-bold text-(--color-primary) hover:underline">View all orders</a>
        </div>

        <div class="bg-(--color-surface) border border-(--color-border) rounded-3xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr class="bg-(--color-accent)/10">
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Book</th>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Buyer</th>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Amount</th>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-(--color-border)">
                        @forelse ($stats['recent_sales'] as $sale)
                            <tr class="hover:bg-(--color-accent)/5 transition-colors text-sm">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-(--color-text)">{{ optional($sale->book)->title }}</div>
                                    <div class="text-xs text-(--color-muted)">Qty: {{ $sale->quantity }}</div>
                                </td>
                                <td class="px-6 py-4 font-medium">
                                    {{ optional(optional($sale->order)->user)->full_name ?? 'Guest User' }}
                                </td>
                                <td class="px-6 py-4 font-bold text-(--color-text)">
                                    ${{ number_format($sale->price * $sale->quantity, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'completed' => 'bg-emerald-100 text-emerald-700',
                                            'pending' => 'bg-amber-100 text-amber-700'
                                        ][$sale->status] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $statusClasses }}">
                                        {{ $sale->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-(--color-muted) font-medium">No sales recorded yet. Start listing books!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-2xl font-serif mb-8">Store <span class="text-(--color-primary)">Shortcuts</span></h3>
        <div class="space-y-4">
            @if(auth()->user()->sellerProfile?->is_approved)
                <a href="{{ route('seller.books.create') }}" class="group block p-6 bg-(--color-charcoal) text-white rounded-3xl hover:bg-black transition-all shadow-xl">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-lg">List New Book</h4>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </div>
                    <p class="text-sm text-gray-400">Add a collection to your store.</p>
                </a>
            @else
                <div class="p-6 bg-(--color-bg) border border-(--color-border) rounded-3xl opacity-60 cursor-not-allowed">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-lg text-(--color-muted)">List New Book</h4>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-muted)"><path d="M12 1a10 10 0 1 0 10 10A10 10 0 0 0 12 1zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"/><path d="M12 7a1 1 0 0 1 1 1v4a1 1 0 0 1-2 0V8a1 1 0 0 1 1-1z"/><circle cx="12" cy="16" r="1"/></svg>
                    </div>
                    <p class="text-xs text-(--color-muted)">Available after admin approval.</p>
                </div>
            @endif

            <a href="{{ route('seller.books.index') }}" class="group block p-6 bg-(--color-surface) border border-(--color-border) rounded-3xl hover:border-(--color-primary)/30 transition-all shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-bold text-lg">Inventory Management</h4>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <p class="text-sm text-(--color-muted)">Update prices and stock.</p>
            </a>
        </div>
    </div>
</div>
@endsection
