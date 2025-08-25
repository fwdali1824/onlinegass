<div class="col-md-12" style="margin-top: 50px">
    <div class="table-responsive">
        <h5>
            Notifications
        </h5>
        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>From Users</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->sender->name }}</td>
                        <td>
                            {{ $item->notification->message }}
                        </td>
                    </tr>
                @endforeach

                @if ($notifications->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center text-muted">Not found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
