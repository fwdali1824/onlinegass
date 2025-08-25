<?php

namespace App\Livewire\Admin\HRM;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissions extends Component
{
    public $roles = [], $permissions = [], $users = [];

    public $selectedRole = '';
    public $selectedPermissions = [];

    public $selectedUser = '';
    public $selectedRolesForUser = [];

    public function mount()
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all();
        $this->users = User::all();
    }

    public function updatedSelectedRole()
    {
        $role = Role::find($this->selectedRole);

        if ($role) {
            $this->selectedPermissions = $role->permissions
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selectedPermissions = [];
            session()->flash('error', 'Selected role not found.');
        }
    }

    public function onPermissionToggle($permissionId)
    {
        // Optional logic on toggle
        logger("Permission toggled: {$permissionId}");
    }

    public function assignPermissionsToRole()
    {
        $role = Role::find($this->selectedRole);
        if (!$role) {
            session()->flash('error', 'Role not found.');
            return;
        }

        $permissions = Permission::whereIn('id', $this->selectedPermissions)->get();
        $role->syncPermissions($permissions);

        session()->flash('success', 'Permissions updated for role.');
    }


    public function selectUserRole()
    {
        $user = User::find($this->selectedUser);
        if ($user) {
            $this->selectedRolesForUser = $user->roles->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedRolesForUser = [];
        }
    }



    public function updatedSelectedUser($value)
    {
        // Automatically triggered when selectedUser changes
        $user = User::find($value);

        if ($user) {
            $this->selectedRolesForUser = $user->roles->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedRolesForUser = [];
        }
    }

    public function selectedRoleUser()
    {
        $role = Role::find($this->selectedRole);
        if (!$role) {
            session()->flash('error', 'Role not found.');
            return;
        }

        $permissions = Permission::whereIn('id', $this->selectedPermissions)->get();
        $role->syncPermissions($permissions);
    }



    public function assignRolesToUser()
    {
        $user = User::find($this->selectedUser);
        if (!$user) {
            session()->flash('error', 'User not found.');
            return;
        }

        // Convert role IDs to names
        $roleNames = Role::whereIn('id', $this->selectedRolesForUser)->pluck('name')->toArray();

        $user->syncRoles($roleNames);

        session()->flash('success', 'Roles updated for user.');

    }

    public function render()
    {
        return view('livewire.admin.h-r-m.roles-and-permissions');
    }
}
