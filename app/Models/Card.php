<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Card extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    /**
     * @return Attribute
     */
    public function fullCardCode(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['center_code'].$attributes['card_code'].$attributes['check_sum']
        );
    }

    /**
     * @return BelongsTo
     */
    public function cardOrder(): BelongsTo
    {
        return $this->belongsTo(CardOrder::class);
    }

    public static function findMaxCardCodeByCenterAndType(int $centerCode, string $type): ?int
    {
        return self::where('center_code', $centerCode)
            ->where('type', $type)
            ->max('card_code');
    }
}
