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
            height: 100vh;
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
            max-width: 50vw;
        }


        .modal.right.show .modal-dialog {
            transform: translateX(0);
        }

        .modal-backdrop {
            display: none;
        }
    </style>
    <br>
    <div class="card pt-10">
        <div class="d-flex justify-content-between align-items-center mt-3 m-3">
            <h4 class="mb-0">Stocks Purchase</h4>
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
                <table class="table table-bordered table-striped table-hover">
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
                            <th>Shop Name</th>
                            <th>User Name</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productList as $index => $item)
                            @php
                                $productCategory = DB::table('product_categories')
                                    ->where('id', $item->product->product_category)
                                    ->first();
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td wire:ignore>
                                    <img class="rounded-circle user-photo" src="{{ $item->product->image ?? $dummyImage }}"
                                        alt="Employee Photo" onerror="this.src='{{ $dummyImage }}';"
                                        style="width: 49px;">
                                </td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $productCategory->name ?: '' }}</td>
                                <td>{{ $item->weight }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->p_price }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->productshop->name }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" wire:click="editModal({{ $item->id }})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        @if ($showModal)
            <div class="modal right fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog show">
                    <div class="modal-content h-100">
                        <div class="modal-header">
                            <h5 class="modal-title">Stock Purchase</h5>
                            <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                        </div>
                        <div class="modal-body overflow-auto">
                            <form wire:submit.prevent="save">

                                <div class="row mb-3">

                                    <div class="col-md-4 mb-3">
                                        <label>Product Category</label>
                                        <select wire:model.lazy="productid" class="form-control">
                                            <option value="">Select Product</option>
                                            @foreach ($stocksPurchase as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('product_category')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



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
</div>
