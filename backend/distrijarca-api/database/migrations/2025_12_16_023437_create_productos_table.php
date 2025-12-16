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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->string('nombre', 150);
            $table->text('descripcion');
            $table->decimal('precio', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('unidad_medida', 20)->default('kg'); // kg, unidad, gramos
            $table->string('imagen')->nullable();
            $table->string('codigo_producto', 50)->unique()->nullable();
            $table->boolean('destacado')->default(false);
            $table->boolean('activo')->default(true);
            $table->json('caracteristicas')->nullable(); // JSON para características adicionales
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('categoria_id');
            $table->index('destacado');
            $table->index('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
