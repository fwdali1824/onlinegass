<?php

namespace App\Livewire\Admin\Notification;

use App\Models\Notifications;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AdminNotifications extends Component
{
    public $message;
    public $showModal = true;
    public $editId = '';
    public $customers = [];


    public function openModal()
    {
        $this->reset(); // Clear the input
        $this->showModal = true;
    }
    public array $firstSelection = [];
    public array $secondSelection = [];

    public array $options = [];

    public function mount()
    {
        // Example options
        $this->options = [
            'apple' => 'Apple',
            'banana' => 'Banana',
            'cherry' => 'Cherry',
            'date' => 'Date',
            'elderberry' => 'Elderberry',
        ];
    }

    public function save()
    {
        $this->validate([
            'customers' => 'required|array',
            'message' => 'required|string|max:255',
        ]);


        // Logic to save the notification
        // For example, you can create a new notification record in the database

        $this->reset(); // Clear the input after saving
        $this->showModal = false; // Close the modal
    }


    #[Layout('components.layouts.admin')]
    public function render()
    {
        $notifications = Notifications::all(); // Fetch all notifications
        $users = User::where('role', 'customer')->get(); // Fetch all notifications
        return view('livewire.admin.notification.admin-notifications', [
            'notifications' => $notifications,
            'users' => $users,
        ]);
    }
}
