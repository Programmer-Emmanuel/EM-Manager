<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EntrepriseMatriculeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $entreprise;

    public function __construct($entreprise)
    {
        $this->entreprise = $entreprise;
    }

    public function build()
    {
        return $this->subject('Votre matricule entreprise')
                    ->view('emails.matricule_entreprise');
    }
}