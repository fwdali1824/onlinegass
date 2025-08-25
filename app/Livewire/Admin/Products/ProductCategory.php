<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductCategory as ModelsProductCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductCategory extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $showModal = false;
    public $name = '';
    public $image = '';
    public $Editimage = '';
    public $editId = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'image' => 'required',
    ];

    public function openModal()
    {
        $this->reset('name'); // Clear the input
        $this->showModal = true;
    }

    public function editModal($id)
    {
        $category = ModelsProductCategory::findOrFail($id);
        $this->editId = $category->id;
        $this->name = $category->name;
        $this->Editimage = $category->image;
        $this->image = '';
        $this->showModal = true;
    }


    public function removeImage()
    {
        $this->image = null;
        $this->Editimage = null;
    }


    public function save()
    {
        if ($this->editId) {

            $this->validate([
                'name' => 'required|string|max:100',
                'image' => $this->editId ? 'nullable' : 'required|image|mimes:jpeg,webp,png,jpg,gif,svg|max:2048',
            ]);

            if ($this->Editimage) {
                $imagePath = $this->Editimage;
            } else {
                $storedPath = $this->image->store('products_category', 'public'); // stores file and returns path
                $imagePath = asset('storage/' . $storedPath);
            }
            ModelsProductCategory::where('id', $this->editId)->update([
                'name' => $this->name,
                'image' => $imagePath,
            ]);
            session()->flash('success', 'Product Category Updated successfully!');
        } else {

            $this->validate([
                'name' => 'required|string|max:100',
                'image' => 'required|image|mimes:jpeg,png,webp,jpg,gif,svg|max:2048',
            ]);
            $storedPath = $this->image->store('products_category', 'public'); // stores file and returns path
            $imagePath = asset('storage/' . $storedPath);            // creates URL to access the image
            ModelsProductCategory::create([
                'name' => $this->name,
                'image' => $imagePath,
            ]);
            session()->flash('success', 'Product Category update successfully!');
        }

        $this->reset(['name', 'showModal']);
        $this->resetPage(); // go to first page
    }

    public function delete($id)
    {
        $category = ModelsProductCategory::find($id);
        $product = Product::where('product_category', $category->id)->first();

        if ($product) {
            session()->flash('success', 'Can not deleted Category.');
        } else {
            if ($category) {
                $category->delete();
                session()->flash('success', 'Product Category deleted.');
            } else {
                session()->flash('error', 'Category not found.');
            }
        }
    }

    #[Layout('components.layouts.admin')]

    public function render()
    {
        $productList = ModelsProductCategory::paginate(10);
        return view('livewire.admin.products.product-category', compact('productList'));
    }
}
