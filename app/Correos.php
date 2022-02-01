<?php

namespace App;

use PHPMailer\PHPMailer;

class Correos
{
    public $mail;

    public function __construct () {
        $this -> mail = new PHPMailer\PHPMailer();
        $this -> mail -> IsSMTP();
        $this -> mail -> Mailer = "mail";
        $this -> mail -> Host = "mail.locker.agency";
        $this -> mail -> SMTPAuth = true;
        $this -> mail -> Username = "contact@locker.agency";
        $this -> mail -> Password = "locker07";
        $this -> mail -> From = "noreply@innerstudio.mx";
        $this -> mail -> FromName = "Inner Studio";

        $this -> mail -> SMTPSecure = 'tls';
        $this -> mail -> Port = 587;
        $this -> mail -> AddReplyTo("noreply@innerstudio.mx");
        $this -> mail -> IsHTML(true);
        $this -> mail -> CharSet = "UTF-8";
        $this -> mail -> Subject = "";
    }

    public function bodyMessage () {
        $this -> mail -> Body = '<h1>Prueba de correo SMTP Laravel';
    }

    public function subjectMessage () {
        $this -> mail -> Subject = "Prueba de configuracion";
    }

    public function fromMessage () {
        $this -> mail -> AddAddress("wilberthg16@gmail.com");
    }

    public function enviar(){
        self::subjectMessage();
        self::fromMessage();
        self::bodyMessage();

        if($this -> mail -> Send()){
            return "true";
        }
        else{
            return "false";
        }
    }
}
