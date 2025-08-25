<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Orders;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;

class OrderListsPending extends Component
{
    public $showModalSingle = false;
    public $productList = '';
    public $userDelivery = [];
    public $deliveryPersonId;
    public $selectedOrderId;
    public $dummyImage = 'https://sclpa.com/wp-content/uploads/2022/10/dummy-img-1.jpg';


    public function openModalProfile($id)
    {
        $this->showModalSingle = true;
        $this->productList = Orders::where('status', '=', 'pending')->with('product', 'customer')->where('id', $id)->first();
        $this->userDelivery = User::where('role', 'Delivery')->get();
        $this->selectedOrderId = $id;
    }

    public function assignDelivery()
    {
        $this->validate([
            'deliveryPersonId' => 'required|exists:users,id',
            'selectedOrderId' => 'required',
        ]);

        $order = Orders::where('id', $this->selectedOrderId)->first();

        if ($order) {
            $order->delivery_person_id = $this->deliveryPersonId;
            $order->status = 'confirmed';
            $order->save();

            session()->flash('success', 'Delivery person assigned successfully.');
        } else {
            session()->flash('error', 'Order not found.');
        }

        $this->reset(['showModalSingle', 'deliveryPersonId', 'selectedOrderId', 'productList']);
    }


    public function render()
    {
        $orders = Orders::where('status', '=', 'pending')->with('product', 'customer')->paginate(10);
        return view('livewire.admin.orders.order-lists-pending', [
            'orders' => $orders
        ]);
    }
}
