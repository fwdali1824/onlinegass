<div>
    <style>
        body {
            background-color: #f6f9fc;
            color: #525f7f;
        }

        .product-card {
            border-radius: 0.4rem;
            transition: 0.3s;
            border: 2px solid #e6ebf1;
            background-color: #e6ebf1;
        }

        .product-card:hover {
            background-color: white;
            border-color: #00bc81;
            transform: scale(1.02);
        }

        .product-img {
            height: 160px;
            object-fit: cover;
            border-radius: 0.4rem 0.4rem 0 0;
        }

        .add-icon svg {
            width: 24px;
            height: 24px;
            fill: #00bc81;
            transition: transform 0.2s;
        }

        .product-card:hover .add-icon svg {
            transform: scale(1.4);
        }

        .cart-section {
            background: white;
            height: 100vh;
            overflow-y: auto;
        }

        .confirm-btn {
            background-color: #00bc81;
            color: white;
        }

        .category-btns button.active {
            background-color: #525f7f;
            color: white;
        }

        .category-btns {
            position: fixed;
            bottom: 1rem;
            left: 1rem;
            right: 22rem;
            z-index: 10;
        }

        @media (max-width: 768px) {
            .category-btns {
                right: 1rem;
            }
        }
    </style>


    <div class="container-fluid">
        <div class="row" style="background: #ebebeb; padding: 10px;">
            <div class="col-lg-12">
                {{-- <a href="{{route('home')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> --}}
            </div>
        </div>
        <div class="row">
            <!-- Products -->
            <div class="col-md-8 p-3">
                <!-- Category Buttons -->
                <div class="d-flex gap-2 flex-wrap mb-3">
                    @foreach ($productCategory as $category)
                        <button wire:click="selectCategory({{ $category->id }})"
                            class="btn {{ $selectedCategory == $category->id ? 'btn-primary' : 'btn-light' }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Search -->
                <input type="text" class="form-control mb-3" placeholder="Search items...">

                <!-- Product Grid -->
                <div class="row row-cols-1 row-cols-md-3 g-3">
                    @foreach ($products as $product)
                        <div class="col" wire:click="addToCart({{ $product->id }})" style="cursor: pointer">
                            <div class="border rounded p-2 h-100 d-flex flex-column">
                                <img src="{{ $product->image }}" class="img-fluid" alt="{{ $product->name }}">
                                <h6 class="mt-2 mb-1">{{ $product->name }}</h6>
                                <small class="text-muted mb-2">{{ $product->description }}</small>
                                <div class="d-flex justify-content-between fw-bold mb-2">
                                    <span>Rs {{ number_format($product->price) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Cart -->
            <div class="col-md-4 bg-white p-3 border-start" style="height: 100vh">
                <header class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h5 class="mb-0">
                        Current Order:
                        <small class="text-muted">{{ $currentTime }}</small>
                    </h5>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="offcanvas"
                            data-bs-target="#createCustomerCanvas">
                            + Add Customer
                        </button>

                    </div>

                </header>

                <!-- Customer Select -->
                <div class="mb-3">
                    <label for="customer" class="form-label">Select Customer</label>
                    <select wire:model="selectedCustomerId" id="customer" class="form-select">
                        <option value="">Select Customer</option>
                        @foreach ($customers as $cust)
                            <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                        @endforeach
                    </select>

                    @error('selectedCustomerId')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Cart Items -->
                <ul class="list-unstyled">
                    @php
                        $totalQty = 0;
                        $totalPrice = 0;
                    @endphp
                    @forelse ($cart as $item)
                        @php
                            $totalQty += $item['quantity'];
                            $totalPrice += $item['price'] * $item['quantity'];
                        @endphp
                        <li class="d-flex align-items-center mb-3 border-bottom pb-2">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $item['name'] }}</h6>
                                <div class="d-flex align-items-center gap-2">
                                    <button wire:click="decreaseQuantity({{ $item['id'] }})"
                                        class="btn btn-sm btn-danger">-</button>
                                    <span>{{ $item['quantity'] }}</span>
                                    <button wire:click="increaseQuantity({{ $item['id'] }})"
                                        class="btn btn-sm btn-success">+</button>
                                </div>
                            </div>
                            <strong>Rs {{ number_format($item['price'] * $item['quantity']) }}</strong>
                        </li>
                    @empty
                        <li class="text-muted text-center">Cart is empty</li>
                    @endforelse

                    @if ($totalQty > 0)
                        <li class="d-flex justify-content-between mt-3">
                            <strong>Total Quantity:</strong>
                            <span>{{ $totalQty }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <strong>Total Price:</strong>
                            <span>Rs {{ number_format($totalPrice) }}</span>
                        </li>
                    @endif
                </ul>

                <!-- Confirm Button -->
                @if (!empty($cart))
                    <button wire:click="confirmOrder" class="btn btn-success w-100 py-3 mt-3 fs-5">
                        Confirm Order
                        <span class="float-end">Rs {{ number_format($this->getTotal()) }}</span>
                    </button>
                @endif
            </div>
        </div>
    </div>


    <!-- Offcanvas Add Customer -->
    <div wire:ignore.self class="offcanvas offcanvas-start" style="width: 100%;" tabindex="-1"
        id="createCustomerCanvas" aria-labelledby="createCustomerCanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="createCustomerCanvasLabel">Add New Customer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="createCustomer" class="offcanvas-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Profile Image</label>
                    <input wire:model.defer="customerForm.profile" type="file" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input wire:model.defer="customerForm.name" type="text" class="form-control" required>
                </div>



                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input wire:model.defer="customerForm.email" type="email" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Password</label>
                    <input wire:model.defer="customerForm.password" type="password" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Phone Number</label>
                    <input wire:model.defer="customerForm.phone_number" type="text" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>CNIC</label>
                    <input wire:model.defer="customerForm.cnic" type="text" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Address Line 1</label>
                    <input wire:model.defer="customerForm.address_line_1" type="text" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Address Line 2</label>
                    <input wire:model.defer="customerForm.address_line_2" type="text" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>City</label>
                    <input wire:model.defer="customerForm.city" type="text" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Postal Code</label>
                    <input wire:model.defer="customerForm.postal_code" type="text" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="d-block">Active</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" wire:model.defer="customerForm.is_active" type="checkbox"
                            id="activeSwitch">
                        <label class="form-check-label" for="activeSwitch">Yes</label>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary w-100">Create Customer</button>
                </div>
            </div>
        </form>

    </div>



    <script>
        Livewire.on('closeModal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('createCustomerModal'));
            modal.hide();
        });
    </script>


</div>
