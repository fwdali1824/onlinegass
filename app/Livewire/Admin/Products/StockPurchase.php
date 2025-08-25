<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Shops;
use App\Models\StockPurchase as ModelsStockPurchase;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class StockPurchase extends Component
{

    public $showModal = false;
    public $editIDL;
    public $productid;
    public $shop;
    public $weight;
    public $price;
    public $p_price;
    public $stock;

    public $dummyImage = 'https://sclpa.com/wp-content/uploads/2022/10/dummy-img-1.jpg';

    public function openModal()
    {
        $this->showModal = true;
        $this->editIDL = "";
        $stockPurchase = "";
        $this->productid = "";
        $this->shop = "";
        $this->weight = "";
        $this->price ="";
        $this->p_price = "";
        $this->stock = "";
    }


    public function editModal($editID)
    {
        $this->showModal = true;
        $this->editIDL = $editID;
        $stockPurchase = ModelsStockPurchase::findOrFail($editID);
        $this->productid = $stockPurchase->product_id;
        $this->shop = $stockPurchase->shop;
        $this->weight = $stockPurchase->weight;
        $this->price = $stockPurchase->price;
        $this->p_price = $stockPurchase->p_price;
        $this->stock = $stockPurchase->qty;
    }

    public function save()
    {
        if ($this->editIDL) {
            $product = Product::where('id', $this->productid)->where('shop', $this->shop)->first();
            if (!$product) {
                session()->flash('error', 'Product not found in the specified shop.');
                return;
            }

            $stockPurchase = ModelsStockPurchase::findOrFail($this->editIDL);
            $qtyM = $stockPurchase->qty - $this->stock;

            $product = Product::where('id', $this->productid)->where('shop', $this->shop)->first();
            $product->stock = $product->stock - $qtyM;
            $product->price = $this->price;
            $product->p_price = $this->p_price;
            $product->weight = $this->weight;
            $product->save();



            $stockPurchase = ModelsStockPurchase::findOrFail($this->editIDL);
            $stockPurchase->product_id = $this->productid;
            $stockPurchase->shop = $this->shop;
            $stockPurchase->weight = $this->weight;
            $stockPurchase->price = $this->price;
            $stockPurchase->p_price = $this->p_price;
            $stockPurchase->qty = $this->stock;
            $stockPurchase->user_id = Auth::user()->id;
            $stockPurchase->save();


            session()->flash('success', 'Product Purchase Update successfully!');
        } else {

            $stockPurchase = new ModelsStockPurchase();
            $stockPurchase->product_id = $this->productid;
            $stockPurchase->shop = $this->shop;
            $stockPurchase->weight = $this->weight;
            $stockPurchase->price = $this->price;
            $stockPurchase->p_price = $this->p_price;
            $stockPurchase->qty = $this->stock;
            $stockPurchase->user_id = Auth::user()->id;
            $stockPurchase->save();


            $product = Product::where('id', $this->productid)->where('shop', $this->shop)->first();
            $product->stock += $this->stock;
            $product->price = $this->price;
            $product->p_price = $this->p_price;
            $product->weight = $this->weight;
            $product->save();
            session()->flash('success', 'Product Purchase created successfully!');
        }

        $this->reset();
    }

    #[Layout('components.layouts.admin')]

    public function render()
    {
        $shopList = Shops::all();
        $stocksPurchase = Product::with('productcategory')->get();
        $productList = ModelsStockPurchase::with('product', 'productshop')->get();

        return view('livewire.admin.products.stock-purchase',
            [
                'productList' => $productList,
                'shopList' => $shopList,
                'stocksPurchase' => $stocksPurchase,
            ]
        );
    }
}
