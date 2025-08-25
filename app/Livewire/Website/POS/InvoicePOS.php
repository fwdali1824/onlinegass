<?php

namespace App\Livewire\Website\POS;

use Livewire\Attributes\Layout;
use Livewire\Component;

class InvoicePOS extends Component
{
    #[Layout('components.layouts.posLayout')]

    public $cart;
    public $total;
    public $time;
    
    public function mount()
    {
        $data = session('pos_invoice_data');

        if (!$data) {
            abort(403, 'No invoice data available.');
        }

        $this->cart = $data['cart'];
        $this->total = $data['total'];
        $this->time = $data['time'];
    }


    public function render()
    {
        return view('livewire.website.p-o-s.invoice-p-o-s');
    }
}
