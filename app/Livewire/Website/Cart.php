<?php
namespace App\Livewire\Website;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Cart extends Component
{
    #[Layout('components.layouts.website')]
    public $cart = [];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function increment($id)
    {
        if (isset($this->cart[$id])) {
            $this->cart[$id]['quantity']++;
            session()->put('cart', $this->cart);
        }
    }

    public function decrement($id)
    {
        if (isset($this->cart[$id]) && $this->cart[$id]['quantity'] > 1) {
            $this->cart[$id]['quantity']--;
            session()->put('cart', $this->cart);
        }
    }

    public function remove($id)
    {
        unset($this->cart[$id]);
        session()->put('cart', $this->cart);
    }

    public function render()
    {
        return view('livewire.website.cart');
    }
}
