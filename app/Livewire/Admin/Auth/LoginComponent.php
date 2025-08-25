<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

class LoginComponent extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    #[Layout('components.layouts.Auth.AdminAuth')]
    public function render()
    {
        return view('livewire.admin.auth.login-component');
    }

    public function login()
    {
        $credentials = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials, $this->remember)) {
            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }

        session()->regenerate();
        // dd(Auth::user()->role);
        if (Auth::user()->role == 'sales') {
            return redirect()->intended(route('sales.dashboard'));
        }

        if (Auth::user()->role == 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        if (Auth::user()->role == 'delivery') {
            return redirect()->intended(route('delivery.dashboard'));
        }
    }
}
