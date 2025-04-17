<?php

namespace Database\Seeders;

use App\Models\CollectionRequest;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CollectionRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requests = [
            [
                'user_id' => 1,
                'waste_type_id' => 1,
                'company_id' => 1,
                'collection_date' => Carbon::tomorrow(),
                'collection_time' => '10:00',
                'frequency' => 'weekly',
                'is_on_demand' => false,
                'notes' => 'Primera recolección programada',
                'status' => 'pending',
                'weight' => 5.5,
                'points_earned' => 50
            ],
            [
                'user_id' => 1,
                'waste_type_id' => 2,
                'company_id' => 2,
                'collection_date' => Carbon::tomorrow()->addDays(3),
                'collection_time' => '14:00',
                'frequency' => 'biweekly',
                'is_on_demand' => true,
                'notes' => 'Recolección especial de materiales peligrosos',
                'status' => 'pending',
                'weight' => 8.2,
                'points_earned' => 75
            ]
        ];

        foreach ($requests as $request) {
            CollectionRequest::updateOrCreate(
                [
                    'user_id' => $request['user_id'],
                    'company_id' => $request['company_id'],
                    'collection_date' => $request['collection_date']
                ],
                $request
            );
        }
    }
}
