<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CardOrder extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    /**
     * @return Collection
     */
    public static function findAllWithCenterAndCardNumbers(): Collection
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
}
