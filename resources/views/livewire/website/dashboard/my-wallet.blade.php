<div class="col-md-12" style="margin-top: 50px">
    <h4>Wallet Balance: Rs {{ $userWallet->balance ?? '0.00' }}</h4>

    @if (session()->has('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    {{-- Top-up Form --}}
    <form wire:submit.prevent="topUp" class="my-4">
        <div class="mb-3">
            <label for="amount" class="form-label">Top-up Amount</label>
            <input type="number" wire:model.lazy="amount" class="form-control" id="amount" min="1"
                placeholder="Enter amount">
            @error('amount')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Top Up</button>
    </form>

    {{-- Transactions Table --}}
    <div class="table-responsive mt-5">
        <h5>Transaction History</h5>
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $txn)
                    <tr>
                        <td>{{ $txn->id }}</td>
                        <td>{{ $txn->transaction_id }}</td>
                        <td>Rs {{ number_format($txn->amount, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $txn->type === 'topup' ? 'success' : 'secondary' }}">
                                {{ ucfirst($txn->type) }}
                            </span>
                        </td>
                        <td>{{ $txn->created_at->format('d M, Y h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
