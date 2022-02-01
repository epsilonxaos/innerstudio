<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessagePurchase extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Inner - Confirmacion de compra";
    public $name;
    public $paquete;
    public $vigencia;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $response)
    {
        $this -> name = $name;
        $this -> paquete = $response -> no_class.' '.ucfirst($response -> title);
        $this -> vigencia = $response -> duration;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.message-compra');
    }
}
