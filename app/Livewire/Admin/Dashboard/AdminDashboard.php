<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Orders;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Shops;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AdminDashboard extends Component
{
    #[Layout('components.layouts.admin')]

    public function render()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $dates = collect();

        // Generate all days of the month
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dates->push($date->format('Y-m-d'));
        }

        $branches = DB::table('shops')->select('id', 'name')->get();

        $data = [];

        foreach ($branches as $branch) {
            $dailyOrders = [];

            foreach ($dates as $date) {
                $orderCount = DB::table('orders')
                    ->whereDate('created_at', $date)
                    ->where('shop', $branch->id)
                    ->count();

                $dailyOrders[] = $orderCount;
            }

            $data[] = [
                'label' => $branch->name,
                'data' => $dailyOrders,
                'borderColor' => '#' . substr(md5($branch->id), 0, 6),
                'backgroundColor' => '#' . substr(md5($branch->id . 'bg'), 0, 6),
                'fill' => false,
            ];
        }

        $statuses = ['pending', 'confirmed', 'out_for_delivery', 'delivered'];

        $statusCounts = [];
        foreach ($statuses as $status) {
            $statusCounts[$status] = Orders::where('status', $status)->count();
        }

        $statusCounts['total'] = Orders::count();

        $roles = ['admin', 'customer', 'delivery', 'sales'];

        $roleCounts = [];
        foreach ($roles as $role) {
            $roleCounts[$role] = User::where('role', $role)->count();
        }

        $roleCounts['total'] = User::count();

        $productCounts = Product::count();

        // dd($statusCounts['pending']);
        return view('livewire.admin.dashboard.admin-dashboard', [
            'dates' => $dates,
            'chartData' => $data,
            'statusCounts' => $statusCounts,
            'roleCounts' => $roleCounts,
            'productCounts' => $productCounts,
        ]);
    }
}
