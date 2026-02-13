<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'titulo',
        'subtitulo',
        'descripcion',
        'badge_texto',
        'badge_color',
        'imagen',
        'icono',
        'orden',
        'activo',
        'max_productos',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
        'max_productos' => 'integer',
    ];

    // Relaciones
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Obtener productos destacados de esta categoría
    public function productosDestacados()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id')
            ->where('destacado', true)
            ->where('activo', true)
            ->limit($this->max_productos);
    }

    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('orden', 'asc');
    }

    // Accessors
    public function getImagenUrlAttribute()
    {
        if ($this->imagen && file_exists(storage_path('app/public/' . $this->imagen))) {
            return asset('storage/' . $this->imagen);
        }
        return 'https://via.placeholder.com/800x600?text=' . urlencode($this->titulo ?? 'Imagen');
    }

    public function getBadgeClassAttribute()
    {
        return "badge bg-{$this->badge_color}";
    }

    public function getIconoClassAttribute()
    {
        return "bi {$this->icono}";
    }

    // Helper para obtener productos con límite
    public function getProductosParaMostrar($limite = null)
    {
        $limite = $limite ?? $this->max_productos;
        
        return Product::where('category_id', $this->category_id)
            ->where('destacado', true)
            ->where('activo', true)
            ->where('stock', '>', 0)
            ->limit($limite)
            ->get();
    }
}
