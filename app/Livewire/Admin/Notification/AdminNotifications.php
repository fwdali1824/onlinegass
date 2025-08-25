<?php

namespace App\Livewire\Admin\Notification;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

class AdminNotifications extends Component
{
    #[Layout('components.layouts.admin')]

    public $users;
    public $selectedUsers = [];

    public function mount()
    {
        $this->users = User::select('id', 'name', 'email')->get();
    }

    public function updatedSelectedUsers()
    {
        // Optional: Debug or trigger additional logic
        logger('Selected Users:', $this->selectedUsers);
    }

    public function render()
    {
        return view('livewire.admin.notification.admin-notifications');
    }
}
