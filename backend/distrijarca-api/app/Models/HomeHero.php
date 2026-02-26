<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomeHero extends Model
{
    use HasFactory;

    protected $fillable = [
        'texto',
        'imagen_fondo',
    ];

    public function getImagenFondoUrlAttribute(): string
    {
        if ($this->imagen_fondo && Storage::disk('public')->exists($this->imagen_fondo)) {
            return asset('storage/' . $this->imagen_fondo);
        }

        return 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=1920';
    }
}
