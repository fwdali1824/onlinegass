<div class="container py-4">
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $roleIdBeingEdited ? '✏️ Edit Role' : '➕ Add New Role' }}</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="saveRole">
                <div class="mb-3">
                    <label class="form-label">Role Name</label>
                    <input wire:model.defer="name" type="text" class="form-control" placeholder="Enter role name">
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div>
                    <button class="btn btn-success" type="submit">
                        {{ $roleIdBeingEdited ? 'Update Role' : 'Add Role' }}
                    </button>

                    @if($roleIdBeingEdited)
                        <button type="button" wire:click="cancelEdit" class="btn btn-secondary">Cancel</button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Roles List --}}
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">📋 Role List</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role Name</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $index => $role)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ ucfirst($role->name) }}</td>
                            <td>
                                <button wire:click="editRole({{ $role->id }})" class="btn btn-sm btn-warning">Edit</button>
                                <button wire:click="deleteRole({{ $role->id }})" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
