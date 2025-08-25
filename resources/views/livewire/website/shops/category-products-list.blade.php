<div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Filter Dropdown */
        .filter-box {
            max-width: 300px;
        }

        .filter-label {
            font-size: 14px;
            letter-spacing: 0.5px;
            font-weight: 600;
            color: #555;
        }

        .filter-select {
            background-color: #f8f9fa;
            border: none;
            border-radius: 30px;
            padding: 10px 35px 10px 15px;
            font-size: 14px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .filter-select:hover {
            background-color: #eef2f7;
        }

        .filter-select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, .25);
        }

        .filter-arrow {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
        }

        /* Product Card */
        .product-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .product-card img {
            height: 350px;
            width: 100%;
            object-fit: contain;
        }

        .product-title {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .card-body {
            padding: 20px;
        }

        .product-description {
            font-size: 12px;
            color: #777;
            height: 34px;
            overflow: hidden;
        }

        .product-price {
            color: #198754;
            font-weight: 600;
            font-size: 1rem;
        }

        .product-actions {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .product-card:hover .product-actions {
            opacity: 1;
            visibility: visible;
        }

        .action-btn {
            background-color: #fd5f17;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .action-btn:hover {
            background-color: #e04d0f;
        }
    </style>

    <!-- Page Title -->
    <section class="page-title mb-4">
        <div class="container">
            <h2 class="mb-3">{{ $category->name }} Products</h2>
        </div>
    </section>

    <!-- Shop Filter -->
    <div class="container mb-4 mt-4" style="margin-top: 40px">
        <label for="shopFilter" class="filter-label">
            <i class="fas fa-store me-2 text-primary"></i> Filter by Shop
        </label>
        <div class="position-relative filter-box" style="margin-botton: 20px">
            <select id="shopFilter" wire:model.live="selectedShop" class="filter-select w-100">
                <option value="">All Shops</option>
                @foreach ($shops as $shop)
                    <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                @endforeach
            </select>
            <i class="fas fa-chevron-down filter-arrow"></i>
        </div>
    </div>

    <!-- Product List -->
    <section class="container" style="margin-top: 40px">
        <div class="row">
            @if ($products->count())
                @foreach ($products as $item)
                    <div class="col-md-6 col-lg-4 col-sm-6 mb-4">
                        <div class="card product-card position-relative">
                            <img src="{{ $item->image }}" alt="{{ $item->name }}">
                            <div class="card-body">
                                <h6 class="product-title">{{ $item->name }}</h6>
                                <p class="product-description">{{ $item->description }}</p>
                                <div class="product-price">Rs {{ number_format($item->price) }}</div>
                            </div>
                            <div class="product-actions">
                                <a href="{{ route('single.Product', ['id' => $item->id]) }}" class="action-btn"
                                    title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button wire:click="buyNow({{ $item->id }})" class="action-btn" title="Buy Now">
                                    <i class="fas fa-bolt"></i>
                                </button>
                                <button wire:click="add({{ $item->id }})" class="action-btn" title="Add to Cart">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No products found.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </section>
</div>
