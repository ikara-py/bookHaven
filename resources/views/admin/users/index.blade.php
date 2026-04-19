@extends('layouts.app')

@section('content')
    <div class="mb-12 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif mb-2">User <span class="text-(--color-primary)">Management</span></h1>
            <p class="text-(--color-muted) font-medium">Control roles, permissions, and verify seller accounts.</p>
        </div>
        
        <div class="flex flex-col md:flex-row items-center gap-4">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center w-full max-w-lg bg-(--color-surface) border border-(--color-border) rounded-2xl pl-4 pr-1.5 py-1.5 hover:border-(--color-primary)/50 focus-within:border-(--color-primary) transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-(--color-muted) ml-2" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search name, email or role..." 
                    value="{{ request('search') }}"
                    class="w-full px-4 py-1 text-sm bg-transparent outline-none placeholder-(--color-muted) text-(--color-text)"
                >
                @if(request('search'))
                    <a href="{{ route('admin.users.index') }}" class="mr-3 text-(--color-muted) hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </a>
                @endif
                <button type="submit" class="bg-(--color-text) text-(--color-bg) text-[10px] font-black uppercase tracking-widest px-6 py-2.5 rounded-xl hover:opacity-90 transition-all active:scale-[0.95]">Search</button>
            </form>

            <span class="text-xs font-black uppercase tracking-widest text-(--color-text) bg-(--color-bg) px-4 py-2 rounded-full border border-(--color-border) shadow-sm">
                {{ $users->total() }} Total Users
            </span>
        </div>
    </div>

    <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) overflow-hidden shadow-sm">
        <div class="hidden md:block">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-(--color-bg)/50 border-b border-(--color-border)">
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">User Informaiton</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Role & Status</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Seller Profile</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted) text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-(--color-border)">
                    @foreach($users as $user)
                        <tr class="hover:bg-(--color-bg)/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-(--color-accent)/10 rounded-full flex items-center justify-center font-bold text-(--color-text) border border-(--color-border)">
                                        {{ substr($user->full_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-(--color-text)">{{ $user->full_name }}</p>
                                        <p class="text-xs text-(--color-muted) font-medium">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-[10px] font-black uppercase tracking-widest bg-(--color-bg) px-3 py-1 rounded-full border border-(--color-border)">{{ $user->role }}</span>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $user->status == 'active' ? 'bg-green-500/10 text-green-700 border-green-500/20' : 'bg-red-500/10 text-red-700 border-red-500/20' }}">
                                        {{ $user->status }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->sellerProfile)
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold">{{ $user->sellerProfile->store_name }}</span>
                                        @if($user->sellerProfile->is_approved)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                                        @else
                                            <span class="text-[9px] font-black uppercase tracking-widest bg-orange-500/10 text-orange-600 px-2 py-0.5 rounded border border-orange-500/20">Pending</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-(--color-muted) italic">No profile</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="relative inline-block text-left">
                                    <button data-dropdown-toggle="user-dropdown-{{ $user->id }}" class="p-2 hover:bg-(--color-bg) rounded-full transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-muted)"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                    </button>
                                    
                                    <div id="user-dropdown-{{ $user->id }}" data-dropdown class="hidden absolute right-0 mt-2 w-56 bg-(--color-surface) border border-(--color-border) rounded-2xl shadow-xl z-50 overflow-hidden">
                                        <div class="p-4 border-b border-(--color-border) bg-(--color-bg)/50">
                                            <p class="text-[10px] font-black uppercase text-(--color-muted) tracking-widest">Update Permissions</p>
                                        </div>
                                        <div class="p-4 space-y-4">
                                            <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <label class="block text-[10px] font-bold uppercase mb-1.5 opacity-60">System Role</label>
                                                <select name="role" onchange="this.form.submit()" class="w-full text-xs font-bold bg-(--color-bg) p-2.5 rounded-xl border border-(--color-border) outline-none appearance-none cursor-pointer">
                                                    <option value="buyer" {{ $user->role == 'buyer' ? 'selected' : '' }}>Buyer</option>
                                                    <option value="seller" {{ $user->role == 'seller' ? 'selected' : '' }}>Seller</option>
                                                    <option value="buyer_seller" {{ $user->role == 'buyer_seller' ? 'selected' : '' }}>Buyer/Seller</option>
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </form>
                                            
                                            <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <label class="block text-[10px] font-bold uppercase mb-1.5 opacity-60">Account Status</label>
                                                <select name="status" onchange="this.form.submit()" class="w-full text-xs font-bold bg-(--color-bg) p-2.5 rounded-xl border border-(--color-border) outline-none appearance-none cursor-pointer">
                                                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                                </select>
                                            </form>

                                            @if(in_array($user->role, ['seller', 'buyer_seller']) && (!$user->sellerProfile || !$user->sellerProfile->is_approved))
                                                <form action="{{ route('admin.users.approveSeller', $user->id) }}" method="POST" class="pt-2 border-t border-(--color-border)">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="w-full text-xs font-black uppercase tracking-widest text-(--color-primary) py-2 hover:bg-(--color-primary)/5 rounded-xl transition-all">Approve Seller</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="md:hidden divide-y divide-(--color-border)">
            @foreach($users as $user)
                <div class="p-5 space-y-4 hover:bg-(--color-bg)/10 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-(--color-text) text-(--color-bg) rounded-full flex items-center justify-center font-bold text-sm shadow-sm">
                                {{ substr($user->full_name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-(--color-text) text-sm leading-tight truncate">{{ $user->full_name }}</p>
                                <p class="text-[10px] text-(--color-muted) font-medium truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <button data-dropdown-toggle="user-dropdown-mobile-{{ $user->id }}" class="p-2 hover:bg-(--color-bg) rounded-xl transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-muted)"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                            </button>
                            <div id="user-dropdown-mobile-{{ $user->id }}" data-dropdown class="hidden absolute right-0 mt-2 w-64 bg-(--color-surface) border border-(--color-border) rounded-2xl shadow-2xl z-50 p-4 space-y-4">
                                <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-(--color-muted) mb-2">Change Role</label>
                                    <select name="role" onchange="this.form.submit()" class="w-full text-xs font-bold bg-(--color-bg) p-3 rounded-xl border border-(--color-border) outline-none">
                                        <option value="buyer" {{ $user->role == 'buyer' ? 'selected' : '' }}>Buyer</option>
                                        <option value="seller" {{ $user->role == 'seller' ? 'selected' : '' }}>Seller</option>
                                        <option value="buyer_seller" {{ $user->role == 'buyer_seller' ? 'selected' : '' }}>Buyer/Seller</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                                <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-(--color-muted) mb-2">Change Status</label>
                                    <select name="status" onchange="this.form.submit()" class="w-full text-xs font-bold bg-(--color-bg) p-3 rounded-xl border border-(--color-border) outline-none">
                                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    </select>
                                </form>
                                @if(in_array($user->role, ['seller', 'buyer_seller']) && (!$user->sellerProfile || !$user->sellerProfile->is_approved))
                                    <form action="{{ route('admin.users.approveSeller', $user->id) }}" method="POST" class="pt-4 border-t border-(--color-border)">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-full bg-(--color-primary) text-white text-[10px] font-black uppercase tracking-widest py-3 rounded-xl shadow-lg">Approve Seller Profile</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <span class="text-[9px] font-black uppercase tracking-widest px-2.5 py-1 bg-(--color-bg) border border-(--color-border) rounded-lg text-(--color-text)">
                            {{ $user->role }}
                        </span>
                        <span class="text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg border {{ $user->status == 'active' ? 'bg-green-500/10 text-green-700 border-green-500/20' : 'bg-red-500/10 text-red-700 border-red-500/20' }}">
                            {{ $user->status }}
                        </span>
                        @if($user->sellerProfile)
                            <span class="text-[9px] font-bold text-(--color-muted) ml-auto truncate max-w-[100px]">
                                {{ $user->sellerProfile->store_name }}
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
        
        @if($users->hasPages())
            <div class="px-6 py-4 bg-(--color-bg) border-t border-(--color-border)">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
