<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Email Settings
            [
                'key' => 'MAIL_MAILER',
                'value' => env('MAIL_MAILER', 'smtp'),
                'type' => 'text',
                'description' => 'Mailer (smtp)',
                'category' => 'email',
            ],
            [
                'key' => 'MAIL_HOST',
                'value' => env('MAIL_HOST', 'smtp.gmail.com'),
                'type' => 'text',
                'description' => 'Host SMTP',
                'category' => 'email',
            ],
            [
                'key' => 'MAIL_PORT',
                'value' => env('MAIL_PORT', '587'),
                'type' => 'number',
                'description' => 'Puerto SMTP',
                'category' => 'email',
            ],
            [
                'key' => 'MAIL_USERNAME',
                'value' => env('MAIL_USERNAME', 'tu_email@gmail.com'),
                'type' => 'text',
                'description' => 'Tu email de Google',
                'category' => 'email',
            ],
            [
                'key' => 'MAIL_PASSWORD',
                'value' => env('MAIL_PASSWORD', 'tu_contraseña_de_app_16_caracteres'),
                'type' => 'text',
                'description' => 'Contraseña de aplicación Google',
                'category' => 'email',
            ],
            [
                'key' => 'MAIL_ENCRYPTION',
                'value' => env('MAIL_ENCRYPTION', 'tls'),
                'type' => 'text',
                'description' => 'Encriptación',
                'category' => 'email',
            ],
            [
                'key' => 'MAIL_FROM_ADDRESS',
                'value' => env('MAIL_FROM_ADDRESS', 'admin@distrijarca.com'),
                'type' => 'email',
                'description' => 'Email remitente',
                'category' => 'email',
            ],
            [
                'key' => 'MAIL_FROM_NAME',
                'value' => env('MAIL_FROM_NAME', 'DISTRI-JARCA'),
                'type' => 'text',
                'description' => 'Nombre del remitente',
                'category' => 'email',
            ],
        ];

        foreach ($settings as $setting) {
            AppSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
