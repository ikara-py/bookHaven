@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="mb-12">
        <h1 class="text-4xl font-serif mb-4 leading-tight">My <span class="text-(--color-primary)">Collections</span> History</h1>
        <p class="text-(--color-muted) max-w-2xl leading-relaxed text-lg">Track your current orders and explore the stories that have joined your library over time.</p>
    </div>

    @if($orders->isEmpty())
        <div class="text-center py-20 bg-(--color-accent)/10 rounded-3xl border-2 border-dashed border-(--color-accent)">
            <div class="w-20 h-20 bg-(--color-accent)/30 rounded-full flex items-center justify-center mx-auto mb-6 text-(--color-muted)">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-2">No orders found</h3>
            <p class="text-(--color-muted) mb-8">You haven't purchased any stories yet.</p>
            <a href="{{ route('books.index') }}" class="bg-(--color-primary) text-white px-8 py-3 rounded-full font-black uppercase tracking-widest text-xs hover:shadow-xl transition-all hover:-translate-y-0.5 shadow-lg shadow-(--color-primary)/25">
                Browse Library
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) p-6 sm:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-(--color-primary)/30 transition-all hover:shadow-xl hover:shadow-black/5">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-(--color-accent)/10 rounded-2xl flex items-center justify-center text-(--color-primary)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-sm font-black text-(--color-text) tracking-tight">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                <span class="px-3 py-0.5 bg-yellow-100 text-yellow-700 text-[10px] font-black uppercase rounded-full tracking-widest">{{ $order->status }}</span>
                            </div>
                            <p class="text-xs text-(--color-muted) font-medium">Placed on {{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('h:i A') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between md:justify-end gap-12 border-t md:border-t-0 border-(--color-border) pt-4 md:pt-0">
                        <div class="text-right">
                            <span class="block text-[10px] font-black uppercase text-(--color-muted) tracking-widest leading-none mb-1">Total Amount</span>
                            <span class="text-xl font-black text-(--color-text)">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <a href="{{ route('orders.show', $order) }}" class="flex items-center gap-2 bg-(--color-text) text-(--color-bg) px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:opacity-90 transition-all shadow-md active:scale-95">
                            View Receipt
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
