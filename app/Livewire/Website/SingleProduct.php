<?php

namespace App\Livewire\Website;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SingleProduct extends Component
{
    public $id;
    public $product;
    public $quantity = 1;


    #[Layout('components.layouts.website')]

    public $cart = [];

    protected $listeners = ['addToCart' => 'add'];

    public function add($productId)
    {
        $product = Product::findOrFail($productId);
        $cart = $this->cart;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1
            ];
        }

        $this->cart = $cart;
        session()->put('cart', $cart);
        session()->flash('success', 'Item Added Successfully');

        // $this->dispatchBrowserEvent('cart-updated');
    }

    public function buyNow($productId)
    {
        $qty = $this->quantity ?? 1;

        return redirect()->route('single.Product.checkout', [
            'id' => $productId,
            'quantity' => $qty,
        ]);
    }

    public function mount($id)
    {
        $this->id = $id;
        $this->product = Product::with('productcategory')->find($id);
        $this->cart = session()->get('cart', []);
    }

    public function render()
    {
        return view('livewire.website.single-product');
    }
}
