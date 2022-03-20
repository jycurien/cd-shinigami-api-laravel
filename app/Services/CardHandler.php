<?php

namespace App\Services;

use App\Models\Card;

class CardHandler
{
    const MIN_NUMERIC_CARD_CODE = 500000;

    public function __construct(private CheckSumCalculator $checkSumCalculator)
    {
    }

    public function create(string $centerCode): Card
    {
        // We check the max number card for the given center
        $maxCardCode = Card::findMaxCardCodeByCenterAndType($centerCode, 'numeric');

        $newCardCode = $maxCardCode ? $maxCardCode + 1 : self::MIN_NUMERIC_CARD_CODE;

        return $this->createNumericCard($centerCode, $newCardCode);
    }

    private function createNumericCard(int $centerCode, int $cardCode): Card
    {
        return Card::create([
            'center_code' => $centerCode,
            'card_code' => $cardCode,
            'type' => 'numeric',
            'check_sum' => $this->checkSumCalculator->calculateCheckSum($centerCode, $cardCode),
        ]);
    }
}
