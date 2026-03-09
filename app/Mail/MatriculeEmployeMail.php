<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MatriculeEmployeMail extends Mailable
{
    public $employe;

    public function __construct($employe)
    {
        $this->employe = $employe;
    }

    public function build()
    {
        return $this->subject('Votre matricule employé')
                    ->view('emails.matricule_employe');
    }
}