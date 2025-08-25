<?php

namespace App\Livewire\Admin\SalesOrder;

use App\Models\Orders;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class OrderListComplete extends Component
{
    use WithPagination;

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

        $this->productList = Orders::where('status', 'completed')
            ->where('product_id', $productId)
            ->with(['product', 'customer'])
            ->first();

        $this->userDelivery = User::where('role', 'Delivery')->get();
    }

    public function assignDelivery()
    {
        $this->validate([
            'deliveryPersonId' => 'required|exists:users,id',
            'selectedOrderId' => 'required|exists:orders',
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
        return $this->redirect('/sales/order-list', navigate: true);

    }

    #[Layout('components.layouts.Auth.SalesDashboard')]

    public function render()
    {
        $orders = Orders::where('status', 'completed')->with(['product', 'customer'])->paginate(10);
        return view('livewire..admin.sales-order.order-list-complete', [
            'orders' => $orders
        ]);
    }
}
