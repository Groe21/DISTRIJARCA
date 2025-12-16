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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('email', 100)->unique();
            $table->boolean('activo')->default(true);
            $table->string('nombre', 100)->nullable();
            $table->string('token_confirmacion', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            
            $table->index('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};
