<div class="container py-4 text-white">
    <h2 class="mb-4">Edit Profile</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="updateProfile" enctype="multipart/form-data">
        <div class="row g-3">
            <!-- Profile Picture -->
            <div class="col-md-3 text-center">
                @if ($newAvatar)
                    <img src="{{ $newAvatar->temporaryUrl() }}" class="mb-5 img-fluid rounded-circle border mb-2"
                        width="120" height="120">
                @elseif ($avatar)
                    <img src="{{ $avatar }}" class="mb-5 img-fluid rounded-circle border mb-2" width="120"
                        height="120">
                @else
                    <img src="https://via.placeholder.com/120" class=" mb-5 img-fluid rounded-circle border mb-2">
                @endif
                <br>

                <input type="file" wire:model="newAvatar" class="form-control bg-dark text-white border-secondary">
                @error('newAvatar')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Name & Email -->
            <div class="col-md-9">
                <label>Name</label>
                <input type="text" wire:model="name" class="form-control bg-dark text-white border-secondary mb-2">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <label>Email</label>
                <input type="email" readonly wire:model="email" class="form-control bg-dark text-white border-secondary mb-2">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <label>Phone</label>
                <input type="text" wire:model="phone_number"
                    class="form-control bg-dark text-white border-secondary mb-2">

                <label>CNIC</label>
                <input type="text" wire:model="cnic" class="form-control bg-dark text-white border-secondary mb-2">

                <label>Address Line 1</label>
                <input type="text" wire:model="address_line_1"
                    class="form-control bg-dark text-white border-secondary mb-2">

                <label>Address Line 2</label>
                <input type="text" wire:model="address_line_2"
                    class="form-control bg-dark text-white border-secondary mb-2">

                <div class="row">
                    <div class="col-md-4">
                        <label>City</label>
                        <input type="text" wire:model="city"
                            class="form-control bg-dark text-white border-secondary">
                    </div>
                    <div class="col-md-4">
                        <label>Province</label>
                        <input type="text" wire:model="province"
                            class="form-control bg-dark text-white border-secondary">
                    </div>
                    <div class="col-md-4">
                        <label>Postal Code</label>
                        <input type="text" wire:model="postal_code"
                            class="form-control bg-dark text-white border-secondary">
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3">
                <button class="btn btn-primary">Update Profile</button>
            </div>
        </div>
    </form>
</div>
