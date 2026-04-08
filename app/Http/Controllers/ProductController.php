<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {$vendor = Vendor::where('user_id', Auth::id())->first();
    if (!$vendor) {
        return redirect()->back()->with('error','لا يوجد متجر لهذا المستخدم');
    }
        $query = Product::with(['vendor', 'category'])
        ->where('vendor_id', $vendor->id);

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
            'variants.*.SKU'   => 'required|string|unique:product_variants,SKU',
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
        $vendors = Vendor::all();
        $categories = Category::all();

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
            'variants.*.SKU'   => 'required|string',
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
    // 
     public function ind(Request $request)
    {
       $query = Product::with(['vendor', 'category','variants']);

        if ($request->query('status') === 'inactive') {
            // اجلب فقط غير النشط
            $products = $query->where('is_active', false)->get();
        } else {
            // اجلب فقط النشط
            $products = $query->where('is_active', true)->get();
        }
        
$user = Auth::user();
$notifications = $user ? $user->notifications : collect();   
// dd($products);
return view('welcome', [
    'user' => $user,
    'products' => $products,
    'notifications'=>$notifications

]);
    
    }
    public function indexsearch(Request $request)
{
    $query = Product::with(['vendor','category']);

    // البحث
    if ($request->search) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $products = $query->get();
$user = Auth::user();

    return view('welcome', [
    'user' => $user,
    'products' => $products
]);
}
}
