<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageMailq extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = "Inner - Cancelacion de Clase";
    public $name;
    public $tipo;
    public $start;
    public $instrutor;
    public $no_mat;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        //url
        $this -> url = $url;
      
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.message_mailq')
        -> with([
            "url" => $this -> url
            ]);
    }
}
