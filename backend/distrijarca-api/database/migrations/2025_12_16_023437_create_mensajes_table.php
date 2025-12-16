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
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('email', 100);
            $table->string('telefono', 20);
            $table->string('empresa', 100)->nullable();
            $table->string('asunto', 150)->default('Consulta general');
            $table->text('mensaje');
            $table->boolean('leido')->default(false);
            $table->boolean('respondido')->default(false);
            $table->text('respuesta')->nullable();
            $table->timestamp('fecha_respuesta')->nullable();
            $table->timestamps();
            
            $table->index('leido');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
