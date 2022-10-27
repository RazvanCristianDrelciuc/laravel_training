<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckoutMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $order;
    public $items;

    public function __construct($order)
    {
        $this->order = $order;
      //  $this->items = $items;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        $order = $this->order;
        return $this->view('template', compact('order'));
    }
    /*public function build()
    {
        return $this->view('template')->with(['order' => $this->order]);
//        return $this->view('template')->with(['order' => $this->order,'items' => $this->items]);


    }*/
}
