<?php

namespace App\Livewire\Website\Notification;

use App\Models\Notifications;
use App\Models\NotificationsUsers;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AdminNotifications extends Component
{
    #[Layout('components.layouts.websiteDashboard')]

    public function render()
    {
        $notifications = NotificationsUsers::where('to_user', Auth::user()->id)
            ->with('user', 'sender', 'notification')
            ->get();

        return view('livewire.website.notification.admin-notifications', [
            'notifications' => $notifications
        ]);
    }
}
