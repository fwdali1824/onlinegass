<div>
    <style>
        .login-box {
            max-width: 600px;
            width: 100%;
            padding: 2rem;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* margin: auto; */
        }
    </style>

    <div class="login-box mt-5 mb-5" style="margin-top: 50px">
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <h2 class="text-center mb-4">Customer Registration</h2>

        <form wire:submit.prevent="register">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input wire:model.defer="form.name" type="text" class="form-control">
                    @error('form.name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input wire:model.defer="form.email" type="email" class="form-control">
                    @error('form.email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Password</label>
                    <input wire:model.defer="form.password" type="password" class="form-control">
                    @error('form.password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Phone Number</label>
                    <input wire:model.defer="form.phone_number" type="text" class="form-control"
                        placeholder="Enter phone number">
                    @error('form.phone_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3" style="margin-top: 10px">
                    <label>CNIC</label>
                    <input wire:model.defer="form.cnic" type="text" class="form-control">
                    @error('form.cnic')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3" style="margin-top: 10px">
                    <label>Referal Code</label>
                    <input wire:model.defer="form.ref_code" type="text" class="form-control">

                </div>

                <div class="col-md-12 mb-3" style="margin-top: 10px">
                    <label>Address Line 1</label>
                    <input wire:model.defer="form.address_line_1" type="text" class="form-control">
                    @error('form.address_line_1')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3" style="margin-top: 10px">
                    <label>Address Line 2</label>
                    <input wire:model.defer="form.address_line_2" type="text" class="form-control">
                    @error('form.address_line_2')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3" style="margin-top: 10px">
                    <label>City</label>
                    <input wire:model.defer="form.city" type="text" class="form-control">
                    @error('form.city')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3" style="margin-top: 10px">
                    <label>Province</label>
                    <input wire:model.defer="form.province" type="text" class="form-control">
                    @error('form.province')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3" style="margin-top: 10px">
                    <label>Postal Code</label>
                    <input wire:model.defer="form.postal_code" type="text" class="form-control">
                    @error('form.postal_code')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-grid mt-3" style="margin-top: 10px">
                <button type="submit" class="theme-btn">Register</button>
            </div>
        </form>
    </div>
</div>
