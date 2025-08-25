<div class="col-lg-12">

    <div class="card m-t-10">
        <div class="d-flex justify-content-between align-items-center mt-3 m-3">
            <h4 class="mb-0">Sales Report</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Shop</label>
                        <select wire:model="shop_id" class="form-control">
                            <option value="">Select Shop</option>
                            @foreach ($shops as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">From</label>
                        <input type="date" wire:model="from_date" class="form-control">
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">To</label>
                        <input type="date" wire:model="to_date" class="form-control">
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label style="color: white">Actions</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" wire:click="searchOrder">Search</button>
                            <button class="btn btn-danger" wire:click="export">Export PDF</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>OrderID</th>
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Customer Email</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Purchase Price</th>
                                <th>Sales Price</th>
                                <th>Profit</th>
                                <th>Customer Address</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                                <th>Payment Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderReports as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->orderid }}</td>
                                    <td>{{ $item->customer->name }}</td>
                                    <td>{{ $item->customer->phone_number }}</td>
                                    <td>{{ $item->customer->email }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->p_price }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->price - $item->p_price }}</td>
                                    <td>{{ $item->delivery_address }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->payment_status }}</td>
                                    <td>{{ $item->payment_method }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>
