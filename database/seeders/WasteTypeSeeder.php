<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WasteType;

class WasteTypeSeeder extends Seeder
{
    public function run(): void
    {
        $wasteTypes = [
            [
                'name' => 'Fracción orgánica',
                'category' => 'organico',
                'description' => 'Restos de comida, cáscaras de frutas, restos de alimentos cocidos.',
            ],
            [
                'name' => 'Fracción vegetal',
                'category' => 'organico',
                'description' => 'Restos de jardinería como hojas secas, ramas pequeñas, raíces.',
            ],
            [
                'name' => 'Residuos de poda',
                'category' => 'organico',
                'description' => 'Restos grandes de poda como ramas, troncos, tierra.',
            ],
            [
                'name' => 'Papel y cartón',
                'category' => 'inorganico',
                'description' => 'Papel, cartón, cartulina y productos reciclables de estos materiales.',
            ],
            [
                'name' => 'Plásticos',
                'category' => 'inorganico',
                'description' => 'Botellas plásticas, bolsas, envases, entre otros.',
            ],
            [
                'name' => 'Vidrio',
                'category' => 'inorganico',
                'description' => 'Envases de vidrio, botellas, frascos, etc.',
            ],
            [
                'name' => 'Metales',
                'category' => 'inorganico',
                'description' => 'Latas, chatarra metálica, utensilios metálicos reciclables.',
            ],
            [
                'name' => 'Baterías y pilas',
                'category' => 'peligroso',
                'description' => 'Pilas, baterías y otros productos que contienen metales pesados.',
            ],
            [
                'name' => 'Aceites usados',
                'category' => 'peligroso',
                'description' => 'Aceites de motor, aceites de cocina, entre otros.',
            ],
        ];

        foreach ($wasteTypes as $type) {
            WasteType::create($type);
        }
    }
}
