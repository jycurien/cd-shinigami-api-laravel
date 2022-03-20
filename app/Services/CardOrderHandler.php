<?php

namespace App\Services;

use App\Models\Card;
use App\Models\CardOrder;

class CardOrderHandler
{

    public function __construct(private CardHandler $cardHandler)
    {
    }

    public function create(int $centerCode, int $quantity): CardOrder
    {
        $startCodeCard = Card::findMaxCardCode($centerCode, 'material') + 1;
        $order = CardOrder::create(['quantity' => $quantity]);
        $order->quantity = $quantity;
        for ($i = 0; $i < $quantity; $i++) {
           $this->cardHandler->createMaterialCard($centerCode, $startCodeCard + $i, $order);
        }

        return $order;
    }
}
