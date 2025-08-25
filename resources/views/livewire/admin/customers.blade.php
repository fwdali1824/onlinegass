<div class="col-lg-12">

    <div class="card">
        <div class="d-flex justify-content-between align-items-center mt-3 m-3">
            <h4 class="mb-0">Customers</h4>
            {{-- <a wire:navigate href="{{ route('admin.create.customers') }}" class="btn btn-primary">
                Add New
            </a> --}}
        </div>
    </div>
    <div class="card">

        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>email</th>
                            <th>CNIC</th>
                            <th>Address 1</th>
                            <th>Address 2</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($users as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone_number }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->cnic }}</td>
                                <td>{{ $item->address_line_1 }}</td>
                                <td>{{ $item->address_line_2 }}</td>
                                <td>

                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
