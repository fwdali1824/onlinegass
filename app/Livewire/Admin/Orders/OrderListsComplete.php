<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Orders;
use App\Models\User;
use Livewire\Component;

class OrderListsComplete extends Component
{
    public $showModalSingle = false;
    public $productList = '';
    public $userDelivery = '';
    public $dummyImage = 'https://sclpa.com/wp-content/uploads/2022/10/dummy-img-1.jpg';


    public function openModalProfile($id)
    {
        $this->showModalSingle = true;
        $this->productList = Orders::where('status', '=', 'delivered')->with('product', 'customer')->where('product_id', $id)->first();
        $this->userDelivery = User::where('role', 'Delivery')->get();
    }

    public function render()
    {
        $orders = Orders::where('status', '=', 'delivered')->with('product', 'customer')->paginate(10);

        return view('livewire.admin.orders.order-lists-complete', [
            'orders' => $orders
        ]);
    }
}
