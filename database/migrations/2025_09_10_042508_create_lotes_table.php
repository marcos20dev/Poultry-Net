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
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sector_id')->constrained('sectores')->onDelete('cascade');
            $table->integer('cantidad_pollos');
            $table->integer('edad_dias');
            $table->string('etapa'); // Ejemplo: Inicio, Intermedio, Final
            $table->string('raza');  // Ejemplo: Ross 308, Cobb 500
            $table->date('fecha_ingreso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};
