<?php

namespace App\Livewire\Website\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UserForgertPassword extends Component
{
    public $email;
    public $forget = true;
    public $forgetpassword = false;
    public $password;
    public $forgetOTP;
    public $otpDigits = ['', '', '', '', '']; // 5 separate digits

    public function forgetPassword()
    {
        $user = User::where('email', $this->email)->first();

        if ($user) {
            // Generate a 6-digit OTP
            $this->forgetOTP = rand(10000, 99999);

            // Store OTP in the database (optional: with expiry time)
            $user->otp = $this->forgetOTP;
            $user->otp_expires_at = now()->addMinutes(10); // optional
            $user->save();

            // Send OTP via email
            Mail::to($user->email)->send(new \App\Mail\SendOtpMail($this->forgetOTP));
            $this->forget = false;
            session()->flash('success', 'Check Your Email');
        }
    }

    public function verifyOtp()
    {
        $otp = implode('', $this->otpDigits); // combine 5 digits into one OTP

        $user = User::where('email', $this->email)
            ->where('otp', $otp)
            ->where('otp_expires_at', '>', now())
            ->first();

        if ($user) {
            session()->flash('success', 'OTP verified. Redirecting to reset page...');
            $this->forgetpassword = true;
            // continue to password reset logic
        } else {
            session()->flash('error', 'Invalid or expired OTP.');
        }
    }

    public function forgetPasswordNew()
    {
        $user = User::where('email', $this->email)
            ->first();

        if ($user) {
            $user->password = Hash::make($this->password);
            $user->save();
            Auth::login($user);
            session()->flash('success', 'Password change Successfully');
            return redirect('/user-dashboard');
        }
    }
    #[Layout('components.layouts.websiteAuth')]

    public function render()
    {
        return view('livewire.website.auth.user-forgert-password');
    }
}
