<html>

<head>
    <title>Your shopping cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <x-app-layout>
        <div class="py-12 font-cairo">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-black mb-10 uppercase tracking-widest text-center">Your Shopping Cart</h1>

                <div class="flex flex-col justify-center lg:flex-row gap-12">
                    <div
                        class=" grid grid-cols-1 justify-center sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4
            gab-6">

                        @php
                            // $cart = Auth::user()->cart;
                            $total = 0;
                        @endphp

                        @if ($items && $items->count() > 0)
                            @foreach ($items as $item)
                                <div
                                    class=" bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition p-4 text-cente m-4">

                                    <div class="flex items-center gap-6">
                                        <div
                                            class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center font-bold text-gray-400">


                                            @if ($item->variant->product->images->count())
                                                @foreach ($item->variant->product->images as $image)
                                                    <img src="{{ asset('storage/' . $image->image_url) }}"
                                                        alt="{{ $item->variant->product->name }}" width="50">
                                                @endforeach
                                            @else
                                                <span>No Image</span>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold">Product Name:
                                                {{ $item->variant->product->name }}</h3>
                                            <p class="text-sm text-gray-500 italic">Qty: {{ $item->quantity }}</p>
                                            @php
                                                $variantPrice = data_get($item, 'variant.price');
                                                $unitPrice = $variantPrice ?: data_get($item, 'variant.product.price', 0);
                                            @endphp
                                            <p class="text-right font-bold text-xl">
                                                {{ $unitPrice * $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right font-bold text-xl">

                                        <form action="{{ route('carts.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </form>
                                    </div>

                                </div>
                                @php
                                    $variantPrice = data_get($item, 'variant.price');
                                    $unitPrice = $variantPrice ?: data_get($item, 'variant.product.price', 0);
                                    $total += $unitPrice * $item->quantity;
                                @endphp
                            @endforeach


                            <div class="w-full lg:w-96">
                                <div class="bg-gray-50 p-8 rounded-xl sticky top-10">
                                    <h2 class="text-xl font-bold mb-6 border-b pb-4 uppercase">Order Summary</h2>
                                    <div class="flex justify-between mb-4">
                                        <span>Subtotal</span>
                                        <span class="font-bold">${{ $total }}</span>
                                    </div>
                                    <div class="flex justify-between mb-8 text-xl font-black border-t pt-4">
                                        <span>Total</span>
                                        <span>${{ $total }}</span>
                                    </div>
                                    <a href="{{ route('checkout.show') }}"
                                        class="inline-flex w-full items-center justify-center bg-black py-4 rounded-full text-white font-bold uppercase tracking-widest hover:bg-gray-800 transition-all shadow-xl">
                                        Checkout
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="grid justify-center text-center py-20 m-5">
                                <p class="text-gray-400 text-lg mb-6 ">Your cart is empty.</p>
                                <a href="{{ url('/') }}"
                                    class="bg-black text-white px-8 py-3 rounded-full uppercase text-xs font-bold tracking-widest">Go
                                    Shopping</a>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
