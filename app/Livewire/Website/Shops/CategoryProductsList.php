<?php

namespace App\Livewire\Website\Shops;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use App\Models\Shops;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CategoryProductsList extends Component
{
    public $category;
    public $categoryID;
    public $selectedShop; // Selected shop ID

    #[Layout('components.layouts.website')]
    public function mount($id)
    {
        $this->category = ProductCategory::findOrFail($id);
        $this->categoryID = $id;
        $this->selectedShop = null; // default no shop filter
    }


    public function render()
    {
        $shops = Shops::all();

        $query = Product::where('product_category', $this->categoryID);

        if (!empty($this->selectedShop)) {
            $query->where('shop', $this->selectedShop);
        }

        $products = $query->paginate(10);

        return view('livewire.website.shops.category-products-list', [
            'products' => $products,
            'shops' => $shops
        ]);
    }
}
