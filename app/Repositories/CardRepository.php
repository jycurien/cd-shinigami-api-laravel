<?php

namespace App\Repositories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Collection;

class CardRepository
{
    const LIMIT_CARDS_TO_DISPLAY = 20;

    /**
     * @param string $fullCode
     * @return Card|null
     */
    public function findByFullCode(string $fullCode): ?Card
    {
        [$centerCode, $cardCode, $checkSum] = $this->extractCodeParts($fullCode);
        return Card::where('center_code', $centerCode)
            ->where('card_code', $cardCode)
            ->where('check_sum', $checkSum)
            ->firstOrFail();
    }


    /**
     * @return Collection
     */
    public function findLatest(): Collection
    {
        return Card::orderBy('id', 'DESC')->take(self::LIMIT_CARDS_TO_DISPLAY)->get();
    }

    /**
     * @param int $centerCode
     * @param string $type
     * @return int|null
     */
    public function findMaxCardCodeByCenterAndType(int $centerCode, string $type): ?int
    {
        return Card::where('center_code', $centerCode)
            ->where('type', $type)
            ->max('card_code');
    }

    /**
     * @param int $centerCode
     * @param string $type
     * @return int|null
     */
    public function findMaxCardCode(int $centerCode, string $type): ?int
    {
        return Card::where('center_code', $centerCode)
            ->where('type', $type)
            ->max('card_code');
    }

    public function create(array $cardAttributes): Card
    {
        return Card::create($cardAttributes);
    }

    /**
     * @param string $code
     * @return array
     */
    private function extractCodeParts(string $code): array
    {
        return [substr($code, 0, 3), substr($code, 3, 6), substr($code, 9)];
    }
}
