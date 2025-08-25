<?php

namespace App\Livewire\Website\Auth\Website;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class LoginWebsite extends Component
{
    #[Layout('components.layouts.websiteAuth')]

    public string $email = '';
    public string $password = '';

    public $customUrl = '';
    public $id = '';
    public $quantity = '';

    public function mount($customUrl, $id, $quantity)
    {

        $this->customUrl = $customUrl;
        $this->id = $id;
        $this->quantity = $quantity;
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            if (Auth::user()->role == 'admin') {
                session()->flash('error', 'Admin login is not allowed.');
                Auth::logout();  // Log out the admin immediately.
                return back();  // Refresh the current page.
            }
            session()->flash('success', 'Login successful!');
            if ($this->customUrl == 'product-checkout') {
                return redirect()->route('single.Product.checkout', ['id' => $this->id, 'quantity' => $this->quantity]);
            } else if ($this->customUrl == 'checkout') {
                return redirect()->route('checkout');
            }
            if (Auth::user()->role == 'admin') {
                session()->flash('success', 'Not Allowed Login');
                return;
            }
        } else {
            session()->flash('error', 'Invalid credentials.');
            return back();  // Refresh the current page on error.
        }
    }

    public function render()
    {
        return view('livewire.website.auth.website.login-website');
    }
}
