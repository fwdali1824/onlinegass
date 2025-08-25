<?php

namespace App\Livewire\Admin\Sales;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $name, $email, $phone_number, $cnic, $address_line_1, $address_line_2, $city, $province, $postal_code;
    public $avatar, $newAvatar;

    public function mount()
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->cnic = $user->cnic;
        $this->address_line_1 = $user->address_line_1;
        $this->address_line_2 = $user->address_line_2;
        $this->city = $user->city;
        $this->province = $user->province;
        $this->postal_code = $user->postal_code;
        $this->avatar = $user->profile;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'newAvatar' => 'nullable|image|max:1024', // 1MB max
        ]);

        $user = Auth::user();

        // Upload new avatar if selected
        if ($this->newAvatar) {
            $imagePath = $this->newAvatar
                ? asset('storage/' . $this->newAvatar->store('profile', 'public'))
                : null;
            $user->avatar = $imagePath; // ✅ store path like "products/filename.png"
        }


        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'cnic' => $this->cnic,
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'profile' => $user->avatar,
        ]);

        session()->flash('success', 'Profile updated successfully!');
        return $this->redirect('/sales-profile');

    }

    #[Layout('components.layouts.Auth.SalesDashboard')]

    public function render()
    {
        return view('livewire.admin.sales.profile');
    }
}
