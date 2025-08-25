<?php

namespace App\Livewire\Website\Dashboard;

use App\Models\WalletUser;
use App\Models\WalletUserTransactions;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class MyWallet extends Component
{
    #[Layout('components.layouts.websiteDashboard')]


    public $amount;

    public function topUp()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();

        $userWallet = WalletUser::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0],
        );

        $userWallet->balance += $this->amount;
        $userWallet->last_transaction = $this->amount;
        $userWallet->save();

        // Log the transaction
        WalletUserTransactions::create([
            'user_id'        => $user->id,
            'amount'         => $this->amount,
            'type'           => 'topup',
            'transaction_id' => strtoupper('TXN-' . uniqid()),
            'acount_number'  => null,
            'acount_name'    => null,
        ]);

        session()->flash('success', 'Wallet topped up successfully!');
        $this->reset('amount');
    }



    public function render()
    {
        $user = Auth::user();
        $userWallet = WalletUser::where('user_id', $user->id)->first();
        $transactions = WalletUserTransactions::where('user_id', $user->id)->latest()->get();

        return view('livewire.website.dashboard.my-wallet', [
            'userWallet' => $userWallet,
            'transactions' => $transactions
        ]);
    }
}
