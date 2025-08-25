<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Order;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DeliveryDashboard extends Component
{
    #[Layout('components.layouts.Auth.DeliveryDashboard')]

    public $totalOrders;
    public $weeklyOrders;
    public $monthlyOrders;
    public $confirmedOrders;
    public $deliveredOrders;

    public function mount()
    {
        $userId = Auth::id();

        $this->totalOrders = Orders::where('delivery_person_id', $userId)->count();

        $this->weeklyOrders = Orders::where('delivery_person_id', $userId)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $this->monthlyOrders = Orders::where('delivery_person_id', $userId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $this->confirmedOrders = Orders::where('delivery_person_id', $userId)
            ->where('status', 'confirmed')
            ->count();

        $this->deliveredOrders = Orders::where('delivery_person_id', $userId)
            ->where('status', 'delivered')
            ->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.delivery-dashboard');
    }
}
