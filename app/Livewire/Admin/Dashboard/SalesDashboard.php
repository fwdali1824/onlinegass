<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Order;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SalesDashboard extends Component
{
    #[Layout('components.layouts.Auth.SalesDashboard')]

    public $totalOrders;
    public $weeklyOrders;
    public $monthlyOrders;
    public $confirmedOrders;
    public $deliveredOrders;

    // To hold data for the chart
    public $ordersData;

    public function mount()
    {
        $shop = Auth::user()->shop;

        // Total Orders
        $this->totalOrders = Orders::where('shop', $shop)->count();

        // Weekly Orders
        $this->weeklyOrders = Orders::where('shop', $shop)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        // Monthly Orders
        $this->monthlyOrders = Orders::where('shop', $shop)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Confirmed Orders
        $this->confirmedOrders = Orders::where('shop', $shop)
            ->where('status', 'confirmed')
            ->count();

        // Delivered Orders
        $this->deliveredOrders = Orders::where('shop', $shop)
            ->where('status', 'delivered')
            ->count();

        // Chart Data
        $this->ordersData = [
            'labels' => ['Total Orders', 'Weekly Orders', 'Monthly Orders', 'Confirmed Orders', 'Delivered Orders'],
            'data' => [
                $this->totalOrders,
                $this->weeklyOrders,
                $this->monthlyOrders,
                $this->confirmedOrders,
                $this->deliveredOrders
            ]
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard.sales-dashboard');
    }
}
