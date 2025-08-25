<div class="container py-4">

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Assign Permissions to Role --}}
    <div class="card mb-5 shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">🔐 Assign Permissions to Role</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Select Role</label>
                <select wire:model="selectedRole" wire:change="selectedRoleUser()" class="form-select">
                    <option value="">-- Select Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                @foreach ($permissions as $permission)
                    <div class="col-md-4" wire:key="perm-{{ $permission->id }}">
                        <div class="form-check">
                            <input type="checkbox" wire:model="selectedPermissions"
                                wire:change="onPermissionToggle({{ $permission->id }})" value="{{ $permission->id }}"
                                class="form-check-input" id="perm{{ $permission->id }}">
                            <label class="form-check-label" for="perm{{ $permission->id }}">
                                {{ ucfirst($permission->name) }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            <button wire:click="assignPermissionsToRole" class="btn btn-primary mt-3">
                ✅ Assign Permissions
            </button>
        </div>
    </div>

    {{-- Assign Roles to User --}}
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">👤 Assign Roles to User</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Select User</label>
                <select wire:model="selectedUser" wire:change="selectUserRole()" class="form-select">
                    <option value="">-- Select User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                @foreach ($roles as $role)
                    <div class="col-md-4" wire:key="user-role-{{ $role->id }}">
                        <div class="form-check">
                            <input type="checkbox" wire:model.defer="selectedRolesForUser" value="{{ $role->id }}"
                                class="form-check-input" id="role{{ $role->id }}">
                            <label class="form-check-label" for="role{{ $role->id }}">
                                {{ ucfirst($role->name) }}
                            </label>
                        </div>
                    </div>
                @endforeach


            </div>

            <button wire:click="assignRolesToUser" class="btn btn-success mt-3">
                ✅ Assign Roles
            </button>
        </div>
    </div>
</div>
