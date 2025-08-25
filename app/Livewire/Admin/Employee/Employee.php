<?php

namespace App\Livewire\Admin\Employee;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;

    public $employee_password;
    public $employee_c_password;
    public $showModal = false;
    public $showModalSingle = false;
    public $selectedEmployeeId;
    public $emplSingle;
    public $dummyImage = 'https://sclpa.com/wp-content/uploads/2022/10/dummy-img-1.jpg';

    protected $paginationTheme = 'bootstrap'; // Optional


    public function openModalProfile($id)
    {
        $this->selectedEmployeeId = $id;
        $this->emplSingle = User::find($this->selectedEmployeeId);
        $this->showModalSingle = true;
    }


    public function resetInputs()
    {
        $this->employee_password = '';
        $this->employee_c_password = '';
        $this->selectedEmployeeId = null;
        $this->showModal = false;
    }

    public function openModal($id)
    {
        $this->selectedEmployeeId = $id;
        $this->reset(['employee_password', 'employee_c_password']);
        $this->showModal = true;
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('success', 'Employee deleted successfully.');
    }

    public function updatePassword()
    {
        $this->validate([
            'employee_password' => 'required|min:6',
            'employee_c_password' => 'required|min:6|same:employee_password',
        ]);

        $employee = User::find($this->selectedEmployeeId);

        if ($employee) {
            $employee->update([
                'password' => bcrypt($this->employee_password),
            ]);
            session()->flash('success', 'Password updated successfully.');
        } else {
            session()->flash('error', 'Employee not found.');
        }

        $this->resetInputs();
    }

    #[Layout('components.layouts.admin')]

    public function render()
    {
        $employees = User::with('shopname')->where('role', '!=', 'admin')->where('role', '!=', 'customer')->paginate(10);
        return view('livewire.admin.employee.employee', [
            'employe' => $employees,
        ]);
    }
}
