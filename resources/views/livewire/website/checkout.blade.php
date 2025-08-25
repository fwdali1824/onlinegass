<div>

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

    <!-- start page-title -->
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <h2 class="mb-4">Checkout</h2>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>

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




    <div class="container py-5" style="margin-top: 50px; margin-bottom:50px;">
        <div class="row">
            <!-- Billing Details -->
            <div class="col-md-7">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (Auth::check())
                    @if (auth()->user())
                        <div class="col-md-12">
                            <div class="card shadow-sm rounded">
                                <div class="card-header text-white">
                                    <h2 class="mb-0">Billing Details</h2>
                                </div>
                                <div class="card-body" style="margin-top: 20px; margin-bottom:20px;">
                                    @include('layouts.checkout-component', [
                                        'id' => $id,
                                        'quantity' => $quantity,
                                        'customUrl' => $customUrl,
                                    ])
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="col-md-11">
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
            </div>

            <!-- Order Summary -->
            <div class="col-md-5">
                <div class="order-summary shadow-sm p-3 bg-white rounded">
                    <h5 class="mb-3">Your Order</h5>

                    <ul class="list-group mb-3">
                        @php $total = 0; @endphp

                        @foreach ($cart as $item)
                            @php
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            @endphp
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <img style="width: 100px" src="{{ $item['image'] }}" alt="">
                                    <h6 class="my-0">{{ $item['name'] }}</h6>
                                    <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                                </div>
                                <span class="text-muted">Rs {{ number_format($subtotal, 0) }}</span>
                            </li>
                        @endforeach

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total</span>
                            <strong>Rs {{ number_format($total, 0) }}</strong>
                        </li>
                    </ul>

                    {{-- <button wire:click="placeOrder" class="btn btn-primary w-100">Place Order</button> --}}
                </div>

            </div>

        </div>
    </div>

    {{-- Success is as dangerous as failure. --}}
</div>
