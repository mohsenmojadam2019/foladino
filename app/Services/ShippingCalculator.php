<?php

namespace App\Services;

use App\Models\Factory;
use App\Models\ShippingRate;

class ShippingCalculator
{
    public function calculate(string $city, int $weightKg, ?Factory $factory = null): array
    {
        $rate = ShippingRate::where('is_active', true)->where('destination_city', $city)->when($factory?->city, fn($q) => $q->where('origin_city', $factory->city))->where('min_weight_kg','<=',$weightKg)->where(fn($q) => $q->whereNull('max_weight_kg')->orWhere('max_weight_kg','>=',$weightKg))->first();
        if ($rate) return ['amount' => (int) $rate->base_price_toman + ($weightKg * (int) $rate->price_per_kg_toman), 'weight_kg' => $weightKg, 'city' => $city, 'factory' => $factory?->name];
        $distanceFactor = mb_strtolower(trim($city)) === 'تهران' ? 1 : 1.35;
        $factoryFactor = $factory?->city && mb_strtolower($factory->city) === mb_strtolower($city) ? .7 : 1;
        $base = 1_500_000;
        $perTon = 850_000;
        $total = (int) round(($base + (($weightKg / 1000) * $perTon)) * $distanceFactor * $factoryFactor);

        return ['amount' => max($total, $base), 'weight_kg' => $weightKg, 'city' => $city, 'factory' => $factory?->name];
    }
}
