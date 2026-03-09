<?php

namespace App\Http\Controllers;

//use App\Models\Cart_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;


class CartItemController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($variant_id, Request $request)
    {
        $quantity = $request->input('quantity');
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);

        $cartItem = $cart->items()->where('variant_id', $variant_id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity',  $quantity);
        } else {
            $cart->items()->create([
                'variant_id' => $variant_id,
                'quantity' => $quantity
            ]);
        }

        return redirect()->back()->with('success', "Added to cart");
    }
    /**
     * Display the specified resource.
     */
    public function show(CartItem $cart_item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartItem $cart_item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);
        $item->update([
            'quantity' => $request->quantity
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        CartItem::findOrFail($id)->delete();
        return back()->with('success', 'item removed');
    }
}
