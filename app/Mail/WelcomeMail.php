<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected string $mensaje;

    public function __construct(string $mensaje)
    {
        $this->mensaje = $mensaje;
    }

    public function build()
    {
        return $this->subject('Bienvenido')
                    ->text('emails.plain') // plantilla opcional
                    ->with(['mensaje' => $this->mensaje]);
    }
}
