<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CollectorCompany;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'name' => 'EcoRecolección',
                'specialties' => null, // o puedes poner '', o alguna especialidad por defecto
            ],
            [
                'name' => 'VerdeReciclaje',
                'specialties' => null,
            ],
            [
                'name' => 'Reciclajes Unidos',
                'specialties' => null,
            ],
            // Puedes añadir más aquí si lo necesitas
        ];

        foreach ($companies as $company) {
            CollectorCompany::create($company);
        }
    }
}
