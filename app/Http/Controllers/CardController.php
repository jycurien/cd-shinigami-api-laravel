<?php

namespace App\Http\Controllers;

use App\Repositories\CardRepository;
use App\Services\CardHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class CardController extends Controller
{
    public function __construct(private CardRepository $cardRepository)
    {
    }

    public function show(string $code)
    {
        if (10 !== strlen($code)) {
            throw new InvalidArgumentException('Invalid card number');
        }
        return $this->cardRepository->findByFullCode($code);
    }

    public function index()
    {
        return $this->cardRepository->findLatest();
    }

    public function create(Request $request, CardHandler $cardHandler): JsonResponse
    {
        $parameters = json_decode($request->getContent());
        if (!isset($parameters->center)) {
            return  response()->json(['errorMessage' => 'You must provide a center code'], Response::HTTP_BAD_REQUEST);
        }
        // TODO validate center code
        $card = $cardHandler->create($parameters->center);
        return response()->json($card, Response::HTTP_OK);
    }

    public function update(string $code, CardHandler $cardHandler)
    {
        $card = $cardHandler->update($code);
        return response()->json($card, Response::HTTP_OK);
    }
}
