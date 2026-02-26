<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $password;
    public $userName;

    public function __construct($userName, $password)
    {
        $this->password = $password;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject('Réinitialisation de votre mot de passe')
                    ->view('emails.reset_password');
    }
}