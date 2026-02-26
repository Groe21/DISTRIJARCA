<?php

namespace App\Mail;

use App\Models\Mensaje;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RespuestaMensaje extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Mensaje $mensaje)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: ' . $this->mensaje->asunto,
            to: $this->mensaje->email,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.respuesta-mensaje',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
