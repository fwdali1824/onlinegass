<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $email, $phone, $password;

    public function __construct($name, $email, $phone, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Welcome to LPG')
            ->view('emails.test')->with([
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone,
                'password' => $this->password,
            ]);
    }
}
