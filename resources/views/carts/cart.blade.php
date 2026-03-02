<x-app-layout>
    <div class="py-12 font-cairo">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-black mb-10 uppercase tracking-widest text-center">Your Shopping Cart</h1>

            <div class="flex flex-col lg:flex-row gap-12">
                <div class="flex-grow bg-white p-8 rounded-xl shadow-sm">
                    @php
                        $cart = Auth::user()->cart;
                    @endphp

                    @if($cart && $cart->items->count() > 0)
                        @foreach($cart->items as $item)
                            <div class="flex items-center justify-between border-b pb-6 mb-6 last:border-0">
                                <div class="flex items-center gap-6">
                                    <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center font-bold text-gray-400">IMG</div>
                                    <div>
                                        <h3 class="text-lg font-bold">Product Variant ID: {{ $item->variant_id }}</h3>
                                        <p class="text-sm text-gray-500 italic">Qty: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <div class="text-right font-bold text-xl">
                                    $99.00 </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-20">
                            <p class="text-gray-400 text-lg mb-6">Your cart is empty.</p>
                            <a href="{{ url('/') }}" class="bg-black text-white px-8 py-3 rounded-full uppercase text-xs font-bold tracking-widest">Go Shopping</a>
                        </div>
                    @endif
                </div>

                <div class="w-full lg:w-96">
                    <div class="bg-gray-50 p-8 rounded-xl sticky top-10">
                        <h2 class="text-xl font-bold mb-6 border-b pb-4 uppercase">Order Summary</h2>
                        <div class="flex justify-between mb-4">
                            <span>Subtotal</span>
                            <span class="font-bold">$0.00</span>
                        </div>
                        <div class="flex justify-between mb-8 text-xl font-black border-t pt-4">
                            <span>Total</span>
                            <span>$0.00</span>
                        </div>
                        <button class="w-full bg-black text-white py-4 rounded-full font-bold uppercase tracking-widest hover:bg-gray-800 transition-all shadow-xl">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>