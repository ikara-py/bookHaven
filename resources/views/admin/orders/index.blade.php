@extends('layouts.app')

@section('content')
    <div class="mb-12 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif mb-2">Order <span class="text-(--color-primary)">Management</span></h1>
            <p class="text-(--color-muted) font-medium">Monitor platform-wide sales and handle fulfillment statuses.</p>
        </div>
        
        <div class="flex items-center gap-4">
            <span class="text-xs font-black uppercase tracking-widest text-(--color-muted) bg-(--color-bg) px-4 py-2 rounded-full border border-(--color-border) shadow-sm">
                {{ $orders->total() }} Total Transactions
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-500/10 border border-green-500/20 text-green-700 rounded-2xl shadow-sm font-medium text-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) shadow-sm">
        <div class="hidden lg:block">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-(--color-bg)/50 border-b border-(--color-border)">
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Reference</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Customer</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Items / Amount</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Status</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted) text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-(--color-border)">
                    @forelse($orders as $order)
                        <tr class="hover:bg-(--color-bg)/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-(--color-text)">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                    <span class="text-[10px] text-(--color-muted) font-black uppercase tracking-tighter">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-(--color-accent)/10 flex items-center justify-center font-bold text-(--color-text) text-xs border border-(--color-border)">
                                        {{ substr($order->user->full_name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-(--color-text)">{{ $order->user->full_name ?? 'Deleted User' }}</span>
                                        <span class="text-[10px] text-(--color-muted) font-medium">{{ $order->user->email ?? '---' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-(--color-text)">${{ number_format($order->total_amount, 2) }}</span>
                                    <span class="text-[10px] text-(--color-muted) font-black uppercase tracking-widest">{{ $order->items->count() }} items</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-500/10 text-amber-700 border-amber-500/20',
                                        'paid' => 'bg-green-500/10 text-green-700 border-green-500/20',
                                        'completed' => 'bg-blue-500/10 text-blue-700 border-blue-500/20',
                                        'cancelled' => 'bg-red-500/10 text-red-700 border-red-500/20',
                                    ];
                                    $class = $statusClasses[$order->status] ?? 'bg-gray-500/10 text-gray-700 border-gray-500/20';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $class }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="relative inline-block text-left">
                                    <button data-dropdown-toggle="order-dropdown-{{ $order->id }}" class="p-2 hover:bg-(--color-bg) rounded-full transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-muted)"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                    </button>
                                    
                                    <div id="order-dropdown-{{ $order->id }}" data-dropdown class="hidden absolute right-0 mt-2 w-56 bg-(--color-surface) border border-(--color-border) rounded-2xl shadow-xl z-50 overflow-hidden">
                                        <div class="p-4 border-b border-(--color-border) bg-(--color-bg)/50 text-left">
                                            <p class="text-[10px] font-black uppercase text-(--color-muted) tracking-widest">Update Order Status</p>
                                        </div>
                                        <div class="p-4">
                                            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="space-y-3">
                                                @csrf @method('PATCH')
                                                <select name="status" class="w-full text-xs font-bold bg-(--color-bg) border border-(--color-border) rounded-xl px-3 py-2.5 outline-none appearance-none cursor-pointer">
                                                    @foreach(['pending', 'paid', 'completed', 'cancelled'] as $status)
                                                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                                            {{ strtoupper($status) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="w-full bg-(--color-text) text-(--color-bg) text-[10px] font-black uppercase tracking-widest py-2.5 rounded-xl hover:opacity-90 transition-all">Apply Change</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-(--color-muted)">No transactions recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="lg:hidden divide-y divide-(--color-border)">
            @forelse($orders as $order)
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[10px] font-black uppercase text-(--color-muted) tracking-widest">Reference</span>
                            <h4 class="font-black text-(--color-text)">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h4>
                            <p class="text-[10px] text-(--color-muted) font-medium">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="relative">
                            <button data-dropdown-toggle="order-dropdown-mobile-{{ $order->id }}" class="p-2 bg-(--color-bg) rounded-xl border border-(--color-border)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-text)"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                            </button>
                            <div id="order-dropdown-mobile-{{ $order->id }}" data-dropdown class="hidden absolute right-0 mt-2 w-64 bg-(--color-surface) border border-(--color-border) rounded-2xl shadow-2xl z-50 p-4">
                                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="space-y-3">
                                    @csrf @method('PATCH')
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-(--color-muted) mb-1">Update Status</label>
                                    <select name="status" class="w-full text-xs font-bold bg-(--color-bg) border border-(--color-border) rounded-xl px-3 py-3 outline-none">
                                        @foreach(['pending', 'paid', 'completed', 'cancelled'] as $status)
                                            <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ strtoupper($status) }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="w-full bg-(--color-primary) text-white text-[10px] font-black uppercase py-3 rounded-xl shadow-lg">Confirm Status Change</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3 py-3 bg-(--color-bg)/50 rounded-2xl px-4 border border-(--color-border)/30">
                        <div class="w-8 h-8 rounded-full bg-(--color-accent)/30 flex items-center justify-center font-bold text-xs border border-(--color-border)">{{ substr($order->user->full_name ?? 'U', 0, 1) }}</div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-(--color-text)">{{ $order->user->full_name ?? 'Deleted User' }}</span>
                            <span class="text-[10px] text-(--color-muted)">{{ $order->user->email ?? '---' }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-end pt-2">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black uppercase text-(--color-muted) mb-1 italic">Payment</span>
                            <span class="text-lg font-black text-(--color-text)">${{ number_format($order->total_amount, 2) }}</span>
                            <span class="text-[10px] font-bold text-(--color-primary)">{{ $order->items->count() }} items</span>
                        </div>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-amber-500/10 text-amber-700 border-amber-500/20',
                                'paid' => 'bg-green-500/10 text-green-700 border-green-500/20',
                                'completed' => 'bg-blue-500/10 text-blue-700 border-blue-500/20',
                                'cancelled' => 'bg-red-500/10 text-red-700 border-red-500/20',
                            ];
                            $class = $statusClasses[$order->status] ?? 'bg-gray-500/10 text-gray-700 border-gray-500/20';
                        @endphp
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $class }}">{{ $order->status }}</span>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-(--color-muted)">No orders found.</div>
            @endforelse
        </div>
    </div>
        
        @if($orders->hasPages())
            <div class="px-6 py-4 bg-(--color-bg) border-t border-(--color-border)">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
