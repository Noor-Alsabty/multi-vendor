<html>

<head>
    <title>create vendor request</title>
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
    @if ($errors->any())
        <div style="color:red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form action="{{ route('vendors-requests.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Store Name</label>
            <input name="store_name" type="text" class="form-control" placeholder="Enter store name">
        </div>

        <div class="mb-3">
            <label class="form-label">Store Email</label>
            <input name="store_email" type="text" class="form-control" placeholder="Enter store email">
        </div>
        <div class="mb-3">
            <label class="form-label">store phone</label>
            <input name="store_phone" type="number" class="form-control" placeholder="Enter store phone">
        </div>
        <div class="mb-3">
            <label class="form-label">store logo</label>
            <input name="store_logo" type="text" class="form-control" placeholder="Enter store_logo">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <input name="description" type="text" class="form-control" placeholder="Enter store description">
        </div>


        <div class="text-center">
            <button type="submit" class="btn btn-primary">
                Request to join
            </button>
        </div>
    </form>
</body>

</html>
