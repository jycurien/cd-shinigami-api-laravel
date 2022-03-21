<?php

namespace App\Services;

use App\Models\CardOrder;
use App\Repositories\CardOrderRepository;
use App\Repositories\CardRepository;

class CardOrderHandler
{

    public function __construct(private CardHandler $cardHandler, private CardRepository $cardRepository, private  CardOrderRepository $cardOrderRepository)
    {
    }

    public function create(int $centerCode, int $quantity): CardOrder
    {
        $startCodeCard = $this->cardRepository->findMaxCardCode($centerCode, 'material') + 1;
        $order = $this->cardOrderRepository->create(['quantity' => $quantity]);
        $order->quantity = $quantity;
        for ($i = 0; $i < $quantity; $i++) {
           $this->cardHandler->createMaterialCard($centerCode, $startCodeCard + $i, $order);
        }

        return $order;
    }
}
