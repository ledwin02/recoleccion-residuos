<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WasteType;
use App\Models\CollectorCompany;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CollectionRequestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // o usa un ID fijo si ya hay usuarios
            'waste_type_id' => WasteType::factory(), // o usa un ID existente
            'company_id' => CollectorCompany::factory(), // se puede sobreescribir en el seeder
            'collection_date' => now()->addDays(rand(1, 7))->format('Y-m-d'),
            'collection_time' => $this->faker->time('H:i'),
            'frequency' => $this->faker->randomElement(['weekly', 'biweekly', 'monthly', 'on_demand']),
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}
