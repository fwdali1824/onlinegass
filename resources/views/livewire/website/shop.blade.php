<div>
    <style>
        .product-card {
            transition: box-shadow 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .product-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            position: sticky;
            top: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: static;
            }
        }

        .product-card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            border-radius: 12px;
            background: #fff;
            padding: 19px 0px;
            height: 410px;

        }

        /* .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        } */

        .product-card img {
            height: 220px;
            width: 100%;
            object-fit: fill;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .product-title {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }

        .product-description {
            font-size: 10px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }

        .product-price {
            color: #198754;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .product-rating {
            color: #ffc107;
            font-size: 0.9rem;
            margin-bottom: 12px;
        }

        .card-body {
            text-align: center;
        }

        .theme-btn1 {
            background-color: #fd5f17;
            color: #fff;
            font-size: 14px;
            font-size: 10px;
            font-weight: bold;
            padding: 11px 17px;
            border: 0;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            -o-border-radius: 0;
            -ms-border-radius: 0;
            border-radius: 0;
            text-transform: uppercase;
            display: inline-block;
            line-height: initial;
        }
    </style>
    <!-- start page-title -->
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <h2>Shop</h2>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>

    <section class="ct-section">
        <div class="container">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div wire:ignore>
                @include('layouts.ShopsDisplay')
            </div>

            <div style="padding: 20px" class="row ">
                <!-- Sidebar Filter -->
                <div style="padding: 20px;background: gainsboro;height: 100vh;" class="col-md-3 mb-4">
                    <div class="sidebar bg-light p-3 rounded shadow-sm">
                        <h5 class="mb-3">Filters</h5>

                        <!-- Search -->
                        <div class="mb-3">
                            <input wire:model="search"
                                class="form-input rounded-md shadow-sm mt-1 block w-full mr-2" type="text"
                                placeholder="Search...">

                            {{-- <input type="text" wire:model.debounce.500ms="search" class="form-control"
                                placeholder="Search products..." /> --}}
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <h6>Category</h6>

                            @foreach ($productsCategory as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $category->id }}"
                                        wire:model="selectedCategories" wire:change="showSelectedCategories"
                                        id="cat{{ $category->id }}" />
                                    <label class="form-check-label"
                                        for="cat{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <h6>Shops</h6>

                            @foreach ($shops as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $category->id }}"
                                        wire:model="selectedShop" wire:change="showselectedShop"
                                        id="shop{{ $category->id }}" />
                                    <label class="form-check-label"
                                        for="shop{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <!-- Product Listing -->
                <div style="padding: 20px" class="col-md-9">

                    <div class="row g-4">
                        <!-- Product Card -->
                        @if ($products->count())
                            @foreach ($products as $item)
                                <div class="col-md-4 p-4">
                                    <div class="card product-card shadow-sm">
                                        <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}">
                                        <div class="card-body">
                                            <h6 class="product-title">{{ $item->name }}</h6>
                                            <h6 class="product-description">{{ $item->description }}</h6>
                                            <div class="product-price">Rs {{ number_format($item->price) }}</div>
                                            <div class="product-rating mb-2">★★★★☆</div>

                                            {{-- <a class="btn btn-sm theme-btn1 w-100 gap-10"
                                                href="{{ route('single.Product', ['id' => $item->id]) }}">
                                                View
                                            </a> --}}

                                            <button class="btn btn-sm theme-btn1 w-100 gap-10"
                                                wire:click="buyNow({{ $item->id }})">
                                                Buy Now
                                            </button>

                                            <button class="btn btn-sm theme-btn1 w-100"
                                                wire:click="add({{ $item->id }})">
                                                Add to Cart
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No Products</p>
                        @endif

                    </div>

                    <div class="col-lg-12">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>


                </div>
            </div>

            <!-- end page-title -->
        </div>
    </section>
</div>
