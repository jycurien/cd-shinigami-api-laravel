<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Services\CardHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class CardController extends Controller
{
    const LIMIT_CARDS_TO_DISPLAY = 20;

    public function show(string $code)
    {
        if (10 !== strlen($code)) {
            throw new InvalidArgumentException('Invalid card number');
        }
        return Card::findByFullCode($code);
    }

    public function index()
    {
        return Card::orderBy('id', 'DESC')->take(self::LIMIT_CARDS_TO_DISPLAY)->get();
    }

    public function create(Request $request, CardHandler $cardHandler): JsonResponse
    {
        $parameters = json_decode($request->getContent());
        if (!isset($parameters->center)) {
            return new JsonResponse(['errorMessage' => 'You must provide a center code'], Response::HTTP_BAD_REQUEST);
        }
        // TODO validate center code
        $card = $cardHandler->create($parameters->center);
        return new JsonResponse($card, Response::HTTP_OK);
    }

    public function update(string $code, CardHandler $cardHandler)
    {
        $card = $cardHandler->update($code);
        return new JsonResponse($card, Response::HTTP_OK);
    }
}
