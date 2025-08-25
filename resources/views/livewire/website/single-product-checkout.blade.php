<div>
    <style>
        .invalid-feedback {
            color: red;
        }

        .col-md-6.mb-3 {
            margin-top: 12px;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v10.1.0/ol.css">
    <script src="https://cdn.jsdelivr.net/npm/ol@v10.1.0/dist/ol.js"></script>
    <script src="https://unpkg.com/ol-mapbox-style@12.1.1/dist/olms.js"></script>

    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 8px;
        }

        #searchBox {
            margin-bottom: 10px;
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        .autocomplete-result {
            background: white;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            z-index: 9999;
            width: 100%;
        }

        .autocomplete-result div {
            padding: 8px;
            cursor: pointer;
        }

        .autocomplete-result div:hover {
            background-color: #f1f1f1;
        }
    </style>


    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: #4e73df;
        }

        .order-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 0.5rem;
        }

        .invalid-feedback {
            color: red;
        }

        .col-md-6.mb-3 {
            margin-top: 12px;
        }
    </style>
    <!-- start page-title -->
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <h2 class="mb-4">Checkout Product</h2>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>

    <div>
        <div class="container py-5" style="margin-top: 20px; margin-bottom:20px;">
            <div class="row g-5">

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if (Auth::check())
                    @if (auth()->user())
                        <div class="col-md-8">
                            <div class="card shadow-sm rounded">
                                <div class="card-header text-white">
                                    <h2 class="mb-0">Billing Details</h2>
                                </div>
                                <div class="card-body" style="margin-top: 20px; margin-bottom:20px;">
                                    @include('layouts.checkout-component', [
                                        'id' => $id,
                                        'quantity' => $quantity,
                                        'shop' => $shop,
                                        'customUrl' => $customUrl,
                                    ])
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="col-md-8">
                        <div class="card shadow-sm rounded">
                            <div class="card-body" style="margin-top: 20px">
                                <button wire:click="Login()" class="theme-btn">Login</button>
                                <button wire:click="Register()" class="theme-btn">Register</button>
                                @if ($login)
                                    @livewire('website.auth.website.login-website', ['id' => $id, 'quantity' => $quantity, 'customUrl' => $customUrl])
                                @else
                                    @livewire('website.auth.website.register-website', ['id' => $id, 'quantity' => $quantity, 'customUrl' => $customUrl])
                                @endif
                            </div>
                        </div>
                    </div>
                @endif


                {{-- Billing Information --}}


                {{-- Order Summary --}}
                <div class="col-md-3">
                    <div class="card shadow-sm rounded">
                        <div class="card-header bg-dark text-white">
                            <h2 class="mb-0">Order Summary</h2>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <img style="width: 100px" src="{{ $product->image }}" alt="">
                                    <br><br>
                                    <strong>{{ $product['name'] }}</strong>
                                    <div class="text-muted">{{ $product->price }}x{{ $qty }}</div>
                                </div>
                                <div>Rs {{ number_format($product['price'] * $qty) }}</div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mt-3">
                                <strong>Total</strong>
                                {{ number_format($product['price'] * $qty) }}
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



</div>
