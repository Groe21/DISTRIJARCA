<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display settings form
     */
    public function index()
    {
        $emailSettings = AppSetting::byCategory('email');
        return view('admin.settings.email', compact('emailSettings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'MAIL_MAILER' => 'required|string',
            'MAIL_HOST' => 'required|string',
            'MAIL_PORT' => 'required|numeric',
            'MAIL_USERNAME' => 'required|string',
            'MAIL_PASSWORD' => 'required|string',
            'MAIL_ENCRYPTION' => 'required|string',
            'MAIL_FROM_ADDRESS' => 'required|email',
            'MAIL_FROM_NAME' => 'required|string',
        ], [
            'MAIL_FROM_ADDRESS.email' => 'El email del remitente debe ser válido',
            'MAIL_PORT.numeric' => 'El puerto debe ser un número',
        ]);

        foreach ($validated as $key => $value) {
            AppSetting::set($key, $value);
        }

        // Sincronizar con .env
        try {
            AppSetting::syncToEnv();
        } catch (\Exception $e) {
            // Si no puede escribir el .env, se guardan en BD
            \Log::warning('No se pudo sincronizar con .env: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Configuración de email actualizada correctamente');
    }

    /**
     * Test email configuration
     */
    public function testEmail(Request $request)
    {
        try {
            $testEmail = $request->input('test_email', auth()->user()->email);
            
            // Crear mail con configuración actual
            \Mail::raw('Este es un email de prueba de DISTRI-JARCA', function ($message) use ($testEmail) {
                $message->to($testEmail)
                    ->subject('Prueba de Email - DISTRI-JARCA');
            });

            return back()->with('success', 'Email de prueba enviado a: ' . $testEmail);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al enviar email: ' . $e->getMessage());
        }
    }
}
