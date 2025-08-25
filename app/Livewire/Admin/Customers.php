<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Customers extends Component
{

    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Layout('components.layouts.admin')]

    public function render()
    {
        return view('livewire.admin.customers', [
            'users' => User::where('name', 'like', '%' . $this->search . '%')
                ->where('role', 'customer')
                ->paginate($this->perPage),
        ]);
    }
}
