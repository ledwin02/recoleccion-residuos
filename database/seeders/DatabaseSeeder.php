<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario admin primero si no existe
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Desactivar temporalmente las comprobaciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Ejecutar seeders en el orden correcto
        $this->call([
            WasteTypeSeeder::class,      // Primero tipos de residuos
            CollectorCompanySeeder::class, // Luego empresas recolectoras
            CollectionRequestSeeder::class, // Finalmente solicitudes
        ]);

        // Reactivar las comprobaciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
