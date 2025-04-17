<?php

namespace App\Services;

use App\Models\CollectionRequest;

class PointService
{
    public function calculatePoints(CollectionRequest $request)
    {
        $basePoints = 10;
        $weightMultiplier = 2; // 2 puntos por kilo

        if ($request->waste_type_id == 2) { // Si es inorgánico
            return $basePoints + ($request->weight * $weightMultiplier);
        }

        return $basePoints;
    }
}
