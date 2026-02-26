<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mensaje;
use App\Mail\RespuestaMensaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MensajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mensajes = Mensaje::latest()->paginate(15);
        $noLeidos = Mensaje::where('leido', false)->count();
        $pendientes = Mensaje::where('respondido', false)->count();

        return view('admin.mensajes.index', compact('mensajes', 'noLeidos', 'pendientes'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Mensaje $mensaje)
    {
        // Marcar como leído
        if (!$mensaje->leido) {
            $mensaje->marcarComoLeido();
        }

        return view('admin.mensajes.show', compact('mensaje'));
    }

    /**
     * Update the specified resource (responder mensaje).
     */
    public function update(Request $request, Mensaje $mensaje)
    {
        $validated = $request->validate([
            'respuesta' => 'required|string|min:10',
        ], [
            'respuesta.required' => 'La respuesta es requerida',
            'respuesta.min' => 'La respuesta debe tener al menos 10 caracteres',
        ]);

        $mensaje->responder($validated['respuesta']);

        // Enviar email de respuesta al cliente
        try {
            Mail::to($mensaje->email)->send(new RespuestaMensaje($mensaje));
        } catch (\Exception $e) {
            // Si falla el email, la respuesta ya está guardada
            \Log::error('Error enviando email de respuesta: ' . $e->getMessage());
        }

        return redirect()->route('admin.mensajes.show', $mensaje)
            ->with('success', 'Respuesta enviada correctamente al cliente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mensaje $mensaje)
    {
        $mensaje->delete();

        return redirect()->route('admin.mensajes.index')
            ->with('success', 'Mensaje eliminado correctamente');
    }

    /**
     * Mark as read
     */
    public function marcarLeido(Mensaje $mensaje)
    {
        $mensaje->marcarComoLeido();

        return response()->json(['success' => true]);
    }

    /**
     * Toggle respondido status
     */
    public function toggleRespondido(Mensaje $mensaje)
    {
        $mensaje->update(['respondido' => !$mensaje->respondido]);

        return response()->json(['success' => true, 'respondido' => $mensaje->respondido]);
    }
}
