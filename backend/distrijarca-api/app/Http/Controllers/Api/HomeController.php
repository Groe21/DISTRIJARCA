<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Obtener todas las secciones activas de la página principal
     * con sus productos destacados
     */
    public function getSections()
    {
        $sections = HomeSection::with(['category', 'productosDestacados'])
            ->activas()
            ->ordenadas()
            ->get()
            ->map(function ($section) {
                return [
                    'id' => $section->id,
                    'titulo' => $section->titulo,
                    'subtitulo' => $section->subtitulo,
                    'descripcion' => $section->descripcion,
                    'badge' => [
                        'texto' => $section->badge_texto,
                        'color' => $section->badge_color,
                        'class' => $section->badge_class,
                    ],
                    'imagen_url' => $section->imagen_url,
                    'icono' => $section->icono,
                    'icono_class' => $section->icono_class,
                    'categoria' => [
                        'id' => $section->category->id,
                        'nombre' => $section->category->nombre,
                        'slug' => $section->category->slug,
                    ],
                    'productos' => $section->getProductosParaMostrar()->map(function ($producto) {
                        return [
                            'id' => $producto->id,
                            'nombre' => $producto->nombre,
                            'marca' => $producto->marca,
                            'descripcion' => $producto->descripcion,
                            'sku' => $producto->sku,
                            'slug' => $producto->slug,
                            'imagen_url' => $producto->imagen_url,
                            'precio_caja' => $producto->precio_caja,
                            'precio_unidad' => $producto->precio_unidad,
                            'precio_formateado' => $producto->precio_formateado_caja,
                            'unidades_por_caja' => $producto->unidades_por_caja,
                            'stock_estado' => $producto->stock_estado,
                        ];
                    }),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $sections,
        ]);
    }

    /**
     * Obtener una sección específica con sus productos
     */
    public function getSection($id)
    {
        $section = HomeSection::with(['category', 'productosDestacados'])
            ->activas()
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $section->id,
                'titulo' => $section->titulo,
                'subtitulo' => $section->subtitulo,
                'descripcion' => $section->descripcion,
                'badge' => [
                    'texto' => $section->badge_texto,
                    'color' => $section->badge_color,
                ],
                'imagen_url' => $section->imagen_url,
                'icono' => $section->icono,
                'categoria' => [
                    'id' => $section->category->id,
                    'nombre' => $section->category->nombre,
                    'slug' => $section->category->slug,
                ],
                'productos' => $section->getProductosParaMostrar(),
            ],
        ]);
    }
}
