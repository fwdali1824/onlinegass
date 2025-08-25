{{-- Main Content --}}
<div class="col-md-9" style="margin-top: 50px">
    {{-- Summary Cards --}}
    <style>
        .dashboard-summary {
            display: flex;
            gap: 20px;
            margin-bottom: 50px;
            flex-wrap: wrap;
        }

        .summary-card {
            flex: 1;
            min-width: 250px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 20px;
            text-align: center;
            transition: 0.3s;
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .summary-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            display: inline-block;
        }

        .summary-title {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: #222;
        }

        .icon-blue {
            color: #007bff;
        }

        .icon-green {
            color: #28a745;
        }

        .icon-orange {
            color: #fd7e14;
        }

        .custom-header {
            background: linear-gradient(to right, #c7aa08, #dbf514);
            color: white;
            padding: 15px 20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0;
        }

        .custom-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            background-color: #fff;
            margin-bottom: 30px;
        }
    </style>

    <div class="dashboard-summary">
        <div class="summary-card">
            <div class="summary-icon icon-blue">
                <i class="bi bi-bag-check-fill"></i>
            </div>
            <div class="summary-title">Total Orders</div>
            <div class="summary-value">{{ $totalOrders }}</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon icon-green">
                <i class="bi bi-wallet2"></i>
            </div>
            <div class="summary-title">Wallet Balance</div>
            <div class="summary-value">Rs {{ number_format($walletBalance, 2) }}</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon icon-orange">
                <i class="bi bi-repeat"></i>
            </div>
            <div class="summary-title">Transactions</div>
            <div class="summary-value">{{ $transactionCount }}</div>
        </div>
    </div>

    {{-- Latest Order Summary --}}
    <div class="custom-card">
        <div class="custom-header">
            Latest Order Summary
        </div>
        <div class="card-body">
            @if ($lastOrder)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                <th>Payment Status</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $lastOrder->product->name ?? 'N/A' }}</td>
                                <td>{{ $lastOrder->quantity }}</td>
                                <td>Rs {{ $lastOrder->total_amount }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $lastOrder->payment_status === 'paid' ? 'success' : 'danger' }}">
                                        {{ ucfirst($lastOrder->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ ucfirst(str_replace('_', ' ', $lastOrder->status)) }}
                                    </span>
                                </td>
                                <td>{{ $lastOrder->created_at->format('d M, Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">You have not placed any orders yet.</div>
            @endif
        </div>
    </div>

    {{-- Wallet Transaction Summary --}}
    <div class="custom-card">
        <div class="custom-header" style="background: linear-gradient(to right, #0f9d58, #34a853);">
            Wallet Transaction Summary
        </div>

        <div class="card-body">
            @if ($transactions->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Account Name</th>
                                <th>Account No.</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $index => $transaction)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $transaction->transaction_id ?? 'N/A' }}</td>
                                    <td>Rs {{ number_format($transaction->amount, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $transaction->type === 'topup' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->acount_name ?? 'N/A' }}</td>
                                    <td>{{ $transaction->acount_number ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M, Y h:i A') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning mb-0">No transactions found.</div>
            @endif
        </div>
    </div>
</div>
