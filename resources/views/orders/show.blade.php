@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-1 md:px-4 py-8 md:py-12">
    @if(session('success'))
        <div class="mb-8 bg-emerald-500/10 border border-emerald-500/20 p-6 rounded-2xl flex items-center gap-4 text-emerald-600 animate-slide-down">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            <span class="font-bold text-sm uppercase tracking-widest">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-8 bg-red-500/10 border border-red-500/20 p-6 rounded-2xl flex items-start gap-4 text-red-600 animate-slide-down">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <div>
                <h4 class="font-black text-xs uppercase tracking-[0.2em] mb-1">Feedback Error</h4>
                <ul class="list-none space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="text-xs font-bold">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="text-center mb-8 md:mb-12">
        <div class="w-16 h-16 md:w-20 md:h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" class="md:w-10 md:h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        </div>
        <h1 class="text-2xl md:text-4xl font-serif mb-2">Thank you for your <span class="text-(--color-primary)">Collection</span>!</h1>
        <p class="text-(--color-muted) text-base md:text-lg px-4">Your order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} has been placed successfully.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) overflow-hidden">
                <div class="bg-(--color-accent)/10 px-6 py-4 border-b border-(--color-border) flex justify-between items-center">
                    <h3 class="text-xs font-black uppercase tracking-widest text-(--color-muted)">Ordered Items</h3>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-black uppercase rounded-full tracking-widest">{{ $order->status }}</span>
                </div>
                <div class="divide-y divide-(--color-border)">
                    @foreach($order->items as $item)
                        <div class="p-4 md:p-6 flex gap-4">
                            <div class="w-16 h-24 rounded-lg overflow-hidden bg-(--color-accent)/20 flex-shrink-0 shadow-sm">
                                <img src="{{ $item->book->cover_url }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow">
                                <h4 class="font-bold text-sm md:text-base text-(--color-text) leading-tight mb-1">{{ $item->book->title }}</h4>
                                <p class="text-[10px] md:text-xs text-(--color-muted) mb-2">by {{ $item->book->author->name ?? 'Unknown Author' }}</p>
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mt-2">
                                    <span class="text-[10px] md:text-xs font-medium text-(--color-muted)">Qty: {{ $item->quantity }} x ${{ number_format($item->price, 2) }}</span>
                                    <div class="flex items-center justify-between sm:justify-end gap-4 w-full sm:w-auto">
                                        <span class="font-bold text-(--color-text)">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                        
                                        @if($item->book->type === 'digital' && $item->status === 'delivered')
                                            <a href="{{ route('orders.download', $item->book_id) }}" class="px-4 py-1.5 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all shadow-md active:scale-95 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                                Download PDF
                                            </a>
                                        @endif

                                        @if($order->status === 'completed')
                                            @php $userReview = auth()->user()->reviews->where('book_id', $item->book_id)->first(); @endphp
                                            @if($userReview)
                                                <div class="flex items-center gap-1.5 px-3 py-1 bg-green-50 rounded-lg border border-green-100">
                                                    <div class="flex items-center text-amber-400">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="w-3 h-3 {{ $i <= $userReview->rating ? 'fill-current' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                                        @endfor
                                                    </div>
                                                    <span class="text-[9px] font-black uppercase text-green-700 tracking-widest">Reviewed</span>
                                                </div>
                                            @else
                                                <button onclick="toggleReview({{ $item->id }})" class="px-4 py-1.5 bg-(--color-text) text-(--color-bg) text-[10px] font-black uppercase tracking-widest rounded-xl hover:opacity-90 transition-all shadow-md active:scale-95">
                                                    Leave Review
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                @if($order->status === 'completed' && !auth()->user()->reviews->contains('book_id', $item->book_id))
                                    <div id="review-form-{{ $item->id }}" class="hidden mt-6 pt-6 border-t border-(--color-border) animate-slide-down">
                                        <form action="{{ route('reviews.store', $item->book) }}" method="POST" class="space-y-4">
                                            @csrf
                                            <div class="flex items-center justify-between">
                                                <span class="text-[10px] font-black uppercase text-(--color-muted) tracking-widest">Your Rating</span>
                                                <div class="flex items-center gap-1 flex-row-reverse justify-end star-rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="rating" id="rating-{{ $item->id }}-{{ $i }}" value="{{ $i }}" class="peer hidden" required>
                                                        <label for="rating-{{ $item->id }}-{{ $i }}" class="cursor-pointer text-gray-300 peer-checked:text-amber-400 hover:text-amber-400 transition-colors">
                                                            <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                                        </label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <textarea name="comment" rows="2" class="w-full bg-(--color-accent)/5 border border-(--color-border) rounded-2xl p-4 text-sm focus:ring-2 focus:ring-(--color-primary) outline-none transition-all resize-none" placeholder="Share your experience with this book..."></textarea>
                                            <div class="flex justify-end gap-3">
                                                <button type="button" onclick="toggleReview({{ $item->id }})" class="px-4 py-2 text-[10px] font-black uppercase text-(--color-muted) hover:text-(--color-text)">Cancel</button>
                                                <button type="submit" class="px-6 py-2 bg-(--color-text) text-(--color-bg) text-[10px] font-black uppercase tracking-widest rounded-xl hover:opacity-90 transition-all shadow-lg">Submit Review</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="bg-(--color-accent)/5 p-4 md:p-6 space-y-3">
                    <div class="flex justify-between text-xs md:text-sm text-(--color-muted)">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-xs md:text-sm text-(--color-muted)">
                        <span>Shipping</span>
                        <span class="text-green-600 font-bold uppercase text-[9px] md:text-[10px] tracking-widest">Free Delivery</span>
                    </div>
                    <div class="flex justify-between items-end pt-3 border-t border-(--color-border)">
                        <span class="text-[10px] md:text-xs font-black uppercase text-(--color-text)">Total Paid</span>
                        <span class="text-xl md:text-2xl font-black text-(--color-text)">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-(--color-primary) hover:underline group">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
                Continue Browsing Library
            </a>
        </div>

        <div class="space-y-6">
            <div class="bg-(--color-surface) p-6 rounded-3xl border border-(--color-border) space-y-6">
                <div>
                    <h4 class="text-[10px] font-black uppercase text-(--color-muted) tracking-widest mb-3">Shipping Address</h4>
                    <p class="text-sm font-medium text-(--color-text) leading-relaxed">
                        {{ $order->shipping_address }}
                    </p>
                </div>
                
                <div class="pt-6 border-t border-(--color-border)">
                    <h4 class="text-[10px] font-black uppercase text-(--color-muted) tracking-widest mb-3">Payment Detail</h4>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-(--color-accent)/10 rounded-xl flex items-center justify-center text-(--color-text)">
                            @if($order->payment->payment_method === 'stripe')
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold text-(--color-text) uppercase">
                                {{ $order->payment->payment_method === 'stripe' ? 'Credit/Debit Card' : $order->payment->payment_method }}
                            </p>
                            <p class="text-[10px] text-(--color-muted) font-medium uppercase tracking-widest">{{ $order->payment->status }}</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-(--color-border)">
                    <h4 class="text-[10px] font-black uppercase text-(--color-muted) tracking-widest mb-3">Order Placed</h4>
                    <p class="text-sm font-medium text-(--color-text)">
                        {{ $order->created_at->format('M d, Y') }}<br>
                        <span class="text-xs text-(--color-muted)">at {{ $order->created_at->format('h:i A') }}</span>
                    </p>
                </div>

                @if(in_array($order->status, ['pending', 'paid']))
                    <div class="pt-6 border-t border-(--color-border)">
                        <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order? All items will be returned to stock and payments refunded.');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full py-4 border-2 border-red-500/10 text-red-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-500/10 transition-all active:scale-[0.98]">
                                Cancel Order
                            </button>
                        </form>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
    function toggleReview(itemId) {
        const form = document.getElementById(`review-form-${itemId}`);
        form.classList.toggle('hidden');
    }
</script>

<style>
    @keyframes slideDown {
        from { transform: translateY(-10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-down {
        animation: slideDown 0.3s ease-out forwards;
    }
    
    .star-rating > label:hover,
    .star-rating > label:hover ~ label {
        color: #fbbf24 !important;
    }
</style>
@endsection
