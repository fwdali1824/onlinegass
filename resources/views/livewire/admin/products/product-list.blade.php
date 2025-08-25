<div class="col-lg-12">

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

        img.img-fluid.rounded {
            width: 1000px;
            max-width: 140px;
        }
    </style>

    <div class="card">
        <div class="d-flex justify-content-between align-items-center mt-3 m-3">
            <h4 class="mb-0">Product/Stocks</h4>
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
                            <th>image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Weight</th>
                            <th>Price</th>
                            <th>Purchase Price</th>
                            <th>Stock</th>
                            <th>Description</th>
                            <th>Shop Name</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productList as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td wire:ignore>
                                    <img class="rounded-circle user-photo" src="{{ $item->image ?? $dummyImage }}"
                                        alt="Employee Photo" onerror="this.src='{{ $dummyImage }}';">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->productcategory ? $item->productcategory->name : '' }}</td>
                                <td>{{ $item->weight }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->p_price }}</td>
                                <td>{{ $item->stock }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->productshop->name }}</td>
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
            {{-- {{ $productList->links('pagination::bootstrap-5') }} --}}
        </div>

        <!-- Modal -->
        @if ($showModal)
            <div class="modal right fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog show">
                    <div class="modal-content h-100">
                        <div class="modal-header">
                            <h5 class="modal-title">Create Product</h5>
                            <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                        </div>
                        <div class="modal-body overflow-auto">
                            <form wire:submit.prevent="save">
                                <div class="row">
                                    <div class="col-md-2">
                                        @if ($image)
                                            <div class="mt-2 position-relative">
                                                @if ($image && !$editId)
                                                    {{-- Show temporary preview for newly uploaded image --}}
                                                    <img src="{{ $image->temporaryUrl() }}" class="img-fluid rounded"
                                                        style="max-height: 150px;">
                                                @elseif ($editId && $image)
                                                    @if ($image instanceof \Livewire\TemporaryUploadedFile)
                                                        <img src="{{ $image->temporaryUrl() }}"
                                                            class="img-fluid rounded" style="max-height: 150px;">
                                                    @else
                                                        <img src="{{ $image }}" class="img-fluid rounded"
                                                            style="max-height: 150px;">
                                                    @endif
                                                    {{-- Show existing saved image --}}
                                                    <img src="{{ $image }}" class="img-fluid rounded"
                                                        style="max-height: 150px;">
                                                @else
                                                    {{-- Show a placeholder or nothing --}}
                                                    <img src="https://sclpa.com/wp-content/uploads/2022/10/dummy-img-1.jpg"
                                                        class="img-fluid rounded" style="max-height: 150px;">
                                                @endif


                                                <button type="button" wire:click="removeImage"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0">
                                                    &times;
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Image</label>
                                        <input type="file" wire:model="image" class="form-control" accept="image/*">

                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 mb-3">
                                        <label>Product Name</label>
                                        <input type="text" wire:model.lazy="name" class="form-control">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Product Category</label>
                                        <select wire:model.lazy="product_category" class="form-control">
                                            <option value="">Select Product Category</option>
                                            @foreach ($productcategory as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('product_category')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    @if (!$editId)
                                        <div class="col-md-4 mb-3">
                                            <label>Weight</label>
                                            <input type="text" wire:model.lazy="weight" class="form-control">
                                            @error('weight')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Price</label>
                                            <input type="number" wire:model.lazy="price" class="form-control">
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Purchase Price</label>
                                            <input type="number" wire:model.lazy="p_price" class="form-control">
                                            @error('p_price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Stock</label>
                                            <input type="number" wire:model.lazy="stock" class="form-control">
                                            @error('stock')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif

                                    <div class="col-md-4 mb-3">
                                        <label>Is Cylinder?</label>
                                        <select wire:model.lazy="is_cylinder" class="form-control">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        @error('is_cylinder')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Cylinder Type</label>
                                        <select wire:model.lazy="cylinder_type" class="form-control">
                                            <option value="domestic">Domestic</option>
                                            <option value="commercial">Commercial</option>
                                            <option value="industrial">Industrial</option>
                                        </select>
                                        @error('cylinder_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Cylinder Material</label>
                                        <input type="text" wire:model.lazy="cylinder_material"
                                            class="form-control">
                                        @error('cylinder_material')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Cylinder Capacity</label>
                                        <input type="text" wire:model.lazy="cylinder_capacity"
                                            class="form-control">
                                        @error('cylinder_capacity')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Cylinder Pressure</label>
                                        <input type="text" wire:model.lazy="cylinder_pressure"
                                            class="form-control">
                                        @error('cylinder_pressure')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Status</label>
                                        <select wire:model.lazy="status" class="form-control">
                                            <option value="active">Active</option>
                                            <option value="discontinued">Discontinued</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Shop</label>
                                        <select wire:model="shop" class="form-control">
                                            <option value="">Select Shop</option>
                                            @foreach ($shopList as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('shop')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label fw-semibold">Description</label>
                                        <textarea wire:model.lazy="description" id="description"
                                            class="form-control @error('description') is-invalid @enderror" rows="6"
                                            placeholder="Enter a detailed description..."></textarea>

                                        @error('description')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>




                                <div class="mt-4 text-end">
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
