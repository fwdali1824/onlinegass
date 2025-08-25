<?php

namespace App\Livewire\Admin\Shops;

use App\Livewire\Website\Shop;
use App\Models\Shops;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ShopList extends Component
{
    use WithPagination;
    public $editId = '';
    public $name, $address, $lat, $long, $phone, $whatsapp, $time, $rate;
    public $showModal = false;

    public function openModal()
    {
        $this->reset('name'); // Clear the input
        $this->showModal = true;
    }
    public function editModal($id)
    {
        $shop = Shops::findOrFail($id);
        $this->editId = $shop->id;
        $this->name = $shop->name;
        $this->address = $shop->address;
        $this->phone = $shop->phone;
        $this->whatsapp = $shop->whatsapp;
        $this->rate = $shop->today_rate;
        $this->time = $shop->time;

        $this->showModal = true;
    }
    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:100',
        ]);

        if ($this->editId) {
            $product = Shops::find($this->editId);
            $product->update([
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'whatsapp' => $this->whatsapp,
                'whatsapp' => $this->whatsapp,
                'today_rate' => $this->rate,
                'time' => $this->rate,
            ]);
            session()->flash('success', 'Shop updated successfully!');
        } else {
            $product = Shops::create([
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'whatsapp' => $this->whatsapp,
                'today_rate' => $this->rate,
                'time' => $this->rate,
            ]);
            session()->flash('success', 'Shop created successfully!');
        }

        $this->reset();
        $this->resetPage(); // back to first page
        $this->showModal = false;
    }

    public function delete($id)
    {
        $category = Shop::find($id);
        if ($category) {
            $category->delete();
            session()->flash('success', 'Shop deleted.');
        } else {
            session()->flash('error', 'Shop not found.');
        }
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        $productList = Shops::paginate(10);
        return view('livewire.admin.shops.shop-list', [
            'productList' => $productList,
            'shoplayout' => 'layouts.ShopLocations',
        ]);
    }
}
