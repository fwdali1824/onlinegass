<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Orders;
use App\Models\StockPurchase;
use App\Models\Stocks;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ProfitNLossReports extends Component
{

    #[Layout('components.layouts.admin')]

    public function mount()
    {
        redirect()->route('sales.daily.export');
    }

    public function render()
    {
        return view('livewire.admin.reports.profit-n-loss-reports');
    }
}
