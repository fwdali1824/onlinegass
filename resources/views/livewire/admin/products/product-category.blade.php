<div class="col-lg-12">


    <style>
        .rounded-circle.user-photo {
            height: 50px;
        }

        .modal.right .modal-dialog {
            position: fixed;
            right: 0;
            top: 0;
            margin: 0;
            width: 400px;
            height: 100%;
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
        }

        .modal.right.show .modal-dialog {
            transform: translateX(0);
        }

        .modal-backdrop {
            display: none;
        }

        img {
            vertical-align: middle;
            border-style: none;
            width: 47px;
        }

        img.imageProduct {
            max-width: 200px;
            width: 200px;
        }
    </style>

    <div class="card">
        <div class="d-flex justify-content-between align-items-center mt-3 m-3">
            <h4 class="mb-0">Product Category</h4>
            <button wire:click="openModal" class="btn btn-primary">
                Add New
            </button>
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
                            <th>Images</th>
                            <th>Name</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productList as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><img src="{{ $item->image }}" alt=""></td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" wire:click="editModal({{ $item->id }})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-12">
            {{ $productList->links('pagination::bootstrap-4') }}
        </div>

        <!-- Modal -->
        @if ($showModal)
            <div class="modal right fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog show">
                    <div class="modal-content h-100">
                        <div class="modal-header">
                            <h5 class="modal-title">Create Product Category</h5>
                            <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                        </div>
                        <div class="modal-body overflow-auto">
                            <form wire:submit.prevent="save">

                                <div class="row">
                                    <div class="col-md-2">
                                        @if ($image)
                                            <div class="mt-2 position-relative">
                                                @if ($image)
                                                    <img class="imageProduct rounded-circle user-photo" src="{{ $image->temporaryUrl() }}">
                                                @elseif ($Editimage)
                                                    <img class="imageProduct" src="{{ $Editimage }}">
                                                @endif
                                                <button type="button" wire:click="removeImage"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0">
                                                    &times;
                                                </button>
                                            </div>
                                        @else
                                            <div class="mt-2 position-relative">
                                                <img class="imageProduct" src="{{ $Editimage }}">
                                                @if ($Editimage)
                                                    <button type="button" wire:click="removeImage"
                                                        class="btn btn-sm btn-danger position-absolute top-0 end-0">
                                                        &times;
                                                    </button>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if (!$image)
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label>Image</label>
                                                <input type="file" wire:model="image" class="form-control"
                                                    accept="image/*">

                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label>Product Category Name</label>
                                            <input type="text" wire:model.lazy="name" class="form-control">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary w-100">Save</button>
                                </div>
                            </form>
                        </div>
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
</div>
