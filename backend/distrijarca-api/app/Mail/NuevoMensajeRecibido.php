<?php

namespace App\Mail;

use App\Models\Mensaje;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevoMensajeRecibido extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Mensaje $mensaje)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo mensaje: ' . $this->mensaje->asunto,
            from: $this->mensaje->email,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nuevo-mensaje',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
