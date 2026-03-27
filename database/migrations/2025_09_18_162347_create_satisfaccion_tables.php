<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla de preguntas
        Schema::create('preguntas_satisfaccion', function (Blueprint $table) {
            $table->id();
            $table->string('pregunta');
            $table->timestamps();
        });

        // Pre-cargar preguntas
        DB::table('preguntas_satisfaccion')->insert([
            ['pregunta' => '¿Qué tan intuitivo considera el manejo de registros de datos en su granja?'],
            ['pregunta' => '¿Qué tan fácil le resulta realizar el seguimiento de la producción avícola en su granja?'],
            ['pregunta' => '¿Qué tan satisfecho se siente con los métodos actuales para monitorear la salud de las aves?'],
            ['pregunta' => '¿Qué tan satisfecho se siente con las herramientas disponibles para gestionar su granja?'],
            ['pregunta' => '¿Qué tan accesibles son los registros de su granja cuando los necesita?'],
            ['pregunta' => '¿Qué tan satisfecho se siente con el apoyo disponible para resolver problemas en su granja?'],
            ['pregunta' => '¿Qué tan eficientes considera los métodos actuales para controlar los costos operativos en su granja?'],
            ['pregunta' => '¿Qué tan alineados se encuentran los procesos actuales de su granja con las expectativas de gestión?'],
            ['pregunta' => '¿Qué tan dispuesto se siente a adoptar nuevas herramientas que mejoren la producción avícola?'],
            ['pregunta' => '¿Qué tan satisfecho se siente con el nivel de productividad actual de su granja?'],
        ]);

        // Tabla de respuestas
        Schema::create('respuestas_satisfaccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pregunta_id')->constrained('preguntas_satisfaccion')->onDelete('cascade');
            $table->unsignedTinyInteger('valor'); // 1 a 5
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respuestas_satisfaccion');
        Schema::dropIfExists('preguntas_satisfaccion');
    }
};

