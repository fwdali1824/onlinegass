<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shops;
use App\Models\StockPurchase;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ProductList extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $editId = '';

    public $name, $image, $product_category, $description, $weight, $price, $stock, $shop, $p_price;
    public $is_cylinder = true;
    public $cylinder_type = 'domestic';
    public $cylinder_material, $cylinder_capacity, $cylinder_pressure;
    public $status = 'active';
    public $showModal = false;
    public $dummyImage = 'https://sclpa.com/wp-content/uploads/2022/10/dummy-img-1.jpg';


    public function openModal()
    {
        $this->reset(); // Clear the input
        $this->showModal = true;
    }


    public function removeImage()
    {
        $this->image = null;
    }

    public function editModal($id)
    {
        $product = Product::findOrFail($id);
        $this->editId = $product->id;
        $this->name = $product->name;
        $this->product_category = $product->product_category;
        // $this->weight = $product->weight;
        // $this->price = $product->price;
        // $this->stock = $product->stock;
        $this->is_cylinder = $product->is_cylinder;
        $this->cylinder_type = $product->cylinder_type;
        $this->cylinder_material = $product->cylinder_material;
        $this->cylinder_capacity = $product->cylinder_capacity;
        $this->cylinder_pressure = $product->cylinder_pressure;
        $this->description = $product->description;
        $this->status = $product->status;
        // $this->image = $product->image;
        $this->shop = $product->shop;
        // $this->p_price = $product->p_price;
        $this->showModal = true;
    }


    public function save()
    {

      
        if ($this->editId) {

            $this->validate([
                'name' => 'required|string|max:100',
                'image' => $this->editId ? 'nullable' : 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'product_category' => 'required|exists:product_categories,id',
                // 'weight' => 'required|string',
                // 'price' => 'required|numeric',
                // 'stock' => 'required|integer|min:0',
                'is_cylinder' => 'required|boolean',
                'cylinder_type' => 'required|in:domestic,commercial,industrial',
                'cylinder_material' => 'nullable|string',
                'cylinder_capacity' => 'nullable|string',
                'cylinder_pressure' => 'nullable|string',
                'status' => 'required|in:active,discontinued',
                'shop' => 'required',
                'description' => 'required',
                // 'p_price' => 'required'
            ]);
            $product = Product::find($this->editId);
            if ($this->image) {
                $storedPath = $this->image->store('products', 'public'); // stores file and returns path
                $imagePath = asset('storage/' . $storedPath);            // creates URL to access the image
            } else {
                $imagePath = $product->image;
            }
            $product->update([
                'name' => $this->name,
                'image' => $imagePath, // don't overwrite if not re-uploaded
                'product_category' => $this->product_category,
                // 'weight' => $this->weight,
                // 'price' => $this->price,
                // 'stock' => $this->stock,
                'is_cylinder' => $this->is_cylinder,
                'cylinder_type' => $this->cylinder_type,
                'cylinder_material' => $this->cylinder_material,
                'cylinder_capacity' => $this->cylinder_capacity,
                'cylinder_pressure' => $this->cylinder_pressure,
                'status' => $this->status,
                'shop' => $this->shop,
                'description' => $this->description,
                // 'p_price' => $this->p_price,
            ]);


            // $stocksp = StockPurchase::where('product_id', $this->editId)->first();
            // if (!$stocksp) {
            //     $stocksp = new StockPurchase();
            // }
            // $stocksp->product_id = $this->editId;
            // $stocksp->qty = $this->stock;
            // $stocksp->price = $this->price;
            // $stocksp->p_price = $this->p_price;
            // $stocksp->user_id = Auth::user()->id;
            // $stocksp->shop = $this->shop;
            // $stocksp->save();

            session()->flash('success', 'Product updated successfully!');
        } else {
            $this->validate([
                'name' => 'required|string|max:100',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'product_category' => 'required|exists:product_categories,id',
                'weight' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer|min:0',
                'is_cylinder' => 'required|boolean',
                'cylinder_type' => 'required|in:domestic,commercial,industrial',
                'cylinder_material' => 'nullable|string',
                'cylinder_capacity' => 'nullable|string',
                'cylinder_pressure' => 'nullable|string',
                'status' => 'required|in:active,discontinued',
                'shop' => 'required',
                'description' => 'required',
                'p_price' => 'required'
            ]);
            
            if ($this->image) {
                $storedPath = $this->image->store('products', 'public'); // stores file and returns path
                $imagePath = asset('storage/' . $storedPath);            // creates URL to access the image
            } else {
                $imagePath = null;
            }


            $product = Product::create([
                'name' => $this->name,
                'image' => $imagePath,
                'product_category' => $this->product_category,
                'weight' => $this->weight,
                'price' => $this->price,
                'stock' => $this->stock,
                'is_cylinder' => $this->is_cylinder,
                'cylinder_type' => $this->cylinder_type,
                'cylinder_material' => $this->cylinder_material,
                'cylinder_capacity' => $this->cylinder_capacity,
                'cylinder_pressure' => $this->cylinder_pressure,
                'status' => $this->status,
                'shop' => $this->shop,
                'description' => $this->description,
                'p_price' => $this->p_price,
            ]);


            $stocksp = new StockPurchase();
            $stocksp->product_id = $this->editId;
            $stocksp->qty = $this->stock;
            $stocksp->price = $this->price;
            $stocksp->user_id = Auth::user()->id;
            $stocksp->p_price = $this->p_price;
            $stocksp->shop = $this->shop;
            $stocksp->save();

            session()->flash('success', 'Product created successfully!');
        }

        $this->reset();
    }


    public function delete($id)
    {
        $category = Product::find($id);
        if ($category) {
            $category->delete();
            session()->flash('success', 'Product Category deleted.');
        } else {
            session()->flash('error', 'Category not found.');
        }
    }

    #[Layout('components.layouts.admin')]


    public function render()
    {
        $productList = Product::with('productcategory')->get();
        $shopList = Shops::all();
        $productcategory = ProductCategory::all(); // ✅ correct model here
        return view('livewire.admin.products.product-list', [
            'productList' => $productList,
            'productcategory' => $productcategory,
            'shopList' => $shopList
        ]);
    }
}
