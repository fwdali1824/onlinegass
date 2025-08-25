<?php

namespace App\Livewire\Admin\Shops;

use Livewire\Attributes\Layout;
use Livewire\Component;

class ShopListCreate extends Component
{
    #[Layout('components.layouts.admin')]

    public function render()
    {
        return view('livewire.admin.shops.shop-list-create');
    }
}
