<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fa;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .table thead {
            background-color: #0d6efd;
            color: white;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .btn {
            border-radius: 8px;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>All Products</h3>
            <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add New Product</a>
        </div>

        <div class="card p-4">
            <div class="table-responsive">
                <div class="mb-4 d-flex gap-2">
                    <a href="{{ route('products.index') }}" 
                       class="btn {{ request('status') != 'inactive' ? 'btn-success' : 'btn-outline-success' }}">
                        Active 
                    </a>

                    <a href="{{ route('products.index', ['status' => 'inactive']) }}" 
                       class="btn {{ request('status') == 'inactive' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                        Inactive
                    </a>
                </div>

                <table class="table align-middle text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vendor</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td>{{ $product->vendor_id }}</td>
                                <td>{{ $product->category_id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }} $</td>
                                <td>{{ $product->views }}</td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success">Active</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a class="btn btn-sm btn-warning" href="{{ route('products.edit', $product->id) }}">Edit</a>

                                        @if($product->is_active)
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to hide this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hide</button>
                                            </form>
                                        @else
                                            <form action="{{ route('products.restore', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-info text-white">Activate</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>