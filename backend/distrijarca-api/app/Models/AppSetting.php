<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
        'category',
    ];

    /**
     * Obtener un setting por clave
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting?->value ?? $default;
    }

    /**
     * Guardar un setting
     */
    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Obtener todos los settings de una categoría
     */
    public static function byCategory($category)
    {
        return static::where('category', $category)->get();
    }

    /**
     * Sincronizar .env con settings
     */
    public static function syncToEnv()
    {
        $settings = static::all();
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        foreach ($settings as $setting) {
            $pattern = '/^' . $setting->key . '=.*/m';
            $replacement = $setting->key . '=' . (str_contains($setting->value, ' ') ? '"' . $setting->value . '"' : $setting->value);
            $envContent = preg_replace($pattern, $replacement, $envContent);
        }

        file_put_contents($envPath, $envContent);
    }
}
