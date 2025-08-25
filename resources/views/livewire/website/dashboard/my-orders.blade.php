<div class="col-md-12" style="margin-top: 50px">
    <div class="table-responsive">

        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price (per unit)</th>
                    <th>Total Price</th>
                    <th>Payment Status</th>
                    <th>Delivery Date</th>
                    <th>Order ID</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                {{-- Example static row, replace with @foreach --}}
                @foreach ($orders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>Rs {{ $order->price }}</td>
                        <td>Rs {{ $order->total_amount }}</td>
                        <td>
                            <span
                                class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'partial' ? 'warning' : 'danger') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M, Y') }}</td>
                        <td>{{ $order->orderid }}</td>
                        <td>
                            <span
                                class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                        </td>
                    </tr>
                @endforeach

                {{-- If no orders --}}
                @if ($orders->isEmpty())
                    <tr>
                        <td colspan="9" class="text-center text-muted">No orders found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
