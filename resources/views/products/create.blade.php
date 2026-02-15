<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fa;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        .btn-primary,
        .btn-warning {
            border-radius: 10px;
            padding: 10px 25px;
        }

        .preview-img {
            max-width: 120px;
            margin-top: 10px;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card p-4">
                    <h3 class="mb-4 text-center">Create Product</h3>

                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Vendor</label>
                            <select name="vendor_id" class="form-select">
                                <option disabled selected>Choose Vendor</option>

                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">
                                        {{ $vendor->store_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select">
                                <option disabled selected>Choose category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input name="name" type="text" class="form-control" placeholder="Enter product name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input name="description" type="text" class="form-control"
                                placeholder="Enter product description">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input name="price" type="text" class="form-control" placeholder="Enter product price">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input name="slug" type="text" class="form-control" placeholder="Enter product slug">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Views</label>
                            <input name="views" type="text" class="form-control" placeholder="Enter product views">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                Add Product
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imagePreview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>

</html>
