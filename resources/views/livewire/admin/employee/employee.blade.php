<div class="col-lg-12">

    <style>
        .rounded-circle.user-photo {
            height: 50px;
        }

        .modal.right .modal-dialog {
            position: fixed;
            right: 0;
            margin: 0;
            width: 300px;
            /* Adjust as needed */
            height: 100%;
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
        }


        .modal.right .modal-dialog {
            position: fixed;
            right: 0;
            margin: 0;
            width: 400px;
            /* Adjust as needed */
            height: 100%;
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
        }

        .modal.right.show .modal-dialog {
            transform: translateX(0);
        }

        .modal-backdrop {
            display: none;
            /* You already have a background color manually */
        }
    </style>
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mt-3 m-3">
            <h4 class="mb-0">Employee</h4>
            <a wire:navigate href="{{ route('admin.create.employee') }}" class="btn btn-primary">
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
                            <th>ID</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>email</th>
                            <th>CNIC</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Role</th>
                            <th>Shop</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($employe as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td wire:ignore>
                                    <img class="rounded-circle user-photo" src="{{ $item->profile ?? $dummyImage }}"
                                        alt="Employee Photo" onerror="this.src='{{ $dummyImage }}';">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone_number }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->cnic }}</td>
                                <td>{{ $item->address_line_1 }}</td>
                                <td>{{ $item->city }}</td>
                                <td>{{ $item->role }}</td>
                                <td>{{ $item->shopname->name }}</td>
                                <td>

                                    <!-- Trigger Button -->
                                    <button class="btn btn-sm btn-warning" wire:click="openModal({{ $item->id }})">
                                        <i class="icon-lock"></i>
                                    </button>

                                    <button class="btn btn-sm btn-warning"
                                        wire:click="openModalProfile({{ $item->id }})">
                                        <i class="icon-credit-card"></i>
                                        </a>
                                    </button>
                                    <a wire:navigate class="btn btn-sm btn-primary"
                                        href="{{ route('admin.edit.employee', $item->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>

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
            {{ $employe->links('pagination::bootstrap-5') }}
        </div>


        <!-- Modal -->
        @if ($showModal)
            <div class="modal right fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog">
                    <div class="modal-content h-100">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Password</h5>
                            <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                        </div>
                        <div class="modal-body overflow-auto">

                            <form wire:submit.prevent="updatePassword">


                                <div class="row">
                                    @foreach ([
        'employee_password' => 'Employee Password',
        'employee_c_password' => 'Employee Confirm Password',
    ] as $field => $label)
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>{{ $label }}</label>
                                                <input
                                                    type="{{ in_array($field, ['employee_password', 'employee_c_password']) ? 'password' : 'text' }}"
                                                    wire:model.lazy="{{ $field }}" class="form-control">
                                                @error($field)
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mt-3">
                                        <button type="submit" style="width: 200px"
                                            class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($showModalSingle)
            <div class="modal right fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog">
                    <div class="modal-content h-100 profileDetail">
                        <div class="modal-header">
                            <h5 class="modal-title">Employe Detail</h5>
                            <button type="button" class="btn-close"
                                wire:click="$set('showModalSingle', false)"></button>
                        </div>
                        <div class="modal-body overflow-auto">
                            <div class="text-center mb-3">
                                <img src="{{ $emplSingle['profile'] ?? $dummyImage }}" alt="Profile"
                                    class="rounded-circle" width="120" height="120"
                                    onerror="this.onerror=null;this.src='{{ $dummyImage }}';">
                                <h5 class="mt-2">{{ $emplSingle['name'] ?? 'N/A' }}</h5>
                                <span class="badge bg-info text-dark">{{ ucfirst($emplSingle['role']) }}</span>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <strong>Email:</strong><br>{{ $emplSingle['email'] ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Phone:</strong><br>{{ $emplSingle['phone_number'] ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>CNIC:</strong><br>{{ $emplSingle['cnic'] ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>City:</strong><br>{{ $emplSingle['city'] ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Province:</strong><br>{{ $emplSingle['province'] ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Postal Code:</strong><br>{{ $emplSingle['postal_code'] ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Address Line 1:</strong><br>{{ $emplSingle['address_line_1'] ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Address Line 2:</strong><br>{{ $emplSingle['address_line_2'] ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Connection Type:</strong><br>{{ $emplSingle['connection_type'] ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Status:</strong><br>
                                    <span class="badge bg-{{ $emplSingle['is_active'] ? 'success' : 'danger' }}">
                                        {{ $emplSingle['is_active'] ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Simple delete function -->
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Delete this employee?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Use Livewire @this.call to call method with params
                    @this.call('delete', id);
                }
            });
        }
    </script>

</div>
