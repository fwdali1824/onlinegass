<?php

namespace App\Livewire\Website\TrackMyOrder;

use Livewire\Attributes\Layout;
use Livewire\Component;

class OrderFind extends Component
{
    #[Layout('components.layouts.websiteDashboard')]

    public function render()
    {
        return view('livewire.website.track-my-order.order-find');
    }
}
