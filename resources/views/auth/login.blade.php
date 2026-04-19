@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="w-full max-w-md bg-(--color-surface) border border-(--color-border) rounded-2xl p-8 shadow-sm">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-serif mb-2 text-(--color-text) tracking-tight">Welcome Back</h1>
            <p class="text-sm text-(--color-muted)">Please enter your details to sign in.</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-sm text-red-600">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[var(--color-muted)] mb-2 ml-1">Email Address</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email') }}"
                    required 
                    class="w-full px-4 py-3 bg-[var(--color-bg)] border border-[var(--color-border)] rounded-xl outline-none focus:border-[var(--color-primary)] transition-all placeholder:text-[var(--color-accent)]"
                    placeholder="name@company.com"
                >
            </div>

            <div>
                <div class="flex items-center justify-between mb-2 ml-1">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[var(--color-muted)]">Password</label>
                    <a href="#" class="text-xs font-medium text-[var(--color-primary)] hover:underline">Forgot?</a>
                </div>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    class="w-full px-4 py-3 bg-[var(--color-bg)] border border-[var(--color-border)] rounded-xl outline-none focus:border-[var(--color-primary)] transition-all placeholder:text-[var(--color-accent)]"
                    placeholder="••••••••"
                >
            </div>

            <div class="flex items-center gap-2 ml-1">
                <input type="checkbox" name="remember" id="remember" value="1" class="w-4 h-4 rounded border-[var(--color-border)] text-[var(--color-primary)] focus:ring-[var(--color-primary)]">
                <label for="remember" class="text-sm text-[var(--color-muted)]">Remember me</label>
            </div>

            <button type="submit" class="w-full bg-[var(--color-text)] text-[var(--color-bg)] py-3 rounded-xl font-bold hover:opacity-90 transition-all shadow-lg active:scale-[0.98]">
                Sign In
            </button>
        </form>

        <div class="mt-8 text-center pt-6 border-t border-[var(--color-border)]">
            <p class="text-sm text-[var(--color-muted)]">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-[var(--color-primary)] hover:underline ml-1">Create one now</a>
            </p>
        </div>
    </div>
</div>
@endsection
