<?php

namespace App\Livewire\Website;

use App\Models\ReferalCode;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ReferalUsers extends Component
{
    #[Layout('components.layouts.websiteDashboard')]

    public function render()
    {
        $referal = ReferalCode::where('code', Auth::user()->referal_code)->with('user')->get();
        return view('livewire.website.referal-users', [
            'referal' => $referal
        ]);
    }
}
