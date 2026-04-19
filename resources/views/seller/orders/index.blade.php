@extends('layouts.app')

@section('content')
<div class="mb-12 flex items-center justify-between">
    <div>
        <h1 class="text-4xl font-serif mb-4 leading-tight">Manage your <span class="text-(--color-primary)">Orders</span></h1>
        <p class="text-(--color-muted) font-medium italic">Track your sales and fulfill your collection's new journeys.</p>
    </div>
    
    <div class="flex items-center gap-4">
        <a href="{{ route('seller.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-(--color-muted) hover:text-(--color-primary) transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Back to Dashboard
        </a>
    </div>
</div>

<div class="bg-(--color-surface) border border-(--color-border) rounded-[2.5rem] overflow-hidden shadow-2xl shadow-black/5">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-(--color-accent)/10 border-b border-(--color-border)">
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-(--color-muted)">Item Details</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-(--color-muted)">Customer</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-(--color-muted)">Revenue</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-(--color-muted)">Current Status</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-(--color-muted) text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-(--color-border)">
                @forelse ($items as $item)
                    <tr class="group hover:bg-(--color-accent)/5 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-16 rounded-xl overflow-hidden shadow-sm shrink-0 border border-(--color-border)">
                                    <img src="{{ $item->book->cover_url }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-black text-(--color-text) leading-tight mb-1 group-hover:text-(--color-primary) transition-colors">{{ $item->book->title }}</h4>
                                    <div class="inline-flex items-center gap-2 px-2 py-0.5 bg-(--color-accent)/10 rounded-md">
                                        <span class="text-[9px] font-black uppercase text-(--color-muted)">Qty:</span>
                                        <span class="text-[10px] font-bold text-(--color-text)">{{ $item->quantity }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="font-bold text-(--color-text)">{{ $item->order->user->full_name }}</span>
                                <span class="text-xs text-(--color-muted)">{{ $item->order->user->email }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-lg font-black text-(--color-text)">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                <span class="text-[10px] text-(--color-muted) uppercase tracking-tighter">{{ $item->order->created_at->format('M d, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $statusStyles = [
                                    'pending' => 'bg-amber-500/10 text-amber-700 border-amber-500/20',
                                    'shipped' => 'bg-blue-500/10 text-blue-700 border-blue-500/20',
                                    'delivered' => 'bg-emerald-500/10 text-emerald-700 border-emerald-500/20',
                                ][$item->status] ?? 'bg-gray-500/10 text-gray-700 border-gray-500/20';
                            @endphp
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full border {{ $statusStyles }} text-[10px] font-black uppercase tracking-widest shadow-sm">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex justify-end gap-2">
                                <form action="{{ route('seller.orders.status', $item->id) }}" method="POST" class="flex gap-2">
                                    @csrf @method('PATCH')
                                    
                                    @if($item->status === 'pending')
                                        <button name="status" value="shipped" class="px-4 py-2 bg-(--color-charcoal) text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-md active:scale-95">
                                            Mark Shipped
                                        </button>
                                    @elseif($item->status === 'shipped')
                                        <button name="status" value="delivered" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-md active:scale-95">
                                            Mark Delivered
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="mb-4 inline-flex items-center justify-center w-16 h-16 bg-(--color-accent)/10 rounded-full text-(--color-muted)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-1">No orders found</h3>
                            <p class="text-(--color-muted) font-medium italic">Wait for your collection to find its new home.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-12 right-12 bg-emerald-500 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest shadow-2xl flex items-center gap-4 animate-slide-up">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
</div>
@endif

<style>
@keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.animate-slide-up {
    animation: slideUp 0.3s ease-out forwards;
}
</style>
@endsection
