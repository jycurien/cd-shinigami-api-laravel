<?php

namespace App\Repositories;

use App\Models\CardOrder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CardOrderRepository
{
    /**
     * @return Collection
     */
    public function findAllWithCenterAndCardNumbers(): Collection
    {
        return DB::table('card_orders', 'co')
            ->join('cards AS c', 'co.id', '=', 'c.card_order_id')
            ->select([
                'co.id',
                'co.ordered_at',
                'co.quantity',
                'co.received',
                'c.center_code',

            ])
            ->addSelect(DB::raw('MIN(c.card_code) as min_card_code, MAX(c.card_code) as max_card_code'))
            ->groupBy('co.id','c.center_code')
            ->orderBy('co.ordered_at', 'DESC')
            ->get();
    }

    /**
     * @param array $cardOrderAttributes
     * @return CardOrder
     */
    public function create(array $cardOrderAttributes): CardOrder
    {
        return CardOrder::create($cardOrderAttributes);
    }

    /**
     * @param CardOrder $cardOrder
     * @param array $cardOrderAttributes
     * @return int
     */
    public function update(CardOrder $cardOrder, array $cardOrderAttributes): int
    {
        return CardOrder::where('id', $cardOrder->id)->update($cardOrderAttributes);
    }
}
