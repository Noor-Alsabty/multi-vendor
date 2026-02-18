<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- 1. Basic Product Information --}}
    <div class="card mb-4">
        <div class="card-header">Basic Product Information</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Product Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name', $product->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label>Price</label>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                        value="{{ old('price', $product->price) }}">
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Vendor</label>
                    <select name="vendor_id" class="form-control">
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ $product->vendor_id == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Category</label>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Product Images --}}
    <div class="card mb-4">
        <div class="card-header">Product Images</div>
        <div class="card-body">
            <div class="row mb-3">
                @foreach($product->images as $image)
                    <div class="col-md-2">
                        <img src="{{ asset('storage/' . $image->image_url) }}" class="img-thumbnail" width="100">
                    </div>
                @endforeach
            </div>

            <label>Upload New Images (Optional)</label>
            <input type="file" name="images[]" class="form-control" multiple>
            @error('images.*') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
    </div>

    {{-- 3. Product Variants --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            Product Variants
            <button type="button" class="btn btn-sm btn-primary" onclick="addVariant()">+ Add Variant</button>
        </div>
        <div class="card-body" id="variants-container">
            @foreach($product->variants as $index => $variant)
                <div class="variant-row border p-3 mb-2">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Color</label>
                            <input type="text" name="variants[{{ $index }}][color]" class="form-control" 
                                value="{{ old("variants.$index.color", $variant->color) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label>Size</label>
                            <input type="text" name="variants[{{ $index }}][size]" class="form-control" 
                                value="{{ old("variants.$index.size", $variant->size) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label>Stock</label>
                            <input type="number" name="variants[{{ $index }}][stock]" class="form-control" 
                                value="{{ old("variants.$index.stock", $variant->stock) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label>SKU</label>
                            <input type="text" name="variants[{{ $index }}][sku]" class="form-control" 
                                value="{{ old("variants.$index.sku", $variant->SKU) }}" required>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Update Product</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
</form>

<script>
    // Keeping track of the number of existing variants to avoid index collision
    let variantIndex = {{ $product->variants->count() }};
    
    function addVariant() {
        const container = document.getElementById('variants-container');
        const html = `
            <div class="variant-row border p-3 mb-2 bg-light">
                <div class="row">
                    <div class="col-md-3"><input type="text" name="variants[${variantIndex}][color]" class="form-control" placeholder="Color"></div>
                    <div class="col-md-3"><input type="text" name="variants[${variantIndex}][size]" class="form-control" placeholder="Size"></div>
                    <div class="col-md-3"><input type="number" name="variants[${variantIndex}][stock]" class="form-control" placeholder="Stock"></div>
                    <div class="col-md-3"><input type="text" name="variants[${variantIndex}][sku]" class="form-control" placeholder="SKU"></div>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        variantIndex++;
    }
</script>