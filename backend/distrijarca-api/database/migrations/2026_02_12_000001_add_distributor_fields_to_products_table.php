<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Información de distribución mayorista
            $table->string('sku')->unique()->nullable()->after('slug');
            $table->string('codigo_barras')->nullable()->after('sku');
            
            // Precios mayoristas
            $table->decimal('precio_unidad', 10, 2)->nullable()->after('precio')->comment('Precio por unidad individual');
            $table->renameColumn('precio', 'precio_caja');
            $table->decimal('precio_mayoreo', 10, 2)->nullable()->after('precio_unidad')->comment('Precio especial para grandes volúmenes');
            
            // Empaquetado
            $table->integer('unidades_por_caja')->default(1)->after('precio_mayoreo')->comment('Unidades que contiene cada caja');
            $table->decimal('peso_caja', 8, 2)->nullable()->after('unidades_por_caja')->comment('Peso en kg de la caja completa');
            $table->decimal('peso_unidad', 8, 3)->nullable()->after('peso_caja')->comment('Peso individual del producto');
            
            // Cantidades mínimas y stock
            $table->integer('cantidad_minima_pedido')->default(1)->after('stock')->comment('Cantidad mínima para pedidos');
            $table->integer('cantidad_mayoreo')->nullable()->after('cantidad_minima_pedido')->comment('Cantidad mínima para precio mayoreo');
            $table->integer('stock_alerta')->default(10)->after('cantidad_mayoreo')->comment('Nivel de stock para alertas');
            
            // Información adicional del producto
            $table->string('marca')->nullable()->after('nombre');
            $table->string('origen')->nullable()->after('marca')->comment('País/región de origen');
            $table->date('fecha_vencimiento')->nullable()->after('caracteristicas');
            $table->integer('dias_caducidad')->nullable()->after('fecha_vencimiento')->comment('Días de vida útil del producto');
            
            // Condiciones de almacenamiento
            $table->string('temperatura_almacenamiento')->nullable()->comment('Ej: 2-8°C, Temperatura ambiente');
            
            // Índices para búsquedas
            $table->index('sku');
            $table->index('marca');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'sku',
                'codigo_barras',
                'precio_unidad',
                'precio_mayoreo',
                'unidades_por_caja',
                'peso_caja',
                'peso_unidad',
                'cantidad_minima_pedido',
                'cantidad_mayoreo',
                'stock_alerta',
                'marca',
                'origen',
                'fecha_vencimiento',
                'dias_caducidad',
                'temperatura_almacenamiento',
            ]);
            
            $table->renameColumn('precio_caja', 'precio');
        });
    }
};
