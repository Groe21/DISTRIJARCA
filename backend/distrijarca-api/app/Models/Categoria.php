<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'icono',
        'color',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
    ];

    // Relaciones
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('activo', true)->orderBy('orden');
    }

    // Métodos
    public function getProductosActivosAttribute()
    {
        return $this->productos()->where('activo', true)->count();
    }
}
