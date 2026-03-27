<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deteccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('sector_id')->constrained('sectores')->onDelete('cascade');
            $table->text('imagen_url')->nullable();
            $table->string('enfermedad', 100);
            $table->decimal('confianza', 5, 2);
            $table->decimal('tiempo_deteccion', 5, 2);
            $table->text('observaciones')->nullable();
            $table->text('recomendacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deteccion');
    }
};
