<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Orders;
use App\Models\Shops;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CustomerOrdersReports extends Component
{
    public $shop_id;
    public $from_date;
    public $to_date;
    public function searchOrder()
    {
        $shops = Shops::all();

        $query = Orders::with('product', 'customer', 'delivery', 'productshop');

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
        return view('livewire.admin.reports.customer-orders-reports', [
            'shops' => $shops,
            'orderReports' => $orderReports,
        ]);
    }

    public function export()
    {
        return redirect()->route('sales.orderreport.export', [
            'shop' => $this->shop_id ?? 0,
            'from' => $this->from_date ?? 0,
            'to' => $this->to_date ?? 0,
        ]);
    }
    #[Layout('components.layouts.admin')]
    public function render()
    {
        $shops = Shops::all();

        $query = Orders::with('product', 'customer', 'delivery', 'productshop');

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

        return view('livewire.admin.reports.customer-orders-reports', [
            'shops' => $shops,
            'orderReports' => $orderReports,
        ]);
    }
}
