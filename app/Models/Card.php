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

    public static function findByFullCode(string $fullCode)
    {
        [$centerCode, $cardCode, $checkSum] = self::extractCodeParts($fullCode);
        return self::where('center_code', $centerCode)
            ->where('card_code', $cardCode)
            ->where('check_sum', $checkSum)
            ->firstOrFail();
    }

    /**
     * @param string $code
     * @return array
     */
    private static function extractCodeParts(string $code): array
    {
        return [substr($code, 0, 3), substr($code, 3, 6), substr($code, 9)];
    }
}
