<?php

namespace App\Livewire\Admin\SalesOrder;

use Livewire\Attributes\Layout;
use Livewire\Component;

class ListOfOrders extends Component
{
    #[Layout('components.layouts.Auth.SalesDashboard')]

    public function render()
    {
        return view('livewire.admin.sales-order.list-of-orders');
    }
}
