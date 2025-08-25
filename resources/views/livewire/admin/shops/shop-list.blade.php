<div class="col-lg-12 mt-4">
    <style>
        .rounded-circle.user-photo {
            height: 50px;
        }

        .modal.right .modal-dialog {
            position: fixed;
            top: 0;
            right: 0;
            margin: 0;
            width: 99vw;
            /* changed from 100vh */
            height: 100vh;
            /* full viewport height */
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
            max-width: 100vw;
            /* prevent Bootstrap overriding width */
        }


        .modal.right.show .modal-dialog {
            transform: translateX(0);
        }

        .modal-backdrop {
            display: none;
        }
    </style>

    <div class="card">
        <div class="d-flex justify-content-between align-items-center mt-3 m-3">
            <h4 class="mb-0">Shop</h4>
            <a href="{{ route('admin.manage.shops.create') }}" class="btn btn-primary">
                Add New
            </a>
        </div>
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
    <div class="card">

        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Whats App</th>
                            <th>Today Price</th>
                            <th>Open/Close Time</th>
                            {{-- <th width="100">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productList as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->address }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->whatsapp }}</td>
                                <td>{{ $item->today_rate }}</td>
                                <td>{{ $item->time }}</td>
                                {{-- <td>
                                    <button class="btn btn-sm btn-primary" wire:click="editModal({{ $item->id }})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-12">
            {{ $productList->links('pagination::bootstrap-5') }}
        </div>

        <!-- Modal -->
        @if ($showModal)
            <div class="modal right fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog show">
                    <div class="modal-content h-100">
                        <div class="modal-header">
                            <h5 class="modal-title">Create Shop</h5>
                            <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                        </div>
                        @if ($showModal)
                            <div class="modal-body overflow-auto" wire:ignore>
                                @include('layouts.ShopLocations')
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Delete this product category?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', id);
                }
            });
        }
    </script>

    <script>
        document.addEventListener("livewire:load", () => {

        });
    </script>
</div>
