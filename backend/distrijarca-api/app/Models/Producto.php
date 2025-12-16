<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'unidad_medida',
        'imagen',
        'codigo_producto',
        'destacado',
        'activo',
        'caracteristicas',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'destacado' => 'boolean',
        'activo' => 'boolean',
        'caracteristicas' => 'array',
    ];

    // Relaciones
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeDestacados($query)
    {
        return $query->where('destacado', true)->where('activo', true);
    }

    public function scopeEnStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // Mutators
    public function getImagenUrlAttribute()
    {
        return $this->imagen ? asset('storage/' . $this->imagen) : null;
    }

    public function getPrecioFormateadoAttribute()
    {
        return '$' . number_format($this->precio, 2);
    }
}
