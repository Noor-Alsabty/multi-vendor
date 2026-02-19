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
    public function index()
    {
        $products = Product::with(['vendor', 'category'])->get();
        return view('products.index', compact('products'));
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
// public function store(Request $request)
// {
//     $product = Product::create([
//         'vendor_id'   => $request->vendor_id, // [cite: 82, 222]
//         'category_id' => $request->category_id, // [cite: 86, 224]
//         'name'        => $request->name, // [cite: 92, 232]
//         'description' => $request->description, // [cite: 96, 236]
//         'price'       => $request->price, // 
//     ]);
// if ($request->hasFile('images')) {
//         foreach ($request->file('images') as $image) {
//             $path = $image->store('products', 'public');
//             $product->images()->create([
//                 'image_url' => $path
//             ]);
//         }
//     }
//     if ($request->has('variants')) {
//         foreach ($request->variants as $variant) {
//             $product->variants()->create([
//                 'color' => $variant['color'], 
//                 'size'  => $variant['size'], 
//                 'stock' => $variant['stock'],  
//                 'SKU'   => $variant['sku']   
//             ]);
//         }
//     }
// }

public function store(Request $request)
{
    // 1. تحقق من بيانات المنتج الأساسية فقط
    $productData = $request->validate([
        'vendor_id'   => 'required|exists:vendors,id',
        'category_id' => 'required|exists:categories,id',
        'name'        => 'required|string|max:255|min:3',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
    ]);

    // 2. تحقق من الصور بشكل منفصل
    $imageData = $request->validate([
        'images'   => 'nullable|array',
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 3. تحقق من الـ Variants بشكل منفصل
    $variantData = $request->validate([
        'variants'         => 'nullable|array',
        'variants.*.color' => 'required|string',
        'variants.*.size'  => 'required|string',
        'variants.*.stock' => 'required|integer|min:0',
        'variants.*.sku'   => 'required|string|unique:product_variants,SKU',
    ]);

    // --- البدء في تنفيذ العمليات بعد نجاح كل الفحوصات ---

    // 4. إنشاء المنتج (باستخدام بيانات المنتج التي تم فحصها فقط)
    $product = Product::create($productData);

    // 5. رفع الصور وتخزينها
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');
            $product->images()->create(['image_url' => $path]);
        }
    }
    // 6. تخزين الـ Variants
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
// public function edit($id) {
//     $product = Product::with('variants')->findOrFail($id); // جلب المنتج مع ألوانه ومقاساته 
//     $vendor = Vendor::all(); 
//     $categories = Category::all();
//     return view('products.edit', compact('product', 'vendor', 'categories'));
// }

public function edit(Product $product)
{
    // تحميل العلاقات (الصور والأنواع) لكي تظهر في الفورم
    $product->load(['images', 'variants']);
    
    return view('products.edit', compact('product'));
}
    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $product = Product::findOrFail($id);
    //     $product->update([
    //         'vendor_id' => $request->vendor_id,
    //         'category_id' => $request->category_id,
    //         'name' => $request->name,
    //         'description' => $request->description,
    //         'price' => $request->price,
    //         'slug' => $request->slug,
    //         'views' => $request->views,
    //     ]);
    //     return redirect()->route('products.index');
    // }
public function update(Request $request, Product $product)
{
    // 1. الفاليديشن (نفس قواعد الـ Store مع استثناء الـ SKU الحالي)
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
        // هنا استثناء الـ SKU الحالي للمنتج لكي لا يظهر خطأ "موجود مسبقاً"
        'variants.*.sku'   => 'required|string', 
    ]);

    // 2. تحديث بيانات المنتج الأساسية
    $product->update($productData);

    // 3. تحديث الصور (إذا تم رفع صور جديدة)
    if ($request->hasFile('images')) {
        // اختياري: إذا أردت حذف الصور القديمة من السيرفر وقاعدة البيانات
        // $product->images()->delete(); 

        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');
            $product->images()->create(['image_url' => $path]);
        }
    }

    // 4. تحديث الـ Variants (الطريقة الأسهل: حذف القديم وإضافة الجديد)
    if (isset($variantData['variants'])) {
        // نحذف الأنواع القديمة المرتبطة بهذا المنتج ونضيف الجديدة
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
        Product::destroy($id);
        return redirect()->route('products.index');
    }
}
