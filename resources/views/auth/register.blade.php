@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-12">
    <div class="w-full max-w-xl bg-(--color-surface) border border-(--color-border) rounded-2xl p-8 shadow-sm">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-serif mb-3 text-(--color-text) tracking-tight">Create Account</h1>
            <p class="text-sm text-(--color-muted) leading-relaxed">Join our community of book lovers and collectors. Start your journey today.</p>
        </div>

        @if($errors->any())
            <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-8" x-data="{ role: 'buyer' }">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="full_name" class="block text-xs font-bold uppercase tracking-wider text-[var(--color-muted)] mb-2 ml-1">Full Name</label>
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required 
                        class="w-full px-4 py-3 bg-[var(--color-bg)] border border-[var(--color-border)] rounded-xl outline-none focus:border-[var(--color-primary)] transition-all"
                        placeholder="John Doe">
                </div>
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[var(--color-muted)] mb-2 ml-1">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                        class="w-full px-4 py-3 bg-[var(--color-bg)] border border-[var(--color-border)] rounded-xl outline-none focus:border-[var(--color-primary)] transition-all"
                        placeholder="john@example.com">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[var(--color-muted)] mb-2 ml-1">Password</label>
                    <input type="password" name="password" id="password" required 
                        class="w-full px-4 py-3 bg-[var(--color-bg)] border border-[var(--color-border)] rounded-xl outline-none focus:border-[var(--color-primary)] transition-all"
                        placeholder="••••••••">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-[var(--color-muted)] mb-2 ml-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                        class="w-full px-4 py-3 bg-[var(--color-bg)] border border-[var(--color-border)] rounded-xl outline-none focus:border-[var(--color-primary)] transition-all"
                        placeholder="••••••••">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--color-muted)] mb-3 ml-1 text-center">I want to...</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="relative flex flex-col items-center p-4 border rounded-xl cursor-pointer transition-all hover:bg-[var(--color-bg)]"
                        :class="role === 'buyer' ? 'border-[var(--color-primary)] bg-[var(--color-bg)]' : 'border-[var(--color-border)]'">
                        <input type="radio" name="role" value="buyer" class="hidden" x-model="role" checked>
                        <span class="text-sm font-bold" :class="role === 'buyer' ? 'text-[var(--color-primary)]' : 'text-[var(--color-text)]'">Buy</span>
                    </label>
                    <label class="relative flex flex-col items-center p-4 border rounded-xl cursor-pointer transition-all hover:bg-[var(--color-bg)]"
                        :class="role === 'seller' ? 'border-[var(--color-primary)] bg-[var(--color-bg)]' : 'border-[var(--color-border)]'">
                        <input type="radio" name="role" value="seller" class="hidden" x-model="role">
                        <span class="text-sm font-bold" :class="role === 'seller' ? 'text-[var(--color-primary)]' : 'text-[var(--color-text)]'">Sell</span>
                    </label>
                    <label class="relative flex flex-col items-center p-4 border rounded-xl cursor-pointer transition-all hover:bg-[var(--color-bg)]"
                        :class="role === 'buyer_seller' ? 'border-[var(--color-primary)] bg-[var(--color-bg)]' : 'border-[var(--color-border)]'">
                        <input type="radio" name="role" value="buyer_seller" class="hidden" x-model="role">
                        <span class="text-sm font-bold" :class="role === 'buyer_seller' ? 'text-[var(--color-primary)]' : 'text-[var(--color-text)]'">Both</span>
                    </label>
                </div>
            </div>

            <div x-show="role !== 'buyer'" x-transition class="space-y-6 pt-4 border-t border-dashed border-[var(--color-border)]">
                <div>
                    <label for="store_name" class="block text-xs font-bold uppercase tracking-wider text-[var(--color-muted)] mb-2 ml-1">Store Name</label>
                    <input type="text" name="store_name" id="store_name" value="{{ old('store_name') }}"
                        :required="role !== 'buyer'"
                        class="w-full px-4 py-3 bg-[var(--color-bg)] border border-[var(--color-border)] rounded-xl outline-none focus:border-[var(--color-primary)] transition-all"
                        placeholder="My Awesome Bookshop">
                </div>
            </div>

            <div>
                <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-[var(--color-muted)] mb-2 ml-1">Phone Number (Optional)</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                    class="w-full px-4 py-3 bg-[var(--color-bg)] border border-[var(--color-border)] rounded-xl outline-none focus:border-[var(--color-primary)] transition-all"
                    placeholder="+1 (555) 000-0000">
            </div>

            <button type="submit" class="w-full bg-[var(--color-text)] text-[var(--color-bg)] py-4 rounded-xl font-bold hover:opacity-90 transition-all shadow-xl active:scale-[0.98]">
                Create My Account
            </button>
        </form>

        <div class="mt-10 text-center pt-8 border-t border-[var(--color-border)]">
            <p class="text-sm text-[var(--color-muted)]">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-[var(--color-primary)] hover:underline ml-1">Sign in here</a>
            </p>
        </div>
    </div>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
