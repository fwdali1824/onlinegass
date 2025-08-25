<?php

namespace App\Livewire\Admin\SalesOrder;

use App\Models\Orders;
use Livewire\Attributes\Layout;
use Livewire\Component;

class OrderListProgress extends Component
{
    public $showModalSingle = false;
    public $productList = false;

    public $dummyImage = 'https://sclpa.com/wp-content/uploads/2022/10/dummy-img-1.jpg';

    public function openModalProfile($productId)
    {
        $this->showModalSingle = true;

        $this->productList = Orders::orwhere('status', 'confirmed')
            ->orwhere('status', 'out_for_delivery')
            ->where('product_id', $productId)
            ->with(['product', 'customer', 'delivery'])
            ->first();
    }

    #[Layout('components.layouts.Auth.SalesDashboard')]

    public function render()
    {
        $orders = Orders::orwhere('status', 'confirmed')
            ->orwhere('status', 'out_for_delivery')
            ->with(['product', 'customer'])
            ->paginate(10);

        return view('livewire..admin.sales-order.order-list-progress', [
            'orders' => $orders
        ]);
    }
}
