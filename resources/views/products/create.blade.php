<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .form-label { font-weight: 600; color: #34495e; }
        .static-display { background-color: #eef2f7; padding: 10px 15px; border-radius: 8px; border: 1px solid #d1d9e6; font-weight: bold; color: #2c3e50; display: block; }
        .variant-row { background: #fff; border: 1px solid #edeff2; padding: 15px; border-radius: 10px; margin-bottom: 10px; position: relative; }
        .preview-container img { width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 2px solid #ddd; }
        .btn-add { background-color: #2ecc71; color: white; border: none; }
        .btn-add:hover { background-color: #27ae60; color: white; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card p-4">
                <h2 class="text-center mb-4"><i class="fas fa-box-open me-2"></i>Create New Product</h2>

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Store Name</label>
                        <span class="static-display">
                            {{ $vendors->first()->store_name ?? 'No Store Assigned' }}
                        </span>
                        <input type="hidden" name="vendor_id" value="{{ $vendors->first()->id ?? '' }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" disabled selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Premium Cotton T-Shirt" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-primary">Unified Price (For all variants)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="price" step="0.01" class="form-control" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Product Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Describe your product..."></textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-images me-2"></i>Product Gallery</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*" id="imageInput">
                        <div id="imagePreview" class="preview-container d-flex flex-wrap gap-2 mt-3"></div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 text-secondary">Product Variants (Colors & Sizes)</h5>
                        <button type="button" class="btn btn-sm btn-add" id="add-variant">
                            <i class="fas fa-plus"></i> Add Variant
                        </button>
                    </div>

                    <div id="variants-container">
                        <div class="variant-row">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <label class="small fw-bold">Color</label>
                                    <input type="text" name="variants[0][color]" class="form-control form-control-sm" placeholder="e.g. Blue">
                                </div>
                                <div class="col-md-3">
                                    <label class="small fw-bold">Size</label>
                                    <input type="text" name="variants[0][size]" class="form-control form-control-sm" placeholder="e.g. Large">
                                </div>
                                <div class="col-md-3">
                                    <label class="small fw-bold">SKU</label>
                                    <input type="text" name="variants[0][sku]" class="form-control form-control-sm" placeholder="SKU-123">
                                </div>
                                <div class="col-md-3">
                                    <label class="small fw-bold">Stock</label>
                                    <input type="number" name="variants[0][stock]" class="form-control form-control-sm" placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-save me-2"></i>Publish Product
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Multiple Images Preview Logic
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        Array.from(event.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    });

    // 2. Add More Variants Dynamically
    let variantIndex = 1;
    document.getElementById('add-variant').addEventListener('click', function() {
        const container = document.getElementById('variants-container');
        const html = `
            <div class="variant-row">
                <div class="row g-2">
                    <div class="col-md-3">
                        <input type="text" name="variants[${variantIndex}][color]" class="form-control form-control-sm" placeholder="Color">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="variants[${variantIndex}][size]" class="form-control form-control-sm" placeholder="Size">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="variants[${variantIndex}][sku]" class="form-control form-control-sm" placeholder="SKU">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="variants[${variantIndex}][stock]" class="form-control form-control-sm" placeholder="Stock">
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        variantIndex++;
    });

    // 3. Remove Variant Row
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-variant') || e.target.parentElement.classList.contains('remove-variant')) {
            e.target.closest('.variant-row').remove();
        }
    });
</script>

</body>
</html>