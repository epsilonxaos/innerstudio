<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $token;
    protected $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail,$tok)
    {
       $this->token = $tok;
       $this->email = $mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->to($this->email);
        return $this->from('noreply@innerstudio.mx')->view('emails.reset')->with([
            'url' => route('password.reset',['token'=>$this->token,'email'=>$this->email]),
        ]);
    }
}
