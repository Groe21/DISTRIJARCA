<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;
use App\Mail\NuevoMensajeRecibido;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'empresa' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string',
        ]);

        $mensaje = Mensaje::create($validated);

        // Enviar email al administrador
        try {
            Mail::to(config('mail.from.address'))->send(new NuevoMensajeRecibido($mensaje));
        } catch (\Exception $e) {
            // Si falla el email, no afecta el guardado del mensaje
            \Log::error('Error enviando email de nuevo mensaje: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.');
    }
}
