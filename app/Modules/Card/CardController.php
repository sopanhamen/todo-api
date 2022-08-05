<?php

namespace App\Modules\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Card\CardService;
use App\Modules\Card\Resources\CardResource;
use App\Modules\Card\Requests\CreateCardRequest;
use App\Modules\Card\Requests\UpdateCardRequest;

class CardController extends Controller
{
    protected $cardService;

    public function __construct(CardService $cardService)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->cardService = $cardService;
    }

    /**
     * @OA\GET(
     *     path="/api/cards",
     *     tags={"Cards"},
     *     summary="Get Cards list",
     *     description="Get Cards List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $cards = $this->cardService->paginate($request->all());
        return CardResource::collection($cards);
    }

    /**
     * @OA\GET(
     *     path="/api/cards/{id}",
     *     tags={"Cards"},
     *     summary="Get Card detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $card = $this->cardService->getOneOrFail($id, $request->all());
        return new CardResource($card);
    }

    /**
     * @OA\POST(
     *     path="/api/cards",
     *     tags={"Cards"},
     *     summary="Create a new Card",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateCardRequest $request)
    {
        // dd($request);
        $card = $this->cardService->createOne($request->all());
        return new CardResource($card);
    }

    /**
     * @OA\PUT(
     *     path="/api/cards/{id}",
     *     tags={"Cards"},
     *     summary="Update an existing Card",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateCardRequest $request, string $id)
    {
        $card = $this->cardService->updateOne($id, $request->all());
        return new CardResource($card);
    }

    /**
     * @OA\DELETE(
     *     path="/api/cards/{id}",
     *     tags={"Cards"},
     *     summary="Delete a Card",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {

        $card = $this->cardService->deleteOne($id);
        return new CardResource($card);
    }

    /**
     * @OA\POST(
     *     path="/api/cards/{id}/restore",
     *     tags={"Cards"},
     *     summary="Restore a Card from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        $card = $this->cardService->restoreOne($id);
        return new CardResource($card);
    }
}
