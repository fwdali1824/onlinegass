<div class="col-lg-12">


    <div class="card p-4">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="save" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        @if ($employee_profile)
                            {{-- Show preview if a new image is selected --}}
                            @if (is_string($employee_profile))
                                {{-- Existing profile from database --}}
                                <div class="col-lg-4">

                                    <div class="position-relative mb-2">
                                        <img src="{{ $employee_profile }}" class="img-thumbnail" width="120">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0"
                                            wire:click="removeImage">X</button>
                                    </div>
                                </div>
                            @else
                                {{-- Temporary preview for uploaded file --}}
                                <div class="mb-2">
                                    <img src="{{ $employee_profile->temporaryUrl() }}" class="img-thumbnail"
                                        width="120">
                                </div>
                            @endif
                        @endif
                        <label>Employee Profile</label>
                        <input type="file" wire:model="employee_profile" class="form-control">
                        @error('employee_profile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ([
        'employee_name' => 'Employee Name',
        'employee_email' => 'Employee Email',
        'employee_phone' => 'Employee Phone',
        'employee_cnic' => 'Employee CNIC',
        'employee_address1' => 'Employee Address 1',
        'employee_address2' => 'Employee Address 2',
        'employee_city' => 'Employee City',
        'employee_province' => 'Employee Province',
        'employee_postal_code' => 'Employee Postal Code',
    ] as $field => $label)
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>{{ $label }}</label>
                            <input type="{{ $field === 'employee_password' ? 'password' : 'text' }}"
                                wire:model.lazy="{{ $field }}" class="form-control">
                            @error($field)
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endforeach

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Employee Role</label>
                        <select wire:model="employee_role" class="form-control">
                            <option value="">Select Role</option>
                            <option value="sales">Sales</option>
                            <option value="delivery">Delivery</option>
                        </select>
                        @error('employee_role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Employee Shop</label>
                        <select wire:model="employee_shop" class="form-control">
                            <option value="">Select Role</option>
                            @foreach ($shop as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('employee_shop')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mt-3">
                    <button type="submit" style="width: 200px" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
