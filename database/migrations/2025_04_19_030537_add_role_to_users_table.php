<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        // Verifica si la columna 'role' ya existe en la tabla 'users'
        if (!Schema::hasColumn('users', 'role')) {
            // Si no existe, agrega la columna 'role'
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user');
            });
        }
    }

    /**
     * Revertir las migraciones.
     *
     * @return void
     */
    public function down()
    {
        // Elimina la columna 'role' si existe
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
