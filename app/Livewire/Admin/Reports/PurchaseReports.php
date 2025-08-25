<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Shops;
use App\Models\StockPurchase;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PurchaseReports extends Component
{

    public $shop_id;
    public $from_date;
    public $to_date;

    public function searchOrder()
    {
        $shops = Shops::all();

        $query = StockPurchase::with('productshop', 'product', 'user');

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

    public function export()
    {
        return redirect()->route('sales.purchase.export', [
            'shop' => $this->shop_id ?? 0,
            'from' => $this->from_date ?? 0,
            'to' => $this->to_date ?? 0,
        ]);
    }

    #[Layout('components.layouts.admin')]

    public function render()
    {
        $shops = Shops::all();

        $query = StockPurchase::with('productshop', 'product', 'user');

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

        return view('livewire.admin.reports.purchase-reports', [
            'shops' => $shops,
            'orderReports' => $orderReports,
        ]);
    }
}
