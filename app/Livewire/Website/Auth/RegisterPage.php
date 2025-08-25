<?php

namespace App\Livewire\Website\Auth;

use App\Mail\TestEmail;
use App\Models\ReferalCode;
use App\Models\User;
use App\Models\WalletUser;
use App\Models\WalletUserTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RegisterPage extends Component
{
    #[Layout('components.layouts.websiteAuth')]

    public $form = [
        'name' => '',
        'email' => '',
        'password' => '',
        'phone_number' => '',
        'cnic' => '',
        'address_line_1' => '',
        'address_line_2' => '',
        'city' => '',
        'province' => '',
        'postal_code' => '',
        // 'connection_type' => 'domestic',
        'profile' => '',
        'ref_code' => '',
    ];

    private function generateReferralCode()
    {
        return  'REF-' . now()->format('Hs') . '-' . rand(100, 999);
    }

    private function generateTransactionCode()
    {
        return  'TXN-' . now()->format('Hs') . '-' . rand(100, 999);
    }

    public function mount()
    {
        $this->form['ref_code'] = request()->query('ref');
    }

    public function walletCreate($referalCode, $user)
    {
        $referalWallet = WalletUser::where('user_id', $referalCode->id)->first();
        $referaluserWallet = WalletUser::where('user_id', $user->id)->first();

        if ($referalWallet) {
            $referalWallet->balance += 50;
            $referalWallet->save();
            WalletUserTransactions::create([
                'user_id' => $referalCode->id,
                'amount' => 50, // Bonus amount
                'transaction_id' => $this->generateTransactionCode(),
                'acount_number' => '',
                'acount_name' => '',
                'type' => 'bouns',
            ]);
        } else {
            WalletUser::create([
                'user_id' => $referalCode->id,
                'balance' => 50, // Initial bonus
                'last_transaction' => 50,
            ]);

            WalletUserTransactions::create([
                'user_id' => $referalCode->id,
                'amount' => 50, // Bonus amount
                'transaction_id' => $this->generateTransactionCode(),
                'acount_number' => '',
                'acount_name' => '',
                'type' => 'bouns',
            ]);
        }

        if ($referaluserWallet) {
            $referaluserWallet->balance += 50;
            $referaluserWallet->save();
            WalletUserTransactions::create([
                'user_id' => $user->id,
                'amount' => 50, // Bonus amount
                'transaction_id' => $this->generateTransactionCode(),
                'acount_number' => '',
                'acount_name' => '',
                'type' => 'bouns',
            ]);
        } else {
            WalletUser::create([
                "user_id" =>  $user->id,
                "balance" => "50",
                "last_transaction" => "50",
            ]);
            WalletUserTransactions::create([
                'user_id' => $user->id,
                'amount' => 50, // Bonus amount
                'transaction_id' => $this->generateTransactionCode(),
                'acount_number' => '',
                'acount_name' => '',
                'type' => 'bouns',
            ]);
        }
    }

    public function register()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.email' => 'required|email|unique:users,email',
            'form.password' => 'required|min:6',
            'form.phone_number' => 'nullable|string',
            'form.cnic' => 'nullable|string',
            // 'form.connection_type' => 'required|in:domestic,commercial',
        ]);


        $user = User::create([
            'name' => $this->form['name'],
            'email' => $this->form['email'],
            'password' => Hash::make($this->form['password']),
            'phone_number' => $this->form['phone_number'],
            'cnic' => $this->form['cnic'],
            'address_line_1' => $this->form['address_line_1'],
            'address_line_2' => $this->form['address_line_2'],
            'city' => $this->form['city'],
            'province' => $this->form['province'],
            'postal_code' => $this->form['postal_code'],
            'role' => 'customer',
            // 'connection_type' => $this->form['connection_type'],
            'profile' => $this->form['profile'],
            'is_active' => true,
            'referal_code' => $this->generateReferralCode(),
        ]);

        if ($this->form['ref_code']) {
            $referalCode = User::where('referal_code', $this->form['ref_code'])->first();
            if ($referalCode) {

                ReferalCode::create(
                    [
                        'code' => $this->form['ref_code'],
                        'user_id' => $user->id,
                        'referal_id' => $referalCode->id
                    ]
                );

                $this->walletCreate($referalCode, $user);
            } else {
                session()->flash('error', 'Invalid referral code.');
                return;
            }
        } else {
            WalletUser::create([
                "user_id" =>  $user->id,
                "balance" => "0",
                "last_transaction" => "0",
            ]);
        }


        Mail::to($this->form['email'])->send(new TestEmail(
            $this->form['name'],
            $this->form['email'],
            $this->form['phone_number'],
            $this->form['password'],
        ));

        $user->assignRole('Customers');
        Auth::login($user);


        $this->reset();
        session()->flash('success', 'Registration successful!');
        if (Auth::user()->role == 'admin') {
            session()->flash('success', 'Not Allowed Login');
            return;
        }
        if (Auth::user()->role == 'customer') {
            return redirect('/user-dashboard');
        } else {
            return redirect('/home');
        }
    }

    public function render()
    {
        return view('livewire.website.auth.register-page');
    }
}
