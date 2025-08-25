<?php

namespace App\Livewire\Website;

use Livewire\Attributes\Layout;
use Livewire\Component;

class ContactU extends Component
{
    #[Layout('components.layouts.website')]

    public function render()
    {
        return view('livewire.website.contact-u');
    }
}
