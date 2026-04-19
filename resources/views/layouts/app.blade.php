<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Book Haven') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=instrument-sans:400,500,600|playfair-display:700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        // Prevent Flash of Light Mode
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    <style>
        :root {
            --color-primary: #f53003;
            --color-bg: #FDFDFC;
            --color-text: #1b1b18;
            --color-muted: #706f6c;
            --color-border: #19140035;
            --color-accent: #dbdbd7;
            --color-charcoal: #1b1b18;
            --color-surface: #ffffff;
            --color-surface-hover: #f3f4f6;
            --transition-speed: 0.3s;
        }

        .dark {
            --color-bg: #1c1917;
            --color-text: #e7e5e4;
            --color-muted: #a8a29e;
            --color-border: #ffffff15;
            --color-accent: #292524;
            --color-charcoal: #0c0a09;
            --color-surface: #292524;
            --color-surface-hover: #44403c;
        }

        body {
            transition: background-color var(--transition-speed) ease, color var(--transition-speed) ease;
        }

        nav, footer, .card, .bg-(--color-bg) {
            transition: background-color var(--transition-speed) ease, border-color var(--transition-speed) ease;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-(--color-bg) text-(--color-text) font-sans selection:bg-(--color-primary) selection:text-white">
    <div class="min-h-screen flex flex-col">
        <nav class="border-b border-(--color-border) py-4 backdrop-blur-md sticky top-0 bg-(--color-bg)/80 z-50">
            <div class="container mx-auto px-6 flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-2xl font-serif tracking-tight flex items-center gap-2">
                    <span class="text-(--color-primary)">Book</span>Haven
                </a>
                
                <div class="hidden lg:flex items-center gap-8 text-sm font-medium">
                    <a href="{{ route('books.index') }}" class="hover:text-(--color-primary) transition-colors @if(request()->routeIs('books.index')) text-(--color-primary) @endif">Browse</a>
                    <a href="{{ route('categories.index') }}" class="hover:text-(--color-primary) transition-colors @if(request()->routeIs('categories.index')) text-(--color-primary) @endif">Categories</a>
                    <a href="{{ route('authors.index') }}" class="hover:text-(--color-primary) transition-colors @if(request()->routeIs('authors.index')) text-(--color-primary) @endif">Authors</a>
                </div>

                <div class="flex items-center gap-2 md:gap-4">
                    @auth
                        @if(auth()->user()->isSeller())
                            <a href="{{ route('seller.dashboard') }}" class="hidden md:flex items-center gap-2 px-4 py-2 bg-(--color-primary)/10 text-(--color-primary) rounded-xl text-xs font-black uppercase tracking-widest hover:bg-(--color-primary) hover:text-white transition-all shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="mb-0.5"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                                Seller
                            </a>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hidden md:flex items-center gap-2 px-4 py-2 bg-(--color-primary) text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-black transition-all shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="mb-0.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                                Admin
                            </a>
                        @endif

                        @if(!auth()->user()->isAdmin() && !auth()->user()->isSeller())
                            <a href="{{ route('wishlist.index') }}" class="p-2 relative hover:bg-(--color-accent) rounded-lg transition-colors" title="My Favorites">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                            </a>

                            <a href="{{ route('cart.index') }}" class="p-2 relative hover:bg-(--color-accent) rounded-lg transition-colors group/cart" title="Shopping Bag">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                @php $cartCount = auth()->user()->cart?->items->count() ?? 0; @endphp
                                @if($cartCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-black w-4 h-4 flex items-center justify-center rounded-full shadow-sm group-hover/cart:scale-110 transition-transform">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        @endif
                        
                        <div class="hidden md:flex h-8 w-px bg-(--color-border) mx-2"></div>

                        <div class="hidden md:flex items-center gap-4">
                            @if(!auth()->user()->isAdmin())
                                <a href="{{ route('orders.index') }}" class="text-xs font-black uppercase tracking-widest text-(--color-text) hover:text-(--color-primary) transition-colors @if(request()->routeIs('orders.index')) text-(--color-primary) @endif">My Orders</a>
                            @endif
                            <button id="theme-toggle" class="p-2 text-(--color-text) hover:bg-(--color-accent) rounded-lg transition-colors" title="Toggle Theme">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="theme-icon-light hidden"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M22 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="theme-icon-dark hidden"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                            </button>
                            <a href="{{ route('profile.edit') }}" class="text-xs font-black uppercase tracking-widest text-(--color-text) hover:text-(--color-primary) transition-colors">Profile</a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs font-black uppercase tracking-widest text-red-600 hover:text-red-700 transition-colors">Sign Out</button>
                            </form>
                        </div>
                    @else
                        <button id="theme-toggle-guest" class="p-2 text-(--color-text) hover:bg-(--color-accent) rounded-lg transition-colors mr-2" title="Toggle Theme">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="theme-icon-light hidden"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M22 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="theme-icon-dark hidden"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                        </button>
                        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-(--color-primary) pr-2">Log in</a>
                        <a href="{{ route('register') }}" class="bg-(--color-text) text-(--color-bg) px-5 py-2 rounded-lg text-sm font-medium hover:opacity-90 transition-all">Join</a>
                    @endauth

                    {{-- Mobile Menu Toggle --}}
                    <button id="mobile-menu-toggle" class="lg:hidden p-2 text-(--color-text) hover:bg-(--color-accent) rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="menu-icon"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="close-icon hidden"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu Container --}}
            <div id="mobile-menu" class="hidden lg:hidden border-t border-(--color-border) bg-(--color-bg) absolute w-full left-0 shadow-xl z-40 animate-slide-down">
                <div class="px-6 py-8 space-y-6">
                    <div class="grid grid-cols-1 gap-4 text-center">
                        <a href="{{ route('books.index') }}" class="text-lg font-bold py-3 hover:bg-(--color-accent)/20 rounded-2xl transition-all">Browse Library</a>
                        <a href="{{ route('categories.index') }}" class="text-lg font-bold py-3 hover:bg-(--color-accent)/20 rounded-2xl transition-all">Categories</a>
                        <a href="{{ route('authors.index') }}" class="text-lg font-bold py-3 hover:bg-(--color-accent)/20 rounded-2xl transition-all">Authors</a>
                    </div>
                    
                    <div class="h-px bg-(--color-border) w-full"></div>

                    <div class="flex flex-col gap-4">
                        @auth
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-6 py-4 bg-(--color-surface) border border-(--color-border) rounded-2xl font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                My Account
                            </a>
                            @if(!auth()->user()->isAdmin())
                                <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-6 py-4 bg-(--color-surface) border border-(--color-border) rounded-2xl font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                    My Orders
                                </a>
                            @endif
                            @if(auth()->user()->isSeller())
                                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-6 py-4 bg-(--color-primary)/10 text-(--color-primary) rounded-2xl font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                                    Seller Dashboard
                                </a>
                            @endif
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-6 py-4 bg-(--color-primary) text-white rounded-2xl font-bold uppercase tracking-widest text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                                    Management Panel
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-center py-3 text-red-600 font-bold uppercase tracking-widest text-xs">Sign Out</button>
                            </form>
                        @else
                            <div class="grid grid-cols-2 gap-4 pt-4">
                                <a href="{{ route('login') }}" class="py-4 text-center border border-(--color-border) rounded-2xl font-bold">Log In</a>
                                <a href="{{ route('register') }}" class="py-4 text-center bg-(--color-text) text-(--color-bg) rounded-2xl font-bold">Register</a>
                            </div>
                        @endauth
                        
                        <button id="theme-toggle-mobile" class="flex items-center justify-center gap-3 w-full py-4 mt-2 bg-(--color-surface) border border-(--color-border) rounded-2xl font-bold transition-all">
                            <span class="theme-text">Switch to Dark Mode</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="theme-icon-light hidden"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M22 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="theme-icon-dark hidden"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main class="grow container mx-auto px-4 md:px-6 py-8 md:py-12">
            @yield('content')
        </main>

        <!-- Premium Footer -->
        <footer class="bg-(--color-charcoal) text-white pt-16 pb-8 mt-12 md:mt-24">
            <div class="container mx-auto px-4 md:px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-12 mb-16">
                    <!-- Brand Section -->
                    <div class="lg:col-span-2 space-y-6">
                        <a href="{{ route('home') }}" class="text-2xl font-serif text-white tracking-tight flex items-center gap-2">
                            <span class="text-(--color-primary)">Book</span> Haven
                        </a>
                        <p class="text-white/60 text-sm max-w-sm leading-relaxed">
                            A platform built with passion for book lovers by book lovers. We believe every book deserves a home and every reader deserves a haven.
                        </p>
                        <div class="pt-2">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/30 block mb-3">Lead Developer</span>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center font-bold text-(--color-primary)">AK</div>
                                <div>
                                    <p class="font-bold text-white leading-tight">Ali Kara</p>
                                    <p class="text-xs text-white/40 italic">"Turning complex ideas into digital realities."</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Platform Links -->
                    <div class="space-y-6">
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] text-(--color-primary)">Platform</h4>
                        <ul class="space-y-4 text-sm font-medium text-white/60">
                            <li><a href="{{ route('books.index') }}" class="hover:text-white transition-colors">Browse Library</a></li>
                            <li><a href="{{ route('categories.index') }}" class="hover:text-white transition-colors">Categories</a></li>
                            <li><a href="{{ route('authors.index') }}" class="hover:text-white transition-colors">Authors List</a></li>
                            @guest
                                <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Seller Portal</a></li>
                            @else
                                @if(auth()->user()->isSeller())
                                    <li><a href="{{ route('seller.dashboard') }}" class="hover:text-white transition-colors">Seller Dashboard</a></li>
                                @elseif(auth()->user()->isAdmin())
                                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Admin Dashboard</a></li>
                                @endif
                            @endguest
                        </ul>
                    </div>

                    <!-- Connect Section -->
                    <div class="space-y-6">
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] text-(--color-primary)">Connect</h4>
                        <div class="flex flex-col gap-4">
                            <a href="mailto:ali16kara@gmail.com" class="flex items-center gap-3 text-sm font-medium text-white/60 hover:text-white transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-(--color-primary)/20 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                </div>
                                Email
                            </a>
                            <a href="https://github.com/ikara-py" target="_blank" class="flex items-center gap-3 text-sm font-medium text-white/60 hover:text-white transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-(--color-primary)/20 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.28 1.15-.28 2.35 0 3.5-.73 1.02-1.08 2.25-1 3.5 0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/></svg>
                                </div>
                                GitHub
                            </a>
                            <a href="https://www.linkedin.com/in/ikara-py/" target="_blank" class="flex items-center gap-3 text-sm font-medium text-white/60 hover:text-white transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-(--color-primary)/20 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                                </div>
                                LinkedIn
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/20">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </p>
                    <div class="flex items-center gap-2 text-white/50 text-[10px] uppercase font-black tracking-widest">
                        <span>Designed & Developed by</span>
                        <a href="https://github.com/ikara-py" class="text-white hover:text-(--color-primary) transition-colors">Ali Kara</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('mobile-menu-toggle');
            const menu = document.getElementById('mobile-menu');
            const menuIcon = toggle.querySelector('.menu-icon');
            const closeIcon = toggle.querySelector('.close-icon');

            if (toggle) {
                toggle.addEventListener('click', function() {
                    const isHidden = menu.classList.contains('hidden');
                    
                    if (isHidden) {
                        menu.classList.remove('hidden');
                        menuIcon.classList.add('hidden');
                        closeIcon.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    } else {
                        menu.classList.add('hidden');
                        menuIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                        document.body.style.overflow = '';
                    }
                });
            }

            // Global Dropdown Handler
            document.addEventListener('click', function(e) {
                // Dropdown Toggle
                const toggle = e.target.closest('[data-dropdown-toggle]');
                if (toggle) {
                    const dropdownId = toggle.getAttribute('data-dropdown-toggle');
                    const dropdown = document.getElementById(dropdownId);
                    
                    // Close all other dropdowns
                    document.querySelectorAll('[data-dropdown]').forEach(d => {
                        if (d.id !== dropdownId) d.classList.add('hidden');
                    });

                    dropdown.classList.toggle('hidden');
                    return;
                }

                // Close dropdowns when clicking outside
                if (!e.target.closest('[data-dropdown]') && !e.target.closest('[data-dropdown-toggle]')) {
                    document.querySelectorAll('[data-dropdown]').forEach(d => d.classList.add('hidden'));
                }
            });

            // Close menu on resize to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024 && menu) {
                    menu.classList.add('hidden');
                    menuIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });

            // Theme Toggle Logic
            const themeToggles = ['theme-toggle', 'theme-toggle-guest', 'theme-toggle-mobile'];
            const updateThemeIcons = () => {
                const isDark = document.documentElement.classList.contains('dark');
                document.querySelectorAll('.theme-icon-light').forEach(el => isDark ? el.classList.remove('hidden') : el.classList.add('hidden'));
                document.querySelectorAll('.theme-icon-dark').forEach(el => isDark ? el.classList.add('hidden') : el.classList.remove('hidden'));
                
                const themeText = document.querySelector('#theme-toggle-mobile .theme-text');
                if (themeText) themeText.textContent = isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode';
            };

            themeToggles.forEach(id => {
                const btn = document.getElementById(id);
                if (btn) {
                    btn.addEventListener('click', () => {
                        document.documentElement.classList.toggle('dark');
                        const isDark = document.documentElement.classList.contains('dark');
                        localStorage.setItem('theme', isDark ? 'dark' : 'light');
                        updateThemeIcons();
                    });
                }
            });

            updateThemeIcons();
        });
    </script>
</body>
</html>
