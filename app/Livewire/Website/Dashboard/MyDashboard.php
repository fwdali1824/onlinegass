<?php

namespace App\Livewire\Website\Dashboard;

use App\Models\Orders;
use App\Models\WalletUser;
use App\Models\WalletUserTransactions;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class MyDashboard extends Component
{

    #[Layout('components.layouts.websiteDashboard')]

    public function render()
    {
        $userId = Auth::id();

        $totalOrders = Orders::where('user_id', $userId)->count();
        $wallet = WalletUser::where('user_id', $userId)->first();
        $transactionCount = WalletUserTransactions::where('user_id', $userId)->count();
        $lastOrder = Orders::where('user_id', $userId)->with('product')->get();
        $transactions = WalletUserTransactions::where('user_id', $userId)->latest()->take(10)->get(); // pass this

        return view('livewire.website.dashboard.my-dashboard', [
            'totalOrders' => $totalOrders,
            'walletBalance' => $wallet->balance ?? 0,
            'transactionCount' => $transactionCount,
            'lastOrder' => $lastOrder,
            'transactions' => $transactions,
        ]);
    }
}
