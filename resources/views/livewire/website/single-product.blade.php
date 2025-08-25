<div>
    <!-- start page-title -->
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <h2>{{ $product->name }}</h2>
                    <p style="color: white;font-size: 25px;">Gas Cylinder Refilling</p>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>

    <style>
        .product-img {
            max-width: 100%;
            border-radius: 0.5rem;
        }

        .rating {
            color: #ffc107;
            font-size: 1.2rem;
        }
    </style>


    <div class="container my-5">
        <div class="row" style="margin-top: 70px;">
            <!-- Product Image -->
            <!-- Thumbnail (click to zoom) -->
            <div class="col-md-6">
                <img src="{{ $product->image }}" alt="Product Name" class="product-img img-fluid">
            </div>

            {{-- {{ $product }} --}}



            <!-- Product Details -->
            <div class="col-md-6" style="display: flow-root;align-content: center;margin-top: 53px;">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <h2 class="mb-3"><b>Product</b> {{ $product->name }}</h2>
                <div class="rating mb-2">★★★★☆</div>
                <p class="text-muted"><b>Category:</b> {{ $product->productcategory->name ?? '' }}</p>
                <h4 class="text-success">Rs {{ $product->price }}</h4>
                <p class="mt-4">
                    {{ $product->description }}
                </p>


                <form class="mt-4">

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" id="quantity" wire:model.lazy="quantity" class="form-control"
                            min="1" style="width: 120px;">
                    </div>

                    <button type="button" wire:click="add({{ $product->id }})" class="btn theme-btn  btn-lg w-100"
                        style="margin-top: 20px">Add to
                        Cart</button>

                    <button type="button" wire:click="buyNow({{ $product->id }})" class="btn theme-btn btn-lg w-100"
                        style="margin-top: 20px">
                        Buy Now
                    </button>

                </form>
            </div>
        </div>
    </div>

    <script>
        const quantityInput = document.getElementById('quantity');
        const buyNowLink = document.getElementById('buyNowLink');
        const productId = "{{ $product->id }}";

        quantityInput.addEventListener('input', function() {
            const qty = quantityInput.value || 1;
            buyNowLink.href = `/checkout/${productId}?qty=${qty}`;
        });
    </script>
</div>
