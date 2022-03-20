<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    const LIMIT_CARDS_TO_DISPLAY = 20;

    public function index()
    {
        return Card::orderBy('id', 'DESC')->take(self::LIMIT_CARDS_TO_DISPLAY)->get();
    }
}
