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
        Schema::create('home_abouts', function (Blueprint $table) {
            $table->id();
            $table->string('label')->default('Nuestra Historia');
            $table->string('title_before')->default('Más de');
            $table->string('title_highlight')->default('15 años');
            $table->string('title_after')->default('llevando sabor a tu mesa');
            $table->text('paragraph_1');
            $table->text('paragraph_2')->nullable();
            $table->string('stat_1_value')->default('15+');
            $table->string('stat_1_label')->default('Años de experiencia');
            $table->string('stat_2_value')->default('500+');
            $table->string('stat_2_label')->default('Clientes satisfechos');
            $table->string('stat_3_value')->default('200+');
            $table->string('stat_3_label')->default('Productos en catálogo');
            $table->string('image')->nullable();
            $table->string('image_alt')->default('Productos DISTRI-JARCA');
            $table->string('badge_text')->default('Calidad Certificada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_abouts');
    }
};
