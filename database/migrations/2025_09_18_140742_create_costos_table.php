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
        Schema::create('costos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relación con usuario
            $table->decimal('gasto_deteccion', 10, 2); // Nuevo nombre para costo_deteccion
            $table->decimal('capital_inicial', 10, 2); // Nuevo nombre para inversion_inicial
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costos');
    }
};
