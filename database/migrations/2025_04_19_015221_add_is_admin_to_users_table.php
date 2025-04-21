<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAdminToUsersTable extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);  // Agregar el campo is_admin con valor por defecto 'false'
        });
    }

    /**
     * Deshacer las migraciones.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');  // Eliminar el campo is_admin si se deshace la migración
        });
    }
}
