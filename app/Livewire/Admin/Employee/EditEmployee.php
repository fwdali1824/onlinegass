<?php

namespace App\Livewire\Admin\Employee;

use App\Models\Shops;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class EditEmployee extends Component
{

    use WithPagination;

    public $employee_profile;
    public $employee_name;
    public $employee_email;
    public $employee_password;
    public $employee_phone;
    public $employee_cnic;
    public $employee_address1;
    public $employee_address2;
    public $employee_city;
    public $employee_province;
    public $employee_postal_code;
    public $employee_role;
    public $id;
    public $employee_shop;

    public function mount($id)
    {
        $this->id = $id;

        $employee = User::findOrFail($id);

        $this->employee_name = $employee->name;
        $this->employee_email = $employee->email;
        $this->employee_phone = $employee->phone_number;
        $this->employee_cnic = $employee->cnic;
        $this->employee_address1 = $employee->address_line_1;
        $this->employee_address2 = $employee->address_line_2;
        $this->employee_city = $employee->city;
        $this->employee_province = $employee->province;
        $this->employee_postal_code = $employee->postal_code;
        $this->employee_role = $employee->role;
        $this->employee_profile = $employee->profile;
        $this->employee_shop = $employee->shop;
    }
    public function removeImage()
    {
        $this->employee_profile = null;
    }

    public function save()
    {
        $this->validate([
            'employee_name' => 'required|string|max:255',
            'employee_email' => 'required|email|unique:users,email,' . $this->id,
            'employee_password' => 'nullable|min:6',
            'employee_phone' => 'required|string',
            'employee_cnic' => 'nullable|string',
            'employee_address1' => 'required|string',
            'employee_address2' => 'nullable|string',
            'employee_city' => 'required|string',
            'employee_province' => 'nullable|string',
            'employee_postal_code' => 'nullable|string',
            'employee_role' => 'required|in:sales,delivery',
            'employee_shop' => 'required',
        ]);

        $employee = User::findOrFail($this->id);

        if (is_object($this->employee_profile)) {
            // A new file has been uploaded
            $profilePath = 'storage/' . $this->employee_profile->store('profiles', 'public');
        } else {
            // Use the existing string path from DB
            $profilePath = $this->employee_profile;
        }


        $employee->update([
            'name' => $this->employee_name,
            'email' => $this->employee_email,
            'password' => $this->employee_password ? Hash::make($this->employee_password) : $employee->password,
            'phone_number' => $this->employee_phone,
            'cnic' => $this->employee_cnic,
            'address_line_1' => $this->employee_address1,
            'address_line_2' => $this->employee_address2,
            'city' => $this->employee_city,
            'province' => $this->employee_province,
            'postal_code' => $this->employee_postal_code,
            'role' => $this->employee_role,
            'profile' => $profilePath,
            'shop' => $this->employee_shop,
        ]);

        session()->flash('success', 'Employee updated successfully!');
    }

    #[Layout('components.layouts.admin')]

    public function render()
    {
        $shop = Shops::all();
        return view('livewire.admin.employee.edit-employee', [
            'shop' => $shop
        ]);
    }
}
