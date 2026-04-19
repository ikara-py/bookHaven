@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-1 md:px-8 py-8 md:py-12">
    <div class="mb-8 md:mb-12">
        <h1 class="text-3xl md:text-4xl font-serif mb-4 leading-tight">Your Shopping <span class="text-(--color-primary)">Bag</span></h1>
        <p class="text-(--color-muted) max-w-2xl leading-relaxed text-base md:text-lg">Review your selection before we prepare your collection for its new home.</p>
    </div>

    @if($cart->items->isEmpty())
        <div class="text-center py-12 md:py-24 bg-(--color-accent)/10 rounded-3xl border-2 border-dashed border-(--color-accent)">
            <div class="w-16 h-16 md:w-24 md:h-24 bg-(--color-accent)/30 rounded-full flex items-center justify-center mx-auto mb-6 md:mb-8 text-(--color-muted)">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" class="md:w-10 md:h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
            <h3 class="text-xl md:text-2xl font-bold mb-3">Your bag is currently empty</h3>
            <p class="text-(--color-muted) mb-8 md:mb-10 text-base md:text-lg">It looks like you haven't added any stories yet.</p>
            <a href="{{ route('books.index') }}" class="inline-flex items-center gap-3 bg-(--color-primary) text-white px-8 md:px-10 py-3 md:py-4 rounded-full font-black uppercase tracking-widest text-xs md:text-sm hover:shadow-2xl transition-all hover:-translate-y-1 shadow-xl shadow-(--color-primary)/25">
                Start Exploring
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <div class="lg:col-span-8 space-y-6">
                @foreach($cart->items as $item)
                    <div id="cart-item-{{ $item->id }}" class="group relative flex flex-col sm:flex-row gap-4 md:gap-6 bg-(--color-surface) p-4 md:p-6 rounded-3xl border border-(--color-border) hover:border-(--color-primary)/30 transition-all hover:shadow-xl hover:shadow-black/5">
                        <div class="w-24 sm:w-32 aspect-[3/4] rounded-2xl overflow-hidden bg-(--color-accent)/20 shadow-sm grow-0 shrink-0">
                            <img src="{{ $item->book->cover_url }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>

                        <div class="flex flex-col flex-grow justify-between py-1 md:py-2">
                            <div>
                                <div class="flex justify-between items-start mb-1 md:mb-2 text-[10px] font-bold text-(--color-primary) uppercase tracking-widest">
                                    <span>{{ $item->book->category->name ?? 'Uncategorized' }}</span>
                                    <button onclick="removeFromCart({{ $item->id }}, this)" class="text-(--color-muted) hover:text-red-500 transition-colors p-1" title="Remove item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </div>
                                <h3 class="text-lg md:text-xl font-bold text-(--color-text) mb-1 group-hover:text-(--color-primary) transition-colors leading-tight">{{ $item->book->title }}</h3>
                                <p class="text-(--color-muted) italic text-xs md:text-sm mb-3 md:mb-4">by {{ $item->book->author->name ?? 'Unknown Author' }}</p>
                                
                                <div class="inline-flex items-center gap-2 px-2.5 py-1 bg-(--color-accent)/10 rounded-lg border border-(--color-border)">
                                    <span class="text-[9px] font-black uppercase text-(--color-muted) tracking-tighter">Qty:</span>
                                    <span class="text-xs md:text-sm font-bold text-(--color-text)">{{ $item->quantity }}</span>
                                </div>
                            </div>

                            <div class="mt-4 md:mt-6 flex justify-between items-end border-t border-(--color-border) pt-3 md:pt-4">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black uppercase text-(--color-muted) tracking-widest leading-none mb-1">Unit</span>
                                    <span class="text-base md:text-lg font-bold text-(--color-text)">${{ number_format($item->price, 2) }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[9px] font-black uppercase text-(--color-muted) tracking-widest leading-none mb-1">Total</span>
                                    <span class="text-lg md:text-xl font-black text-(--color-text)">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="pt-8">
                    <a href="{{ route('books.index') }}" class="group inline-flex items-center gap-2 text-sm font-bold text-(--color-muted) hover:text-(--color-primary) transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
                        Continue Browsing Library
                    </a>
                </div>
            </div>

            <div class="lg:col-span-4 lg:sticky lg:top-32">
                <div class="bg-(--color-surface) p-6 md:p-8 rounded-3xl border border-(--color-border) shadow-2xl shadow-black/5 space-y-6 md:space-y-8">
                    <h2 class="text-xl md:text-2xl font-serif text-(--color-text)">Order Summary</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between text-sm md:text-base text-(--color-muted) font-medium">
                            <span>Subtotal</span>
                            <span id="cart-subtotal" class="text-(--color-text) font-bold">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        @if(session('coupon'))
                            <div class="flex justify-between text-sm md:text-base text-(--color-primary) font-bold">
                                <div class="flex items-center gap-2">
                                    <span>Discount ({{ session('coupon')['code'] }})</span>
                                    <form action="{{ route('cart.coupon.remove') }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                        </button>
                                    </form>
                                </div>
                                <span id="cart-discount">-${{ number_format($discount, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between text-sm md:text-base text-(--color-muted) font-medium italic">
                            <span>Shipping</span>
                            <span class="text-green-600 font-bold">Free</span>
                        </div>

                        @if(!session('coupon'))
                            <div class="pt-4">
                                <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex flex-col gap-2">
                                    @csrf
                                    <div class="flex gap-2">
                                        <input type="text" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="Coupon Code" class="flex-grow bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-2 text-xs font-bold uppercase tracking-widest outline-none focus:border-(--color-primary) @error('coupon_code') border-red-500 @enderror">
                                        <button type="submit" class="bg-(--color-text) text-(--color-bg) px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:opacity-90 transition-all">Apply</button>
                                    </div>
                                    @error('coupon_code')
                                        <p class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</p>
                                    @enderror
                                </form>
                            </div>
                        @endif

                        <div class="pt-4 border-t border-(--color-border) flex justify-between items-end">
                            <div class="flex flex-col">
                                <span class="text-[10px] md:text-xs font-black uppercase tracking-widest text-(--color-muted)">Total Amount</span>
                                <span class="text-[10px] text-(--color-muted) leading-none">(VAT Included)</span>
                            </div>
                            <span id="cart-total" class="text-2xl md:text-4xl font-black text-(--color-text) tracking-tighter tabular-nums">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <div class="space-y-6 pt-4 border-t border-(--color-border)">
                        <h3 class="text-xs font-black uppercase tracking-widest text-(--color-muted)">Delivery & Payment</h3>
                        
                        <form id="checkout-form" action="{{ route('orders.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-black uppercase text-(--color-muted) mb-1 ml-1 tracking-widest">Shipping Address</label>
                                <textarea name="shipping_address" required 
                                    class="w-full bg-(--color-accent)/10 border border-(--color-border) rounded-2xl p-4 text-sm focus:border-(--color-primary) focus:ring-0 transition-all placeholder:text-(--color-muted)/50" 
                                    placeholder="Enter your full street address, city, and zip code..."
                                    rows="3">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                @error('shipping_address') <p class="text-red-500 text-[10px] mt-1 ml-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-black uppercase text-(--color-muted) mb-2 ml-1 tracking-widest">Payment Method</label>
                                <div class="grid grid-cols-1 gap-2">
                                    <label class="relative flex items-center p-3 border border-(--color-border) rounded-2xl cursor-pointer hover:bg-(--color-accent)/10 transition-all has-[:checked]:border-(--color-primary) has-[:checked]:bg-(--color-primary)/5">
                                        <input type="radio" name="payment_method" value="stripe" class="sr-only" checked onchange="togglePaymentFields(this.value)">
                                        <div class="flex items-center gap-3">
                                            <div class="w-4 h-4 rounded-full border-2 border-(--color-border) flex items-center justify-center p-0.5">
                                                <div class="w-full h-full bg-(--color-primary) rounded-full scale-0 transition-transform"></div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-muted)"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                                                <span class="text-sm font-bold text-(--color-text)">Credit/Debit Card (via Stripe)</span>
                                            </div>
                                        </div>
                                    </label>
                                    
                                    <label class="relative flex items-center p-3 border border-(--color-border) rounded-2xl cursor-pointer hover:bg-(--color-accent)/10 transition-all has-[:checked]:border-(--color-primary) has-[:checked]:bg-(--color-primary)/5">
                                        <input type="radio" name="payment_method" value="cod" class="sr-only" onchange="togglePaymentFields(this.value)">
                                        <div class="flex items-center gap-3">
                                            <div class="w-4 h-4 rounded-full border-2 border-(--color-border) flex items-center justify-center p-0.5">
                                                <div class="w-full h-full bg-(--color-primary) rounded-full scale-0 transition-transform"></div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-muted)"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4Z"/></svg>
                                                <span class="text-sm font-bold text-(--color-text)">Cash on Delivery</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @error('payment_method') <p class="text-red-500 text-[10px] mt-1 ml-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </form>
                    </div>

                    <div class="space-y-4 pt-4">
                        <button type="submit" form="checkout-form"
                           class="flex items-center justify-center gap-3 w-full bg-(--color-text) text-(--color-bg) py-5 rounded-2xl font-black text-lg hover:opacity-90 transition-all shadow-[0_20px_50px_rgba(0,0,0,0.15)] active:scale-[0.98]">
                            Complete Purchase
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        </button>

                        <button onclick="clearCart()" class="w-full py-2 text-xs font-bold text-(--color-muted) hover:text-red-500 transition-colors uppercase tracking-widest">
                            Clear Shopping Bag
                        </button>
                    </div>

                    <div class="flex items-center justify-center gap-4 pt-4 border-t border-(--color-border)">
                        <div class="flex items-center gap-1.5 opacity-40 grayscale hover:opacity-100 hover:grayscale-0 transition-all cursor-default">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                            <span class="text-[10px] font-black uppercase tracking-tight">Secure Pay</span>
                        </div>
                        <div class="flex items-center gap-1.5 opacity-40 grayscale hover:opacity-100 hover:grayscale-0 transition-all cursor-default">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                            <span class="text-[10px] font-black uppercase tracking-tight">SSL Protection</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function togglePaymentFields(method) {
    }

    function removeFromCart(itemId, btn) {
        if(!confirm('Remove this book from your bag?')) return;
        
        const card = document.getElementById(`cart-item-${itemId}`);
        card.style.opacity = '0.5';
        card.style.pointerEvents = 'none';

        fetch(`/cart/items/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                card.style.transform = 'translateY(20px)';
                card.style.opacity = '0';
                setTimeout(() => {
                    card.remove();
                    document.getElementById('cart-subtotal').textContent = `$${data.total}`;
                    document.getElementById('cart-total').textContent = `$${data.total}`;
                    
                    // Update navbar badge if it exists
                    const badge = document.querySelector('.bg-red-500');
                    if(badge) {
                        const newCount = parseInt(badge.textContent) - 1;
                        if(newCount <= 0) badge.remove();
                        else badge.textContent = newCount;
                    }

                    if(document.querySelectorAll('[id^="cart-item-"]').length === 0) {
                        location.reload(); // Show empty state
                    }
                }, 300);
            }
        })
        .catch(error => {
            card.style.opacity = '1';
            card.style.pointerEvents = 'auto';
            console.error('Error:', error);
        });
    }

    function clearCart() {
        if(!confirm('Are you sure you want to clear your entire bag?')) return;

        fetch('{{ route('cart.clear') }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                location.reload();
            }
        });
    }
</script>
@endsection
