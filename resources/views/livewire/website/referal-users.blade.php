<div class="col-md-12" style="margin-top: 50px">
    <h5>
        My Referral Link:
        <span id="referral-link" class="text-primary">
            {{ url('/user-register?ref=' . Auth::user()->referal_code) }}
        </span>
        <button onclick="copyReferralLink()" class="btn btn-sm btn-outline-secondary" title="Copy to clipboard">
            <i class="bi bi-clipboard"></i>
        </button>
    </h5>

    <div class="table-responsive">


        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Profile</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Referal Code</th>
                </tr>
            </thead>
            <tbody>
                {{-- Example static row, replace with @foreach --}}
                @foreach ($referal as $index => $item)
                    @isset($item->user)
                        <tr>
                            <td>
                                @isset($item->user)
                                    <img src="{{ $item->user->profile }}" alt="" width="50px">
                                @endisset
                            </td>
                            <td> @isset($item->user)
                                    {{ $item->user->name }}
                                @endisset
                            </td>
                            <td> @isset($item->user)
                                    {{ $item->user->email }}
                                @endisset
                            </td>
                            <td> @isset($item->user)
                                    {{ $item->user->phone_number }}
                                @endisset
                            </td>
                            <td> @isset($item->user)
                                    {{ $item->user->referal_code }}
                                @endisset
                            </td>
                        </tr>
                    @endisset
                @endforeach

                {{-- If no orders --}}
                @if ($referal->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center text-muted">Not found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <script>
        function copyReferralLink() {
            const text = document.getElementById('referral-link').innerText;
            navigator.clipboard.writeText(text)
                .then(() => alert('Referral link copied!'))
                .catch(() => alert('Failed to copy'));
        }
    </script>

</div>
