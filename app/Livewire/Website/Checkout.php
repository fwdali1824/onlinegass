<?php

namespace App\Livewire\Website;

use App\Mail\OrderPlaced;
use App\Models\Orders;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Checkout extends Component
{
    public $cart = [];

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
    public $total = 0;
    public $totalqty = 0;
    public $latitude;
    public $longitude;
    public $shop;


    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }


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


    #[Layout('components.layouts.website')]
    public function render()
    {
        if (Auth::check()) {
            $user = User::where('id', Auth::user()->id)->first();
            $this->full_name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone_number;
        }


        return view('livewire.website.checkout',  [
            'id' => "",
            'quantity' => "",
            'shop' => "",
            'customUrl' => "checkout",
        ]);
    }
}
