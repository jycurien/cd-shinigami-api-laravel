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

    public function index(): JsonResponse
    {
        return response()->json($this->cardOrderRepository->findAllWithCenterAndCardNumbers());
    }

    public function create(Request $request, CardOrderHandler $cardOrderHandler): JsonResponse
    {
        if (null === $request->input('center') || null === $request->input('quantity')) {
            return response()->json(['errorMessage' => 'You must provide a center code and a quantity'], Response::HTTP_BAD_REQUEST);
        }
        $order = $cardOrderHandler->create($request->input('center'), $request->input('quantity'));

        return response()->json($order, Response::HTTP_CREATED);
    }

    public function update(Request $request, CardOrder $order): JsonResponse
    {
        if (null === $request->input('received')) {
            return response()->json(['errorMessage' => 'You must provide a received state'], Response::HTTP_BAD_REQUEST);
        }

        $this->cardOrderRepository->update($order, ['received' => true]);
        return response()->json($order, Response::HTTP_OK);
    }
}
