<?php

namespace App\Services;

class CheckSumCalculator
{
    public function calculateCheckSum(int $centerCode, int $cardCode): int
    {
        $arrayCenterCode = array_map('intval', str_split($centerCode));
        $arrayCardCode = array_map('intval', str_split($cardCode));

        $arraySum = array_merge($arrayCenterCode, $arrayCardCode);

        return array_sum($arraySum) % 9;
    }
}
