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

class SingleProductCheckout extends Component
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
    public $shop;


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
        $this->shop = $this->product->shop;
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



        return view('livewire.website.single-product-checkout', [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'shop' => $this->shop,
            'customUrl' => "product-checkout",
        ]);
    }
}
