<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'nombre',
        'marca',
        'descripcion',
        'slug',
        'sku',
        'codigo_barras',
        'precio_caja',
        'precio_unidad',
        'precio_mayoreo',
        'unidades_por_caja',
        'peso_caja',
        'peso_unidad',
        'imagen',
        'stock',
        'cantidad_minima_pedido',
        'cantidad_mayoreo',
        'stock_alerta',
        'activo',
        'destacado',
        'unidad_medida',
        'caracteristicas',
        'origen',
        'fecha_vencimiento',
        'dias_caducidad',
        'temperatura_almacenamiento',
    ];

    protected $casts = [
        'precio_caja' => 'decimal:2',
        'precio_unidad' => 'decimal:2',
        'precio_mayoreo' => 'decimal:2',
        'peso_caja' => 'decimal:2',
        'peso_unidad' => 'decimal:3',
        'activo' => 'boolean',
        'destacado' => 'boolean',
        'fecha_vencimiento' => 'date',
    ];

    // Relaciones
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeDestacados($query)
    {
        return $query->where('destacado', true);
    }

    public function scopeConStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeStockBajo($query)
    {
        return $query->whereColumn('stock', '<=', 'stock_alerta');
    }

    public function scopePorMarca($query, $marca)
    {
        return $query->where('marca', $marca);
    }

    // Mutadores
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            $product->slug = Str::slug($product->nombre);
            
            // Generar SKU automáticamente si no se proporciona
            if (empty($product->sku)) {
                $product->sku = strtoupper(substr($product->nombre, 0, 3)) . '-' . time();
            }
        });
        
        static::updating(function ($product) {
            if ($product->isDirty('nombre')) {
                $product->slug = Str::slug($product->nombre);
            }
        });
    }

    // Accessors
    public function getImagenUrlAttribute()
    {
        if ($this->imagen) {
            return asset('storage/' . $this->imagen);
        }
        return asset('assets/placeholder-product.png');
    }

    public function getPrecioFormateadoCajaAttribute()
    {
        return '$' . number_format($this->precio_caja, 2);
    }

    public function getPrecioFormateadoUnidadAttribute()
    {
        return $this->precio_unidad ? '$' . number_format($this->precio_unidad, 2) : 'N/A';
    }

    public function getPrecioFormateadoMayoreoAttribute()
    {
        return $this->precio_mayoreo ? '$' . number_format($this->precio_mayoreo, 2) : 'N/A';
    }

    public function getStockEstadoAttribute()
    {
        if ($this->stock <= 0) {
            return 'sin_stock';
        } elseif ($this->stock <= $this->stock_alerta) {
            return 'stock_bajo';
        }
        return 'disponible';
    }

    public function getStockEstadoColorAttribute()
    {
        return match($this->stock_estado) {
            'sin_stock' => 'danger',
            'stock_bajo' => 'warning',
            'disponible' => 'success',
            default => 'secondary'
        };
    }

    // Helpers para cálculos
    public function calcularPrecioTotal($cantidad, $tipo_precio = 'caja')
    {
        $precio_base = match($tipo_precio) {
            'unidad' => $this->precio_unidad ?? ($this->precio_caja / $this->unidades_por_caja),
            'mayoreo' => $this->precio_mayoreo ?? $this->precio_caja,
            default => $this->precio_caja
        };

        // Aplicar precio mayoreo si se cumple la cantidad mínima
        if ($tipo_precio === 'caja' && $this->cantidad_mayoreo && $cantidad >= $this->cantidad_mayoreo && $this->precio_mayoreo) {
            $precio_base = $this->precio_mayoreo;
        }

        return $precio_base * $cantidad;
    }

    public function calcularPesoTotal($cantidad_cajas)
    {
        return $this->peso_caja ? $this->peso_caja * $cantidad_cajas : null;
    }

    public function tieneStockDisponible($cantidad)
    {
        return $this->stock >= $cantidad;
    }

    public function cumpleMinimoPedido($cantidad)
    {
        return $cantidad >= $this->cantidad_minima_pedido;
    }
}
