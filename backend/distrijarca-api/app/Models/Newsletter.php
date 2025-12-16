<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'nombre',
        'activo',
        'token_confirmacion',
        'email_verified_at',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeVerificados($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    // Métodos
    public function verificarEmail()
    {
        $this->update([
            'email_verified_at' => now(),
            'token_confirmacion' => null,
        ]);
    }
}
