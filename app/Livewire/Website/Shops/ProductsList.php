<?php

namespace App\Livewire\Website\Shops;

use App\Models\Product;
use App\Models\Shops;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;

    public $shops;
    public $cart;
    public $quantity;

    #[Layout('components.layouts.website')]
    public function mount($id)
    {
        $this->shops = Shops::findOrFail($id);
    }

    public function buyNow($productId)
    {
        $qty = $this->quantity ?? 1;
        return redirect()->route('single.Product.checkout', [
            'id' => $productId,
            'quantity' => $qty,
        ]);
    }

    public function add($productId)
    {
        $product = Product::findOrFail($productId);
        $cart = $this->cart;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "id" => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'shop' => $product->shop,
                'quantity' => 1
            ];
        }

        $this->cart = $cart;
        session()->put('cart', $cart);
        session()->flash('success', 'Item added to cart');
    }



    public function render()
    {
        $products = Product::where('shop', $this->shops->id)->paginate(20);

        return view('livewire.website.shops.products-list', [
            'products' => $products,
        ]);
    }
}
