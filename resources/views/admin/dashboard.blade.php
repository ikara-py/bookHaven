@extends('layouts.app')

@section('content')
    <div class="mb-8 md:mb-12">
        <h1 class="text-2xl md:text-3xl font-serif mb-2">Platform <span class="text-(--color-primary)">Dashboard</span></h1>
        <p class="text-(--color-muted) font-medium text-sm md:text-base">Real-time overview of your bookstore's ecosystem.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-8 md:mb-12">
        <div class="bg-(--color-surface) p-4 md:p-6 rounded-3xl border border-(--color-border) hover-lift flex flex-col items-center text-center sm:items-start sm:text-left">
            <div class="w-10 h-10 bg-(--color-bg) rounded-xl flex items-center justify-center border border-(--color-border) mb-3 sm:mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-primary)"><path d="M16 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div class="flex flex-col">
                <span class="text-[9px] md:text-xs font-black uppercase tracking-widest text-(--color-muted) mb-1">Users</span>
                <div class="text-xl md:text-3xl font-bold text-(--color-text)">{{ number_format($status['total_users']) }}</div>
            </div>
        </div>

        <div class="bg-(--color-surface) p-4 md:p-6 rounded-3xl border border-(--color-border) hover-lift flex flex-col items-center text-center sm:items-start sm:text-left">
            <div class="w-10 h-10 bg-(--color-bg) rounded-xl flex items-center justify-center border border-(--color-border) mb-3 sm:mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-primary)"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 7h10"/><path d="M7 12h10"/><path d="M7 17h10"/></svg>
            </div>
            <div class="flex flex-col">
                <span class="text-[9px] md:text-xs font-black uppercase tracking-widest text-(--color-muted) mb-1">Books</span>
                <div class="text-xl md:text-3xl font-bold text-(--color-text)">{{ number_format($status['total_books']) }}</div>
            </div>
        </div>

        <div class="bg-(--color-surface) p-4 md:p-6 rounded-3xl border border-(--color-border) hover-lift border-b-4 border-b-(--color-primary) flex flex-col items-center text-center sm:items-start sm:text-left">
            <div class="w-10 h-10 bg-(--color-primary)/5 rounded-xl flex items-center justify-center border border-(--color-primary)/10 mb-3 sm:mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-primary)"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="flex flex-col">
                <span class="text-[9px] md:text-xs font-black uppercase tracking-widest text-(--color-primary) mb-1">Revenue</span>
                <div class="text-xl md:text-3xl font-bold text-(--color-text)">${{ number_format($status['total_revenue'], 2) }}</div>
            </div>
        </div>

        <div class="bg-(--color-surface) p-4 md:p-6 rounded-3xl border border-(--color-border) hover-lift flex flex-col items-center text-center sm:items-start sm:text-left">
            <div class="w-10 h-10 bg-(--color-bg) rounded-xl flex items-center justify-center border border-(--color-border) mb-3 sm:mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-muted)"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
            <div class="flex flex-col">
                <span class="text-[9px] md:text-xs font-black uppercase tracking-widest text-(--color-muted) mb-1">Orders</span>
                <div class="text-xl md:text-3xl font-bold text-(--color-text)">{{ number_format($status['total_orders']) }}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) overflow-hidden h-fit">
            <div class="p-6 border-b border-(--color-border) flex items-center justify-between bg-(--color-bg)/50">
                <h3 class="font-bold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-primary)"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                    Action Items
                </h3>
                <span class="text-[9px] font-black uppercase tracking-widest bg-(--color-primary) text-white px-3 py-1 rounded-full">Alerts</span>
            </div>
            <div class="divide-y divide-(--color-border)">
                <div class="p-6 flex items-center justify-between hover:bg-(--color-bg) transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-(--color-bg) rounded-full flex items-center justify-center text-(--color-primary) font-bold text-lg border border-(--color-border)">
                            {{ $status['pending_sellers'] }}
                        </div>
                        <div>
                            <p class="font-bold text-sm">Pending Sellers</p>
                            <p class="text-[10px] text-(--color-muted) font-medium italic">Profiles awaiting verification.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="text-[10px] font-black uppercase tracking-widest text-(--color-primary) hover:underline pl-4 whitespace-nowrap">Review all</a>
                </div>
                <div class="p-6 flex items-center justify-between hover:bg-(--color-bg) transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-(--color-bg) rounded-full flex items-center justify-center text-(--color-muted) font-bold text-lg border border-(--color-border)">
                            {{ $status['pending_orders'] }}
                        </div>
                        <div>
                            <p class="font-bold text-sm">Pending Orders</p>
                            <p class="text-[10px] text-(--color-muted) font-medium italic">Transactions to be processed.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="text-[10px] font-black uppercase tracking-widest text-(--color-muted) hover:text-(--color-primary) hover:underline pl-4 whitespace-nowrap">Review</a>
                </div>
            </div>
        </div>

        <div class="bg-(--color-charcoal) text-white rounded-3xl p-6 md:p-8 relative overflow-hidden shadow-2xl">
            <div class="relative z-10">
                <h3 class="text-xl md:text-2xl font-serif mb-6">Management <span class="text-(--color-primary)">Shortcuts</span></h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('admin.users.index') }}" class="flex flex-col p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mb-2 text-(--color-primary)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="M19 8v6"/><path d="M22 11h-6"/></svg>
                        <span class="font-bold text-sm">Manage Users</span>
                        <span class="text-[10px] text-white/40 uppercase tracking-widest font-black">All accounts</span>
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="flex flex-col p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mb-2 text-(--color-primary)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                        <span class="font-bold text-sm">Manage Books</span>
                        <span class="text-[10px] text-white/40 uppercase tracking-widest font-black">Full catalog</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex flex-col p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mb-2 text-(--color-primary)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        <span class="font-bold text-sm">Manage Orders</span>
                        <span class="text-[10px] text-white/40 uppercase tracking-widest font-black">Transactions</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex flex-col p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mb-2 text-(--color-primary)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                        <span class="font-bold text-sm">Manage Categories</span>
                        <span class="text-[10px] text-white/40 uppercase tracking-widest font-black">Taxonomy</span>
                    </a>
                    <a href="{{ route('admin.authors.index') }}" class="flex flex-col p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mb-2 text-(--color-primary)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                        <span class="font-bold text-sm">Manage Authors</span>
                        <span class="text-[10px] text-white/40 uppercase tracking-widest font-black">Writers</span>
                    </a>
                    <a href="{{ route('admin.coupons.index') }}" class="flex flex-col p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mb-2 text-(--color-primary)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        <span class="font-bold text-sm">Manage Coupons</span>
                        <span class="text-[10px] text-white/40 uppercase tracking-widest font-black">Discounts</span>
                    </a>
                </div>
            </div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-(--color-primary)/20 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2"></div>
        </div>
    </div>
@endsection
