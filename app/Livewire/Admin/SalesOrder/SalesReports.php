<?php

namespace App\Livewire\Admin\SalesOrder;

use App\Models\Orders;
use App\Models\Shops;
use Livewire\Component;
use Livewire\Attributes\Layout;

class SalesReports extends Component
{
    public $shop_id;
    public $from_date;
    public $to_date;

    public function searchOrder()
    {
        $shops = Shops::all();

        $query = Orders::with('product', 'customer', 'delivery');

        if ($this->shop_id) {
            $query->where('shop', $this->shop_id);
        }

        if ($this->from_date) {
            $query->whereDate('created_at', '>=', $this->from_date);
        }

        if ($this->to_date) {
            $query->whereDate('created_at', '<=', $this->to_date);
        }

        $orderReports = $query->get();
        return view('livewire.admin.sales-order.sales-reports', [
            'shops' => $shops,
            'orderReports' => $orderReports,
        ]);
    }


    public function render()
    {
        $shops = Shops::all();

        $query = Orders::with('product', 'customer', 'delivery');

        if ($this->shop_id) {
            $query->where('shop', $this->shop_id);
        }

        if ($this->from_date) {
            $query->whereDate('created_at', '>=', $this->from_date);
        }

        if ($this->to_date) {
            $query->whereDate('created_at', '<=', $this->to_date);
        }

        $orderReports = $query->get();

        return view('livewire.admin.sales-order.sales-reports', [
            'shops' => $shops,
            'orderReports' => $orderReports,
        ]);
    }


    #[Layout('components.layouts.admin')]

    public function export()
    {
        return redirect()->route('sales.export', [
            'shop' => $this->shop_id ?? 0,
            'from' => $this->from_date ?? 0,
            'to' => $this->to_date ?? 0,
        ]);
    }
}
