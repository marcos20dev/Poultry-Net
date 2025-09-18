<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lotes', function (Blueprint $table) {
            // 1️⃣ Agregar columna nullable primero para no romper migración
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });

        // 2️⃣ Asignar un user_id a los registros existentes
        \DB::table('lotes')->update(['user_id' => 1]); // Aquí 1 = admin u otro user válido

        // 3️⃣ Cambiar columna a NOT NULL
        Schema::table('lotes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // relación con users
        });
    }

    public function down()
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
