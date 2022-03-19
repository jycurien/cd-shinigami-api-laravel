<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function fullCardCode(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['center_code'].$attributes['card_code'].$attributes['check_sum']
        );
    }
}
