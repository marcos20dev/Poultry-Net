<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sectores', function (Blueprint $table) {
            // 👇 nullable primero para no romper con datos viejos
            $table->unsignedBigInteger('user_id')->nullable()->after('id');

            // relación con tabla users
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        // ✅ Opcional: asignar user_id por defecto al usuario 1
        // DB::table('sectores')->update(['user_id' => 1]);

        // Luego, si quieres, quitas el nullable en otra migración
    }

    public function down()
    {
        Schema::table('sectores', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
