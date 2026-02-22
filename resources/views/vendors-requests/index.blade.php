<html>

<head>
    <title>request to admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    @section('content')
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card p-4">
                        <h3>Your vendor request</h3>
                        @if ($existingRequest)


                            <div class="mb-3 p-3 border rounded">
                                <strong>Statue:</strong>

                                {{ ucfirst($existingRequest->status) }}


                                @if ($existingRequest->status === 'rejected' && $existingRequest->verification_reject_reason)
                                    <div class="mt-2">
                                        <strong>Reason:</strong>
                                        {{ $existingRequest->verification_reject_reason }}
                                    </div>
                                @endif
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>



        </div>

    </body>

    </html>
