<?php

namespace App\Livewire\Admin\DeliveryOrder;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompletedOrders extends Component
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

        $this->productList = Orders::where('status', 'delivered')
            ->where('id', $productId)
            ->with(['product', 'customer'])
            ->first();

        $this->userDelivery = User::where('role', 'Delivery')->get();
    }

    public function assignDelivery()
    {


        $order = Orders::where('id', $this->selectedOrderId)->first();

        if ($order) {
            $order->delivery_person_id = Auth::user()->id;
            $order->status = $this->deliveryPersonId;
            $order->save();

            session()->flash('success', 'Delivery person assigned successfully.');
        } else {
            session()->flash('error', 'Order not found.');
        }

        $this->reset(['showModalSingle', 'deliveryPersonId', 'selectedOrderId', 'productList']);
        return $this->redirect('/delivery/orderlist', navigate: true);
    }


    public function render()
    {
        $orders = Orders::where('status', 'delivered')
            ->where('delivery_person_id', Auth::user()->id)
            ->with('product', 'customer')
            ->paginate(10);
        return view('livewire.admin.delivery-order.completed-orders', [
            'orders' => $orders
        ]);
    }
}
