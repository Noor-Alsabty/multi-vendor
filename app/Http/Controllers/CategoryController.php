<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
          $categories = Category::all();//select * from departments
        //  dd($category);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
     { 
        // dd($request->image);
        //
 $request->validate([
            "name"=>"required|string|max:255|min:3",
            "parent_id"=>"nullable|exists:categories,id",
            
        ]);
      $category=  Category::create($request->all());
        $category->addMedia($request->image)->toMediaCollection("category_images");
    //   dd( $category->getFirstMediaUrl('category_images'));
        return redirect()->route('categories.index')->with('success','category created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, $id)
{
    // التحقق من صحة البيانات
    $validated = $request->validate([
        "name" => "required|string|max:255|min:3",
        "parent_id" => "nullable|exists:categories,id",
    ]);

    // الحصول على النموذج نفسه
    $category = Category::findOrFail($id);

    // تحديث البيانات
    $category->update($validated);

    // رفع الصورة إذا تم إرسالها
    if ($request->hasFile("image")) {

        // إذا كان هناك صورة موجودة مسبقًا، نحذفها
        if ($category->hasMedia("category_images")) {
            $category->clearMediaCollection("category_images");
        }

        // إضافة الصورة الجديدة
        $category->addMediaFromRequest("image")
                 ->withCustomProperties([
                     "metadata" => "user has uploaded image before",
                     "uploaded_at" => now(),
                     "sizes" => $request->image->getSize(),
                 ])
                 ->toMediaCollection("category_images");
    }

    return redirect()->route('categories.index')
                     ->with('success', 'Category updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
{
    $category = Category::findOrFail($id);

    // منع الحذف إذا عنده تصنيفات فرعية
    if ($category->children()->exists()) {
        return redirect()->route('categories.index')
                         ->with('error', 'Cannot delete category with subcategories.');
    }

    // منع الحذف إذا عنده منتجات
    if ($category->products()->exists()) {
        return redirect()->route('categories.index')
                         ->with('error', 'Cannot delete category with products.');
    }

    $category->delete();

    return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
}
        // {  Category::find($id)->delete();
        // return redirect()->route('categories.index')->with('success','Department deleted successfully');}


}
