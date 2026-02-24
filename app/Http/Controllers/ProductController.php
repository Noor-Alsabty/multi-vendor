<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Product::with(['vendor', 'category']);

    if ($request->query('status') === 'inactive') {
        // اجلب فقط غير النشط
        $products = $query->where('is_active', false)->get();
    } else {
        // اجلب فقط النشط
        $products = $query->where('is_active', true)->get();
    }

    return view('products.index', compact('products'));
}

public function restore($id)
{
    $product = Product::findOrFail($id);
    $product->update(['is_active' => true]);

    return redirect()->route('products.index')->with('success', 'تم إعادة المنتج لقائمة النشطين');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = Vendor::all();
        $categories = Category::all();

        return view('products.create', compact('vendors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $productData = $request->validate([
        'vendor_id'   => 'required|exists:vendors,id',
        'category_id' => 'required|exists:categories,id',
        'name'        => 'required|string|max:255|min:3',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
    ]);

    $imageData = $request->validate([
        'images'   => 'nullable|array',
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);
    $variantData = $request->validate([
        'variants'         => 'nullable|array',
        'variants.*.color' => 'required|string',
        'variants.*.size'  => 'required|string',
        'variants.*.stock' => 'required|integer|min:0',
        'variants.*.sku'   => 'required|string|unique:product_variants,SKU',
    ]);

    $product = Product::create($productData);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');
            $product->images()->create(['image_url' => $path]);
        }
    }
    if (!empty($variantData['variants'])) {
        foreach ($variantData['variants'] as $variant) {
            $product->variants()->create($variant);
        }
    }
return redirect()->route('products.index');
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

public function edit(Product $product)
{
    $vendors =Vendor::all(); 
    $categories =Category::all();

    $product->load(['images', 'variants']);
    
    return view('products.edit', compact('product', 'vendors', 'categories'));
}
    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Product $product)
{
    $productData = $request->validate([
        'vendor_id'   => 'required|exists:vendors,id',
        'category_id' => 'required|exists:categories,id',
        'name'        => 'required|string|max:255|min:3',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
    ]);

    $request->validate([
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $variantData = $request->validate([
        'variants'         => 'nullable|array',
        'variants.*.color' => 'required|string',
        'variants.*.size'  => 'required|string',
        'variants.*.stock' => 'required|integer|min:0',
        'variants.*.sku'   => 'required|string', 
    ]);

    $product->update($productData);
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');
            $product->images()->create(['image_url' => $path]);
        }
    }

    if (isset($variantData['variants'])) {
        $product->variants()->delete(); 

        foreach ($variantData['variants'] as $variant) {
            $product->variants()->create($variant);
        }
    }

    return redirect()->route('products.index')->with('success', 'تم تحديث المنتج بنجاح');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->is_active = false;
    $product->save();

    return redirect()->route('products.index');
}
}
