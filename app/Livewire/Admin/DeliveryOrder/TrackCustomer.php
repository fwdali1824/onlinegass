<?php

namespace App\Livewire\Admin\DeliveryOrder;

use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

class TrackCustomer extends Component
{
    #[Layout('components.layouts.Auth.DeliveryDashboard')]

    public $orderId;
    public $customerLat;
    public $customerLng;
    public $error;

    public function searchOrder()
    {
        $this->reset(['customerLat', 'customerLng', 'error']);

        $order = Orders::where('orderid', $this->orderId)->first();

        if ($order) {
            $this->customerLat = $order->latitude;
            $this->customerLng = $order->longitude;
        } else {
            $this->error = "Order not found.";
        }
    }

    public function render()
    {
        $ordersList = Orders::where('delivery_person_id', Auth::user()->id)
            ->where('status',"!=", 'delivered')
            ->get();

        return view('livewire.admin.delivery-order.track-customer', [
            'ordersList' => $ordersList
        ]);
    }
}
