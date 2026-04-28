@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-12">
        <h1 class="text-4xl font-serif mb-4 leading-tight">My <span class="text-(--color-primary)">Profile</span></h1>
        <p class="text-(--color-muted) font-medium">Manage your personal information and account security.</p>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 rounded-2xl flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PATCH')

        <!-- Basic Information -->
        <section class="bg-(--color-surface) p-8 rounded-3xl border border-(--color-border) shadow-sm">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-primary)"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Account Details
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" 
                           class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all">
                    @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                           class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Gender</label>
                    <select name="gender" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all">
                        <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" 
                           class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all">
                    @error('date_of_birth') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Bio / About You</label>
                    <textarea name="bio" rows="3" 
                              class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        <!-- Location Information -->
        <section class="bg-(--color-surface) p-8 rounded-3xl border border-(--color-border) shadow-sm">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-primary)"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                Location & Contact
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">City</label>
                    <input type="text" name="city" value="{{ old('city', $user->city) }}" 
                           class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Country</label>
                    <input type="text" name="country" value="{{ old('country', $user->country) }}" 
                           class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Full Address</label>
                    <textarea name="address" rows="2" 
                              class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all">{{ old('address', $user->address) }}</textarea>
                </div>
            </div>
        </section>

        @if($user->isSeller() && $user->sellerProfile)
        <!-- Store Settings (Sellers Only) -->
        <section class="bg-(--color-charcoal) text-white p-8 rounded-3xl border border-white/10 shadow-xl overflow-hidden relative">
            <div class="relative z-10">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-primary)"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="m3 9 2.45-4.91A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.79 1.09L21 9"/><path d="M12 3v6"/></svg>
                    Bookstore Branding
                </h2>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-white/40 mb-2">Store Name</label>
                        <input type="text" name="store_name" value="{{ old('store_name', $user->sellerProfile->store_name) }}" 
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all text-white">
                        @error('store_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-white/40 mb-2">Store Description</label>
                        <textarea name="store_description" rows="3" 
                                  class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all text-white">{{ old('store_description', $user->sellerProfile->store_description) }}</textarea>
                        @error('store_description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            <!-- Decorative circle -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-(--color-primary)/20 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2"></div>
        </section>
        @endif

        <!-- Security -->
        <section class="bg-(--color-surface) p-8 rounded-3xl border border-(--color-border) shadow-sm">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-primary)"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
                Account Security
            </h2>
            <p class="text-xs text-(--color-muted) mb-6">Leave blank if you do not want to change your password.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">New Password</label>
                    <input type="password" name="password" 
                           class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" 
                           class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 focus:outline-none focus:border-(--color-primary) transition-all">
                </div>
            </div>
        </section>

        <div class="flex items-center justify-end gap-4 pb-12">
            <a href="{{ url()->previous() }}" class="px-8 py-3 rounded-xl font-bold text-(--color-muted) hover:text-(--color-text) transition-colors">Cancel</a>
            <button type="submit" class="bg-(--color-primary) text-white px-10 py-4 rounded-full font-black uppercase tracking-widest text-xs hover:shadow-xl transition-all hover:-translate-y-0.5 active:scale-95 shadow-lg shadow-(--color-primary)/25">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
