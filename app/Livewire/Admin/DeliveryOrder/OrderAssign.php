<?php

namespace App\Livewire\Admin\DeliveryOrder;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class OrderAssign extends Component
{


    public $showModalSingle = false;
    public $productList = null;
    public $userDelivery = [];
    public $deliveryPersonId;
    public $selectedOrderId;
    public $dummyImage = 'https://sclpa.com/wp-content/uploads/2022/10/dummy-img-1.jpg';

    public function openModalProfile($productId)
    {
        $this->showModalSingle = true;
        $this->selectedOrderId = $productId;

        $this->productList = Orders::orwhere('status', 'confirmed')
            ->orwhere('status', 'out_for_delivery')
            ->where('id', $productId)
            ->with(['product', 'customer'])
            ->first();

        $this->userDelivery = User::where('role', 'Delivery')->get();
    }

    public function assignDelivery()
    {
        // dd($this->deliveryPersonId);
        $order = Orders::where('id', $this->selectedOrderId)->first();

        if ($order) {
            $order->delivery_person_id = Auth::user()->id;
            if ($this->deliveryPersonId == 'delivered') {
                $order->payment_status = 'paid';
            }
            $order->status = $this->deliveryPersonId;
            $order->save();

            session()->flash('success', 'Delivery person assigned successfully.');
        } else {
            session()->flash('error', 'Order not found.');
        }

        $this->reset(['showModalSingle', 'deliveryPersonId', 'selectedOrderId', 'productList']);
        return $this->redirect('/delivery/orderlist', navigate: true);
    }

    #[Layout('components.layouts.Auth.DeliveryDashboard')]

    public function render()
    {
        $orders = Orders::orwhere('status', '=', 'confirmed')
            ->orwhere('status', 'out_for_delivery')
            ->where('delivery_person_id', Auth::user()->id)
            ->with('product', 'customer')
            ->paginate(10);

        return view('livewire..admin.delivery-order.order-assign', [
            'orders' => $orders
        ]);
    }
}
