<?php

namespace App\Http\Controllers;

use App\Models\CardOrder;
use App\Services\CardOrderHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CardOrderController extends Controller
{
    public function index()
    {
        return CardOrder::findAllWithCenterAndCardNumbers();
    }

    public function create(Request $request, CardOrderHandler $cardOrderHandler)
    {
        $parameters = json_decode($request->getContent());
        if (!isset($parameters->center) || !isset($parameters->quantity)) {
            return new JsonResponse(['errorMessage' => 'You must provide a center code and a quantity'], Response::HTTP_BAD_REQUEST);
        }
        $order = $cardOrderHandler->create($parameters->center, $parameters->quantity);

        return new JsonResponse($order, Response::HTTP_OK);
    }

    public function update(Request $request, CardOrder $order)
    {
        $parameters = json_decode($request->getContent());

        if (null === $parameters->received) {
            return new JsonResponse(['errorMessage' => 'You must provide a received state'], Response::HTTP_BAD_REQUEST);
        }

        $order->received = true;
        $order->save();
        return new JsonResponse($order, Response::HTTP_OK);
    }
}
