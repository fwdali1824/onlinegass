<?php

namespace App\Livewire\Admin\DeliveryOrder;

use Livewire\Attributes\Layout;
use Livewire\Component;

class OrderListPending extends Component
{
    #[Layout('components.layouts.Auth.DeliveryDashboard')]

    protected $listeners = ['refreshComponent' => 'refreshData'];

    public function refreshData()
    {
        // Logic to refresh data, or just re-fetch from DB
        $this->mount(); // or any method that reloads your data
    }

    public function render()
    {
        return view('livewire..admin.delivery-order.order-list-pending');
    }
}
