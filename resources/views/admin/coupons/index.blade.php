@extends('layouts.app')

@section('content')
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-serif mb-2">Coupon <span class="text-(--color-primary)">Management</span></h1>
            <p class="text-(--color-muted) font-medium">Create and manage discount codes for the platform.</p>
        </div>
        
        <div class="flex items-center gap-4">
            <span class="text-xs font-black uppercase tracking-widest text-(--color-muted) bg-(--color-bg) px-4 py-2 rounded-full border border-(--color-border)">
                {{ $coupons->total() }} Total Coupons
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8">
            <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) overflow-hidden shadow-sm">
                <div class="overflow-x-auto hidden md:block">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-(--color-bg)/50 border-b border-(--color-border)">
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Code / Type</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Value</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Usage</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Status</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted) text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-(--color-border)">
                            @forelse($coupons as $coupon)
                                <tr class="hover:bg-(--color-bg)/30 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="font-bold text-(--color-text)">{{ $coupon->code }}</div>
                                        <div class="text-[10px] uppercase font-black tracking-widest text-(--color-muted)">{{ $coupon->type }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm font-bold text-(--color-text)">
                                            @if($coupon->type === 'percent')
                                                {{ (float)$coupon->value }}%
                                            @else
                                                ${{ number_format($coupon->value, 2) }}
                                            @endif
                                        </div>
                                        <div class="text-[10px] text-(--color-muted)">Min: ${{ number_format($coupon->min_order_amount, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm font-medium text-(--color-text)">{{ $coupon->used_count }} / {{ $coupon->use_limit ?? '∞' }}</div>
                                        @if($coupon->expires_at)
                                            <div class="text-[10px] text-(--color-muted)">Exp: {{ $coupon->expires_at->format('M d, Y') }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $coupon->is_active ? 'bg-green-500/10 text-green-700 border-green-500/20' : 'bg-red-500/10 text-red-700 border-red-500/20' }}">
                                            {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="is_active" value="{{ $coupon->is_active ? 0 : 1 }}">
                                                <input type="hidden" name="code" value="{{ $coupon->code }}">
                                                <input type="hidden" name="type" value="{{ $coupon->type }}">
                                                <input type="hidden" name="value" value="{{ $coupon->value }}">
                                                <input type="hidden" name="min_order_amount" value="{{ $coupon->min_order_amount }}">
                                                <button type="submit" class="p-2 bg-(--color-bg) rounded-xl hover:bg-(--color-primary) hover:text-white transition-all">
                                                    @if($coupon->is_active)
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg>
                                                    @endif
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Delete this coupon?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 bg-(--color-bg) rounded-xl text-red-600 hover:bg-red-600 hover:text-white transition-all">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-(--color-muted)">No coupons found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden divide-y divide-(--color-border)">
                    @forelse($coupons as $coupon)
                        <div class="p-5 space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-bold text-(--color-text)">{{ $coupon->code }}</div>
                                    <div class="text-[9px] font-black uppercase tracking-widest text-(--color-muted)">{{ $coupon->type }}</div>
                                </div>
                                <span class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $coupon->is_active ? 'bg-green-500/10 text-green-700 border-green-500/20' : 'bg-red-500/10 text-red-700 border-red-500/20' }}">
                                    {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[9px] text-(--color-muted) font-black uppercase tracking-widest mb-1">Value</p>
                                    <p class="text-sm font-bold text-(--color-text)">
                                        @if($coupon->type === 'percent') {{ (float)$coupon->value }}% @else ${{ number_format($coupon->value, 2) }} @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[9px] text-(--color-muted) font-black uppercase tracking-widest mb-1">Used</p>
                                    <p class="text-sm font-bold text-(--color-text)">{{ $coupon->used_count }} / {{ $coupon->use_limit ?? '∞' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-2 pt-2">
                                <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="is_active" value="{{ $coupon->is_active ? 0 : 1 }}">
                                    <input type="hidden" name="code" value="{{ $coupon->code }}">
                                    <input type="hidden" name="type" value="{{ $coupon->type }}">
                                    <input type="hidden" name="value" value="{{ $coupon->value }}">
                                    <input type="hidden" name="min_order_amount" value="{{ $coupon->min_order_amount }}">
                                    <button type="submit" class="px-4 py-2 bg-(--color-bg) rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                                        {{ $coupon->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-(--color-muted)">No coupons found.</div>
                    @endforelse
                </div>
                
                @if($coupons->hasPages())
                    <div class="px-6 py-4 bg-(--color-bg)/50 border-t border-(--color-border)">
                        {{ $coupons->links() }}
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) p-6 md:p-8 shadow-sm">
                <h3 class="text-xl font-serif mb-6 text-(--color-text)">Create <span class="text-(--color-primary)">New Coupon</span></h3>
                
                <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-5 text-left">
                    @csrf
                    <div>
                        <label for="code" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Coupon Code</label>
                        <input type="text" id="code" name="code" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors font-bold uppercase" placeholder="e.g. SUMMER20" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="type" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Type</label>
                            <select id="type" name="type" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors cursor-pointer font-bold">
                                <option value="percent">Percent (%)</option>
                                <option value="fixed">Fixed ($)</option>
                            </select>
                        </div>
                        <div>
                            <label for="value" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Value</label>
                            <input type="number" id="value" name="value" step="0.01" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors font-bold" placeholder="0.00" required>
                        </div>
                    </div>

                    <div>
                        <label for="min_order_amount" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Min. Order Amount ($)</label>
                        <input type="number" id="min_order_amount" name="min_order_amount" step="0.01" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors font-bold" value="0.00" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="starts_at" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Starts At</label>
                            <input type="date" id="starts_at" name="starts_at" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors text-xs font-bold">
                        </div>
                        <div>
                            <label for="expires_at" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Expires At</label>
                            <input type="date" id="expires_at" name="expires_at" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors text-xs font-bold">
                        </div>
                    </div>

                    <div>
                        <label for="use_limit" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Usage Limit (Optional)</label>
                        <input type="number" id="use_limit" name="use_limit" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors font-bold" placeholder="Infinity">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-(--color-text) text-(--color-bg) py-4 rounded-xl font-bold hover:opacity-90 transition-all active:scale-[0.98]">
                            Generate Coupon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
