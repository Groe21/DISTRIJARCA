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
        Schema::create('home_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('label')->default('HABLEMOS');
            $table->string('title')->default('Estamos para servirte');
            $table->text('description');
            $table->string('address_title')->default('Dirección');
            $table->text('address');
            $table->string('phone_title')->default('Teléfono');
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->string('email_title')->default('Email');
            $table->string('email_1');
            $table->string('email_2')->nullable();
            $table->string('hours_title')->default('Horario de Atención');
            $table->string('hours_weekday')->default('Lunes a Viernes: 8:00 - 18:00');
            $table->string('hours_saturday')->default('Sábado: 8:00 - 13:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_contacts');
    }
};
