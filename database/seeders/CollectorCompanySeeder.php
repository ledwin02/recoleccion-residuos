<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CollectorCompany;

class CollectorCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'id'         => 1,
                'name'       => 'EcoRecicla S.A.',
                'address'    => 'Av. Ecológica 123',
                'phone'      => '600111111',
                'email'      => 'ecorecicla@example.com',
                'website'    => 'https://ecorecicla.example.com',
                'specialties'=> 'Plásticos, Electrónicos'
            ],
            [
                'id'         => 2,
                'name'       => 'Verde Futuro',
                'address'    => 'Calle Reciclaje 456',
                'phone'      => '600222222',
                'email'      => 'contacto@verdefuturo.example',
                'website'    => 'https://verdefuturo.example',
                'specialties'=> 'Vidrio, Papel, Cartón'
            ],
        ];

        foreach ($companies as $company) {
            CollectorCompany::updateOrCreate(
                ['id' => $company['id']],
                $company
            );
        }
    }
}
