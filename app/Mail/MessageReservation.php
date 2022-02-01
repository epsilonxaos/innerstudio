<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jenssegers\Date\Date;

class MessageReservation extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Inner - Reservacion creada";
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
    public function __construct($name, $respuesta)
    {
        $this -> name = $name;
        $this -> tipo = $respuesta -> tipo;
        $this -> start = $respuesta -> start;
        $this -> instrutor = $respuesta -> name;
        $this -> no_mat = $respuesta -> no_mat;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.message-reservacion')
        -> with([
            "name" => $this -> name,
            "tipo" => $this -> tipo,
            "start" => $this -> start,
            "instrutor" => $this -> instrutor,
            "no_mat" => $this -> no_mat,
            ]);
    }
}
