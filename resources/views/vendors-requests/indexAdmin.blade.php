<html>

<head>
    <title>vendors requests</title>
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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>All Requests</h3>
        </div>

        <div class="card p-4">
            <div class="table-responsive">
                <table class="table align-middle text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Store Name</th>
                            <th>Store Email</th>
                            <th>store phone</th>
                            <th>store logo</th>
                            <th>Description</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($vendorsRequests as $vendorsRequest)
                            <tr>
                                <th scope="row">{{ $vendorsRequest->id }}</th>
                                <td>{{ $vendorsRequest->store_name }}</td>
                                <td>{{ $vendorsRequest->store_email }}</td>
                                <td>{{ $vendorsRequest->store_phone }}</td>
                                <td>{{ $vendorsRequest->store_logo }}</td>
                                <td>{{ $vendorsRequest->description }}</td>
                                <td>
                                    <form action="{{ route('vendors-requests.verify', $vendorsRequest->id) }}"
                                        method="POST">
                                        @csrf

                                        <button type="submit" class="btn btn-outline-success">verify</button>
                                    </form>
                                </td>

                                <td>
                                    <form action="{{ route('vendors-requests.reject', $vendorsRequest->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal{{ $vendorsRequest->id }}">reject</button>
                                        <div class="modal fade" id="rejectModal{{ $vendorsRequest->id }}"
                                            tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">rejection reason</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form
                                                        action="{{ route('vendors-requests.reject', $vendorsRequest->id) }}"
                                                        method="POST">
                                                        @csrf

                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">write rejection reason</label>
                                                                <textarea name="reject_reason" class="form-control" required></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">cancel</button>
                                                            <button type="submit" class="btn btn-danger">Confirm
                                                                rejection</button>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
