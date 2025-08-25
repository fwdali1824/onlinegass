<div class="col-lg-12">


    <style>
        .rounded-circle.user-photo {
            height: 50px;
        }

        .modal.right .modal-dialog {
            position: fixed;
            right: 0;
            margin: 0;
            width: 300px;
            /* Adjust as needed */
            height: 100%;
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
        }


        .modal.right .modal-dialog {
            position: fixed;
            right: 0;
            margin: 0;
            width: 400px;
            /* Adjust as needed */
            height: 100%;
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
        }

        .modal.right.show .modal-dialog {
            transform: translateX(0);
        }

        .modal-backdrop {
            display: none;
            /* You already have a background color manually */
        }
    </style>
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mt-3 m-3">
            <h2 class="mb-0">Pending Order</h2>
        </div>

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


        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover ">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Product</th>
                            <th>Quntity</th>
                            <th>Price</th>
                            <th>Total Price</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th>Delivery Date</th>
                            <th>Address</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->orderid }}</td>
                                <td>{{ $item->customer->name }}</td>
                                <td>{{ $item->customer->phone_number }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->total_amount }}</td>
                                <td>{{ $item->payment_status }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->delivery_address }}</td>
                                <td>{{ $item->delivery_date }}</td>
                                <td>{{ $item->notes }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary"
                                        wire:click="openModalProfile({{ $item->id }})">
                                        <i class="fa fa-inbox" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <div class="col-lg-12">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>



        @if ($showModalSingle)
            <div class="modal right fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog">
                    <div class="modal-content h-100 profileDetail">
                        <div class="modal-header">
                            <h5 class="modal-title">Order Detail</h5>
                            <button type="button" class="btn-close"
                                wire:click="$set('showModalSingle', false)"></button>
                        </div>
                        <div class="modal-body overflow-auto">

                            <img style="border: 1px solid gray;"
                                src="{{ $productList->product->image ?? $dummyImage }}" alt="Profile" width="150"
                                height="150" onerror="this.onerror=null;this.src='{{ $dummyImage }}';">
                            <br><br>

                            <table class="table table-bordered table-striped table-hover ">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <td>{{ $productList->product->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer Name</th>
                                        <td>{{ $productList->customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer Phone</th>
                                        <td>{{ $productList->customer->phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer Delivery Address</th>
                                        <td>{{ $productList->delivery_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order ID</th>
                                        <td>{{ $productList->orderid }}</td>

                                    </tr>
                                    <tr>
                                        <th>Order Status</th>
                                        <td>{{ $productList->status }}</td>

                                    </tr>
                                </thead>
                            </table>

                            <h5>Assign To Delivery</h5>
                            <form wire:submit.prevent="assignDelivery">
                                <div class="form-group">
                                    <label for="">Delivery Persons</label>
                                    <select name="delivery_person_id" id="delivery_person_id" class="form-control"
                                        wire:model="deliveryPersonId">
                                        <option value="">Please Select</option>
                                        @foreach ($userDelivery as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>



</div>
