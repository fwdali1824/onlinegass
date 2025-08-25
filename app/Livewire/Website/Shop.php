<?php

namespace App\Livewire\Website;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shops;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Shop extends Component
{
    use WithPagination;

    public $cart = [];
    public $quantity = 1;

    public $search;
    public $selectedCategories = [];
    public $selectedShop = [];
    public $shopId = '';

    public $priceMax = '';

    protected $listeners = ['addToCart' => 'add', 'shopMarkerClicked' => 'onShopMarkerClicked'];

    public function showselectedShop()
    {
        return $this->getProducts();
    }


    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->selectedCategories = [];
    }

    public function showSelectedCategories()
    {
        return $this->getProducts();
    }



    public function getProducts()
    {
        $query = Product::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedCategories) {
            $query->whereIn('product_category', $this->selectedCategories);
        }

        if ($this->selectedShop) {
            $query->whereIn('shop', $this->selectedShop);
        }

        return $query->paginate(12);
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

    #[Layout('components.layouts.website')]
    public function render()
    {
        return view('livewire.website.shop', [
            'products' => $this->getProducts(),
            'shops' => Shops::all(),
            'productsCategory' => ProductCategory::all(),
        ]);
    }
}
