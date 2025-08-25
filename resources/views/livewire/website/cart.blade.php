<div>
  <!-- start page-title -->
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <h2 class="mb-4">Cart</h2>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>

    <style>
        .cart-img {
            width: 80px;
            height: 45px;
            object-fit: cover;
        }

        .remove-btn {
            color: red;
            cursor: pointer;
        }

        .quantity-box {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .quantity-input {
            width: 45px;
            text-align: center;
        }
    </style>

    <div class="container py-5" style="margin-top: 50px; margin-bottom:50px;">
        {{-- <h2 class="mb-4">Shopping Cart</h2> --}}

        <div class="row justify-content-end">
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cart as $id => $item)
                                <tr>
                                    <td><img src="{{ $item['image'] }}" class="cart-img rounded"
                                            alt="{{ $item['name'] }}"></td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>Rs {{ number_format($item['price']) }}</td>
                                    <td>
                                        <div class="quantity-box">
                                            <button class="btn btn-sm btn-outline-secondary"
                                                wire:click="decrement({{ $id }})">−</button>
                                            <input type="text" value="{{ $item['quantity'] }}"
                                                class="form-control quantity-input" disabled>
                                            <button class="btn btn-sm btn-outline-secondary"
                                                wire:click="increment({{ $id }})">+</button>
                                        </div>
                                    </td>
                                    <td>Rs {{ number_format($item['price'] * $item['quantity']) }}</td>
                                    <td><span class="remove-btn" wire:click="remove({{ $id }})">&times;</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Your cart is empty.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total Section -->
            <div class="col-md-4">
                @php
                    $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
                @endphp
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Subtotal</span>
                        <strong>Rs {{ number_format($subtotal, 2) }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong>Rs {{ number_format($subtotal, 2) }}</strong>
                    </li>
                </ul>
                @if ($subtotal > 0)
                    <a href="{{ route('checkout') }}" class="btn theme-btn w-100">Proceed to Checkout</a>
                @endif
            </div>
        </div>
    </div>
</div>
