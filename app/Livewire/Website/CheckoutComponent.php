<?php

namespace App\Livewire\Website;


use App\Mail\OrderPlaced;
use App\Models\Orders;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\User;
use App\Models\WalletUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutComponent extends Component
{
    public $full_name, $email, $phone, $address;
    public $cartItems = [];
    public $totalAmount = 0;
    public $product;
    public $date;
    public $note;
    public $qty = 1;
    public $paymenttype = '';
    public $login = true;
    public $register = false;
    public $id;
    public $quantity;
    public $latitude;
    public $longitude;


    public function Login()
    {
        $this->login = true;
        $this->register = false;
    }

    public function Register()
    {
        $this->login = false;
        $this->register = true;
    }


    public function mount($id, $quantity)
    {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->product = Product::with('productcategory')->find($id);
        $this->qty = $quantity;
    }

    public function placeOrder()
    {
        dd($this->all());
        $this->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email',
            'phone'        => 'required',
            'address'      => 'required|string|max:500',
            'date'         => 'required|date',
            'paymenttype'  => 'required|in:online,cod,wallet',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
        ]);
        $user = User::where('name', $this->full_name)->firstOrFail();

        if ($this->paymenttype === 'wallet') {
            $userWallet = WalletUser::where('user_id', $user->id)->first();
            $total = $this->product->price * $this->qty;

            if (!$userWallet || $userWallet->balance < $total) {
                session()->flash('error', 'Insufficient wallet balance. Please top up your wallet.');
                // $this->dispatch('insufficientWallet');
                // return;
            }
        }

        $orderID = 'ORD-' . now()->format('YmdHis') . '-' . rand(100, 999);
        $order = new Orders();

        // Get user by name (ensure this is safe)
        $order->user_id = (string) $user->id; // since user_id is VARCHAR

        $order->delivery_address = $this->address;
        $order->delivery_date = $this->date;
        $order->payment_method = $this->paymenttype;
        $order->product_id = $this->product->id;

        // Ensure correct values
        $order->price = number_format($this->product->price); // price is varchar
        $order->quantity = number_format($this->qty); // quantity is varchar

        $order->total_amount = number_format($this->product->price * $this->qty, 2); // total_amount is decimal(10,2)

        $order->notes = $this->note ?? null;
        $order->payment_status = 'unpaid'; // Default from schema
        $order->status = 'pending';
        $order->orderid = $orderID;

        $order->latitude = $this->latitude;
        $order->longitude = $this->longitude;
        $order->save();


        session()->flash('success', 'Your order has been placed!');
        Mail::to($this->email)->send(new OrderPlaced($orderID, $this->full_name, $this->total));
        // Optionally clear form fields
        $this->reset(['full_name', 'email', 'phone', 'address', 'date', 'paymenttype', 'note']);
    }

    #[Layout('components.layouts.website')]
    public function render()
    {

        if (Auth::check()) {
            $user = User::where('id', Auth::user()->id)->first();
            $this->full_name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone_number;
        }
        return view('livewire.website.checkout-component');
    }
}
