<div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .product-card {
            position: relative;
            overflow: hidden;
            border: none;
            border-radius: 12px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 347px;
            margin: 5px;
            align-items: center;
            display: flex;
            flex-direction: row;
            align-content: center;
            flex-wrap: nowrap;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .product-card img {
            height: 220px;
            width: 200px;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .card-body {
            text-align: left;
        }

        .product-title {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .product-description {
            font-size: 12px;
            font-weight: 500;
            color: #777;
            margin-bottom: 8px;
        }

        .product-price {
            color: #198754;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .product-rating {
            color: #ffc107;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .product-actions {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: opacity 0.3s ease, visibility 0.3s ease;
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

        .theme-btn1 {
            display: none;
        }
    </style>

    <!-- start page-title -->
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <h2 class="mb-4">{{ $shops->name }} Products</h2>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>

    <section class="ct-section">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="container" style="margin-top: 20px">
            <div class="row g-4">
                <!-- Shop Time Card -->
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h2 class="card-text text-primary fw-bold">
                                Timings: {{ $shops->time }}
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Today's Rate Card with Styled Marquee -->
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-0">
                            <marquee behavior="scroll" direction="left" scrollamount="5"
                                class="bg-success text-white fw-bold" style="height: 25px; line-height: 25px;">
                                Current LPG Price: {{ $shops->today_rate }}
                            </marquee>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Product Card -->
        @if ($products->count())
            @foreach ($products as $item)
                <div class="col-md-6 col-lg-4 col-sm-6 p-4 mt-5" style="margin-top: 20px">
                    <div class="card product-card shadow-sm">
                        <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}">

                        <div class="card-body">
                            <h6 class="product-title">{{ $item->name }}</h6>
                            <h6 class="product-description">{{ $item->description }}</h6>
                            <div class="product-price">Rs {{ number_format($item->price) }}</div>
                        </div>

                        <!-- Actions on hover -->
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
            <div class="container" style="margin-top: 50px">
                <p>No Products</p>
            </div>
        @endif

        <div class="col-lg-12">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>

    </section>


</div>
