<?php

namespace App\Services;

use App\Models\Factory;

class ShippingCalculator
{
    public function calculate(string $city, int $weightKg, ?Factory $factory = null): array
    {
        $distanceFactor = mb_strtolower(trim($city)) === 'تهران' ? 1 : 1.35;
        $factoryFactor = $factory?->city && mb_strtolower($factory->city) === mb_strtolower($city) ? .7 : 1;
        $base = 1_500_000;
        $perTon = 850_000;
        $total = (int) round(($base + (($weightKg / 1000) * $perTon)) * $distanceFactor * $factoryFactor);

        return ['amount' => max($total, $base), 'weight_kg' => $weightKg, 'city' => $city, 'factory' => $factory?->name];
    }
}
