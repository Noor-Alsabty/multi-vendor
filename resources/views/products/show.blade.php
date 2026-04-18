<!-- Bootstrap Premium Product Details Page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <style>
        .option {
            border: 1px solid #ddd;
            padding: 8px 14px;
            border-radius: 10px;
            cursor: pointer;
        }

        .option.active {
            background: black;
            color: white;
            border-color: black;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row g-5">

            <!-- Image -->
            <div class="col-md-6">
                @if ($product->images->count())
                    <img src="{{ asset('storage/' . $product->images->first()->image_url) }}"
                        class="img-fluid rounded shadow" alt="{{ $product->name }}">
                @else
                    <div class="bg-light border rounded shadow d-flex align-items-center justify-content-center"
                        style="height: 350px;">
                        <span class="text-muted">No image available</span>
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="col-md-6">
                <h2 class="fw-bold">{{ $product->name }}</h2>
                <p class="text-muted">{{ $product->description }}</p>

                <h4 id="price" class="my-3">{{ $product->price }}$</h4>

                <form id="cartForm" method="POST">
                    @csrf
                    <input type="hidden" name="variant_id" id="variant_id">

                    <!-- Size -->
                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Size</label>
                        <div class="d-flex gap-2 flex-wrap" id="sizes"></div>
                    </div>

                    <!-- Color -->
                    <div class="mb-3">
                        <label class="fw-semibold mb-2">Color</label>
                        <div class="d-flex gap-2 flex-wrap" id="colors"></div>
                    </div>

                    <!-- Quantity -->
                    <div class="mb-4">
                        <label class="fw-semibold">Quantity</label>
                        <input type="number" name="quantity" value="1" min="1" class="form-control w-25">
                    </div>


                    <form class="mt-2" action="" method="POST">
                        @csrf
                        <div>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
                                class="btn btn-info mt-2">
                                Add to cart</button>
                        </div>
                    </form>
                </form>
            </div>

        </div>
    </div>
    <script>
        const variants = @json($product->variants);

        let selectedSize = null;
        let selectedColor = null;

        const sizesDiv = document.getElementById('sizes');
        const colorsDiv = document.getElementById('colors');
        const priceDiv = document.getElementById('price');
        const variantInput = document.getElementById('variant_id');
        const form = document.getElementById('cartForm');

        // استخراج القيم
        const sizes = [...new Set(variants.map(v => v.size))];
        const colors = [...new Set(variants.map(v => v.color))];

        // عرض المقاسات
        sizes.forEach(size => {
            let el = document.createElement('div');
            el.className = 'option';
            el.innerText = size;

            el.onclick = () => {
                selectedSize = size;
                setActive(sizesDiv, el);
                updateVariant();
            };

            sizesDiv.appendChild(el);
        });

        // عرض الألوان
        colors.forEach(color => {
            let el = document.createElement('div');
            el.className = 'option';
            el.innerText = color;

            el.onclick = () => {
                selectedColor = color;
                setActive(colorsDiv, el);
                updateVariant();
            };

            colorsDiv.appendChild(el);
        });

        // active class
        function setActive(parent, el) {
            [...parent.children].forEach(c => c.classList.remove('active'));
            el.classList.add('active');
        }

        // تحديث البيانات
        function updateVariant() {
            const variant = variants.find(v =>
                v.size == selectedSize && v.color == selectedColor
            );

            if (variant) {
                priceDiv.innerText = '$' + variant.price;
                variantInput.value = variant.id;
                form.action = `/carts/store/${variant.id}`;
            }
        }

        // منع الإرسال بدون اختيار
        form.addEventListener('submit', function(e) {
            if (!variantInput.value) {
                e.preventDefault();
                alert('اختاري size و color أول 😅');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
