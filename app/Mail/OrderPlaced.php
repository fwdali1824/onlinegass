<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $orderID;
    public $fullName;
    public $total;
    public $orderList;

    public function __construct($orderID, $fullName, $total, $orderList)
    {
        $this->orderID = $orderID;
        $this->fullName = $fullName;
        $this->total = $total;
        $this->orderList = $orderList;
    }

    public function build()
    {
        return $this->subject('Order Confirmation')
            ->view('emails.order_placed'); // Create this blade file for email content
    }
}
