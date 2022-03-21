<?php

namespace App\Services;

use App\Models\Card;
use App\Models\CardOrder;
use App\Repositories\CardRepository;

class CardHandler
{
    const MIN_NUMERIC_CARD_CODE = 500000;

    public function __construct(private CheckSumCalculator $checkSumCalculator, private CardRepository $cardRepository)
    {
    }

    public function create(string $centerCode): Card
    {
        // We check the max number card for the given center
        $maxCardCode = $this->cardRepository->findMaxCardCodeByCenterAndType($centerCode, 'numeric');

        $newCardCode = $maxCardCode ? $maxCardCode + 1 : self::MIN_NUMERIC_CARD_CODE;

        return $this->createNumericCard($centerCode, $newCardCode);
    }

    public function update($code): ?Card
    {
        /** @var Card $card */
        $card = $this->cardRepository->findByFullCode($code);

        // We check if the card exists and if the activation date is not already set
        if($card && null === $card->activated_at) {
            $card->activated_at = new \DateTime();
            $card->save();
        } else {
            // We set the card to null if it doesn't exists OR if activationDate is already set
            $card = null;
        }

        return $card;
    }

    public function createNumericCard(int $centerCode, int $cardCode): Card
    {
        return $this->cardRepository->create([
            'center_code' => $centerCode,
            'card_code' => $cardCode,
            'type' => 'numeric',
            'check_sum' => $this->checkSumCalculator->calculateCheckSum($centerCode, $cardCode),
        ]);
    }

    public function createMaterialCard(int $centerCode, int $cardCode, CardOrder $order): Card
    {
        return $this->cardRepository->create([
            'center_code' => $centerCode,
            'card_code' => $cardCode,
            'type' => 'material',
            'check_sum' => $this->checkSumCalculator->calculateCheckSum($centerCode, $cardCode),
            'card_order_id' => $order->id
        ]);
    }
}
