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
        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('titulo');
            $table->string('subtitulo')->nullable();
            $table->text('descripcion');
            $table->string('badge_texto')->nullable()->comment('Ej: Premium, Selectos, Gourmet');
            $table->string('badge_color')->default('danger')->comment('primary, danger, warning, success, etc.');
            $table->string('imagen');
            $table->string('icono')->default('bi-star')->comment('Clase de Bootstrap Icons');
            $table->integer('orden')->default(0)->comment('Orden de aparición en la home');
            $table->boolean('activo')->default(true);
            $table->integer('max_productos')->default(3)->comment('Cantidad máxima de productos a mostrar');
            $table->timestamps();

            $table->index('orden');
            $table->index('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};
