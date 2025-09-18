<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('respuestas_satisfaccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con usuarios
            $table->foreignId('pregunta_id')->constrained('preguntas_satisfaccion')->onDelete('cascade'); // Relación con la pregunta
            $table->unsignedTinyInteger('puntuacion'); // 1 a 5
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('respuestas_satisfaccion');
    }
};
