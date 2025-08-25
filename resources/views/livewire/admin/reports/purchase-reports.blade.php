<div class="col-lg-12">

    <div class="card m-t-10">
        <div class="d-flex justify-content-between align-items-center mt-3 m-3">
            <h4 class="mb-0">Stock Purchase Report</h4>
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
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Purchase Price</th>
                                <th>Sales Price</th>
                                <th>Profit</th>
                                <th>Shop Name</th>
                                <th>Purchaser Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalQty = 0;
                                $totalPPrice = 0;
                                $totalPrice = 0;
                                $totalProfit = 0;
                            @endphp

                            @foreach ($orderReports as $item)
                                @php
                                    $totalQty += $item->qty;
                                    $totalPPrice += $item->p_price;
                                    $totalPrice += $item->price;
                                    $totalProfit += $item->price - $item->p_price;
                                @endphp
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->p_price }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->price - $item->p_price }}</td>
                                    <td>{{ $item->productshop->name ?? 'N/A' }}</td>
                                    <td>{{ $item->user->name ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="font-bold text-black bg-gray-200">
                            <tr>
                                <td colspan="2">Total</td>
                                <td>{{ $totalQty }}</td>
                                <td>{{ number_format($totalPPrice) }}</td>
                                <td>{{ number_format($totalPrice) }}</td>
                                <td>{{ number_format($totalProfit) }}</td>
                                <td colspan="1"></td>
                                <td colspan="1"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>
