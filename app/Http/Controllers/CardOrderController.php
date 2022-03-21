<?php

namespace App\Http\Controllers;

use App\Models\CardOrder;
use App\Repositories\CardOrderRepository;
use App\Services\CardOrderHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CardOrderController extends Controller
{
    public function __construct(private CardOrderRepository $cardOrderRepository)
    {
    }

    public function index()
    {
        return $this->cardOrderRepository->findAllWithCenterAndCardNumbers();
    }

    public function create(Request $request, CardOrderHandler $cardOrderHandler): JsonResponse
    {
        $parameters = json_decode($request->getContent());
        if (!isset($parameters->center) || !isset($parameters->quantity)) {
            return response()->json(['errorMessage' => 'You must provide a center code and a quantity'], Response::HTTP_BAD_REQUEST);
        }
        $order = $cardOrderHandler->create($parameters->center, $parameters->quantity);

        return response()->json($order, Response::HTTP_OK);
    }

    public function update(Request $request, CardOrder $order): JsonResponse
    {
        $parameters = json_decode($request->getContent());

        if (null === $parameters->received) {
            return response()->json(['errorMessage' => 'You must provide a received state'], Response::HTTP_BAD_REQUEST);
        }

        $this->cardOrderRepository->update($order, ['received' => true]);
        return response()->json($order, Response::HTTP_OK);
    }
}
