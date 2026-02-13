<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeSection;
use App\Models\Category;

class HomeSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener o crear las categorías
        $categoryQuesos = Category::firstOrCreate(
            ['nombre' => 'Quesos'],
            ['slug' => 'quesos', 'activo' => true, 'descripcion' => 'Variedad de quesos premium']
        );

        $categoryEmbutidos = Category::firstOrCreate(
            ['nombre' => 'Embutidos'],
            ['slug' => 'embutidos', 'activo' => true, 'descripcion' => 'Embutidos de calidad']
        );

        $categoryJamones = Category::firstOrCreate(
            ['nombre' => 'Jamones'],
            ['slug' => 'jamones', 'activo' => true, 'descripcion' => 'Jamones selectos']
        );

        $categoryEspeciales = Category::firstOrCreate(
            ['nombre' => 'Productos Especiales'],
            ['slug' => 'productos-especiales', 'activo' => true, 'descripcion' => 'Productos gourmet y especialidades']
        );

        // Crear las secciones de la página principal
        $sections = [
            [
                'category_id' => $categoryQuesos->id,
                'titulo' => 'Quesos Artesanales',
                'subtitulo' => null,
                'descripcion' => 'Amplia variedad de quesos nacionales e importados. Desde quesos frescos hasta maduros de alta gama.',
                'badge_texto' => 'Premium',
                'badge_color' => 'danger',
                'imagen' => 'home-sections/quesos-artesanales.jpg',
                'icono' => 'bi-star',
                'orden' => 1,
                'activo' => true,
                'max_productos' => 3,
            ],
            [
                'category_id' => $categoryEmbutidos->id,
                'titulo' => 'Embutidos Selectos',
                'subtitulo' => null,
                'descripcion' => 'Embutidos tradicionales y gourmet elaborados con las mejores carnes y especias seleccionadas.',
                'badge_texto' => 'Selectos',
                'badge_color' => 'danger',
                'imagen' => 'home-sections/embutidos-selectos.jpg',
                'icono' => 'bi-award',
                'orden' => 2,
                'activo' => true,
                'max_productos' => 3,
            ],
            [
                'category_id' => $categoryJamones->id,
                'titulo' => 'Jamones Premium',
                'subtitulo' => null,
                'descripcion' => 'Jamones de primera calidad, curados y cocidos, ideales para delicatessen y restaurantes.',
                'badge_texto' => 'Gourmet',
                'badge_color' => 'danger',
                'imagen' => 'home-sections/jamones-premium.jpg',
                'icono' => 'bi-gem',
                'orden' => 3,
                'activo' => true,
                'max_productos' => 3,
            ],
            [
                'category_id' => $categoryEspeciales->id,
                'titulo' => 'Productos Especiales',
                'subtitulo' => null,
                'descripcion' => 'Selección exclusiva de productos gourmet y especialidades para paladares exigentes.',
                'badge_texto' => 'Especial',
                'badge_color' => 'danger',
                'imagen' => 'home-sections/productos-especiales.jpg',
                'icono' => 'bi-gift',
                'orden' => 4,
                'activo' => true,
                'max_productos' => 3,
            ],
        ];

        foreach ($sections as $section) {
            HomeSection::updateOrCreate(
                [
                    'category_id' => $section['category_id'],
                    'titulo' => $section['titulo']
                ],
                $section
            );
        }

        $this->command->info('✅ Se han creado ' . count($sections) . ' secciones para la página principal');
        $this->command->warn('⚠️  Recuerda subir las imágenes a: storage/app/public/home-sections/');
    }
}
