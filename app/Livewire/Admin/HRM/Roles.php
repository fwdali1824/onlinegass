<?php

namespace App\Livewire\Admin\HRM;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    public $roles;
    public $name;
    public $roleIdBeingEdited = null;

    public function mount()
    {
        $this->loadRoles();
    }

    public function loadRoles()
    {
        $this->roles = Role::all();
    }

    public function saveRole()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->roleIdBeingEdited,
        ]);

        if ($this->roleIdBeingEdited) {
            $role = Role::findOrFail($this->roleIdBeingEdited);
            $role->update(['name' => $this->name]);
            session()->flash('success', 'Role updated successfully.');
        } else {
            Role::create(['name' => $this->name]);
            session()->flash('success', 'Role created successfully.');
        }

        $this->reset(['name', 'roleIdBeingEdited']);
        $this->loadRoles();
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        $this->name = $role->name;
        $this->roleIdBeingEdited = $role->id;
    }

    public function deleteRole($id)
    {
        Role::findOrFail($id)->delete();
        session()->flash('success', 'Role deleted successfully.');
        $this->loadRoles();
    }

    public function cancelEdit()
    {
        $this->reset(['name', 'roleIdBeingEdited']);
    }

    public function render()
    {
        return view('livewire.admin.h-r-m.roles');
    }
}
