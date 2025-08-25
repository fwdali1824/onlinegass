<?php

namespace App\Livewire\Admin\Employee;

use App\Models\Shops;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;

class AddEmployee extends Component
{
    use WithFileUploads;

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
    public $employee_shop;

    public function save()
    {
        $this->validate([
            'employee_profile' => 'nullable|image|max:2048',
            'employee_name' => 'required|string|max:255',
            'employee_email' => 'required|email|unique:users,email',
            'employee_password' => 'required|min:6',
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

        $profilePath = $this->employee_profile
            ? asset('storage/' . $this->employee_profile->store('profiles', 'public'))
            : null;

        User::create([
            'name' => $this->employee_name,
            'email' => $this->employee_email,
            'password' => Hash::make($this->employee_password),
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

        session()->flash('success', 'Employee created successfully!');
        $this->reset(); // reset the form
    }

    #[Layout('components.layouts.admin')]

    public function render()
    {
        $shop = Shops::all();
        return view('livewire.admin.employee.add-employee', [
            'shop' => $shop
        ]);
    }
}
