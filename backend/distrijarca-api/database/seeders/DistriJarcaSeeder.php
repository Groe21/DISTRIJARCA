<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Producto;

class DistriJarcaSeeder extends Seeder
{
    public function run(): void
    {
        // Crear categorías
        $quesos = Categoria::create([
            'nombre' => 'Quesos Artesanales',
            'descripcion' => 'Amplia variedad de quesos nacionales e importados',
            'icono' => 'bi-star-fill',
            'color' => '#F9B233',
            'orden' => 1,
            'activo' => true,
        ]);

        $embutidos = Categoria::create([
            'nombre' => 'Embutidos Selectos',
            'descripcion' => 'Embutidos tradicionales y gourmet',
            'icono' => 'bi-hearts',
            'color' => '#F28E80',
            'orden' => 2,
            'activo' => true,
        ]);

        $jamones = Categoria::create([
            'nombre' => 'Jamones Premium',
            'descripcion' => 'Jamones de primera calidad, curados y cocidos',
            'icono' => 'bi-gem',
            'color' => '#DA251D',
            'orden' => 3,
            'activo' => true,
        ]);

        $especiales = Categoria::create([
            'nombre' => 'Productos Especiales',
            'descripcion' => 'Selección exclusiva de productos gourmet',
            'icono' => 'bi-gift-fill',
            'color' => '#102542',
            'orden' => 4,
            'activo' => true,
        ]);

        // Crear productos de ejemplo
        // Quesos
        Producto::create([
            'categoria_id' => $quesos->id,
            'nombre' => 'Queso Fresco',
            'descripcion' => 'Queso fresco artesanal de alta calidad',
            'precio' => 5.50,
            'stock' => 50,
            'unidad_medida' => 'kg',
            'codigo_producto' => 'QF-001',
            'destacado' => true,
            'activo' => true,
        ]);

        Producto::create([
            'categoria_id' => $quesos->id,
            'nombre' => 'Queso Mozzarella',
            'descripcion' => 'Mozzarella italiana para pizzas y ensaladas',
            'precio' => 7.80,
            'stock' => 30,
            'unidad_medida' => 'kg',
            'codigo_producto' => 'QM-002',
            'destacado' => true,
            'activo' => true,
        ]);

        Producto::create([
            'categoria_id' => $quesos->id,
            'nombre' => 'Queso Maduro',
            'descripcion' => 'Queso maduro con 12 meses de curación',
            'precio' => 12.50,
            'stock' => 20,
            'unidad_medida' => 'kg',
            'codigo_producto' => 'QMD-003',
            'destacado' => false,
            'activo' => true,
        ]);

        // Embutidos
        Producto::create([
            'categoria_id' => $embutidos->id,
            'nombre' => 'Chorizo Artesanal',
            'descripcion' => 'Chorizo tradicional con especias seleccionadas',
            'precio' => 8.90,
            'stock' => 40,
            'unidad_medida' => 'kg',
            'codigo_producto' => 'CH-004',
            'destacado' => true,
            'activo' => true,
        ]);

        Producto::create([
            'categoria_id' => $embutidos->id,
            'nombre' => 'Salami Premium',
            'descripcion' => 'Salami tipo italiano de primera calidad',
            'precio' => 11.20,
            'stock' => 25,
            'unidad_medida' => 'kg',
            'codigo_producto' => 'SAL-005',
            'destacado' => true,
            'activo' => true,
        ]);

        // Jamones
        Producto::create([
            'categoria_id' => $jamones->id,
            'nombre' => 'Jamón Serrano',
            'descripcion' => 'Jamón serrano curado 18 meses',
            'precio' => 18.50,
            'stock' => 15,
            'unidad_medida' => 'kg',
            'codigo_producto' => 'JS-006',
            'destacado' => true,
            'activo' => true,
        ]);

        Producto::create([
            'categoria_id' => $jamones->id,
            'nombre' => 'Jamón Cocido',
            'descripcion' => 'Jamón cocido premium para sándwiches',
            'precio' => 9.80,
            'stock' => 35,
            'unidad_medida' => 'kg',
            'codigo_producto' => 'JC-007',
            'destacado' => false,
            'activo' => true,
        ]);

        // Productos Especiales
        Producto::create([
            'categoria_id' => $especiales->id,
            'nombre' => 'Pâté Artesanal',
            'descripcion' => 'Pâté de cerdo con hierbas finas',
            'precio' => 14.90,
            'stock' => 10,
            'unidad_medida' => 'kg',
            'codigo_producto' => 'PAT-008',
            'destacado' => false,
            'activo' => true,
        ]);

        $this->command->info('✅ Datos de DISTRI-JARCA cargados exitosamente!');
        $this->command->info('📊 Categorías: 4');
        $this->command->info('📦 Productos: 8');
    }
}
