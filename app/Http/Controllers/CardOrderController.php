<?php

namespace App\Http\Controllers;

use App\Models\CardOrder;
use Illuminate\Http\Request;

class CardOrderController extends Controller
{
    public function index()
    {
        return CardOrder::findAllWithCenterAndCardNumbers();
    }
}
