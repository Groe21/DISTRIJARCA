<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'empresa',
        'asunto',
        'mensaje',
        'leido',
        'respondido',
        'respuesta',
        'fecha_respuesta',
    ];

    protected $casts = [
        'leido' => 'boolean',
        'respondido' => 'boolean',
        'fecha_respuesta' => 'datetime',
    ];

    // Scopes
    public function scopeNoLeidos($query)
    {
        return $query->where('leido', false)->latest();
    }

    public function scopePendientes($query)
    {
        return $query->where('respondido', false);
    }

    // Métodos
    public function marcarComoLeido()
    {
        $this->update(['leido' => true]);
    }

    public function responder($respuesta)
    {
        $this->update([
            'respuesta' => $respuesta,
            'respondido' => true,
            'fecha_respuesta' => now(),
        ]);
    }
}
