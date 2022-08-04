<?php

namespace App\Modules\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Client\ClientService;
use App\Modules\Client\Resources\ClientResource;
use App\Modules\Client\Requests\CreateClientRequest;
use App\Modules\Client\Requests\UpdateClientRequest;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->middleware('auth');
        $this->clientService = $clientService;
    }

    /**
     * @OA\GET(
     *     path="/api/clients",
     *     tags={"Clients"},
     *     summary="Get Clients list",
     *     description="Get Clients List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Client::class);

        $clients = $this->clientService->paginate($request->all());
        return ClientResource::collection($clients);
    }

    /**
     * @OA\GET(
     *     path="/api/clients/{id}",
     *     tags={"Clients"},
     *     summary="Get Client detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $this->authorize('view', Client::class);

        $client = $this->clientService->getOneOrFail($id, $request->all());
        return new ClientResource($client);
    }

    /**
     * @OA\POST(
     *     path="/api/clients",
     *     tags={"Clients"},
     *     summary="Create a new Client",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateClientRequest $request)
    {

        $this->authorize('create', Client::class);

        $client = $this->clientService->createOne($request->all());
        return new ClientResource($client);
    }

    /**
     * @OA\PUT(
     *     path="/api/clients/{id}",
     *     tags={"Clients"},
     *     summary="Update an existing Client",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateClientRequest $request, string $id)
    {
        $this->authorize('update', Client::class);

        $client = $this->clientService->updateOne($id, $request->all());
        return new ClientResource($client);
    }

    /**
     * @OA\DELETE(
     *     path="/api/clients/{id}",
     *     tags={"Clients"},
     *     summary="Delete a Client",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Client::class);

        $client = $this->clientService->deleteOne($id);
        return new ClientResource($client);
    }

    /**
     * @OA\POST(
     *     path="/api/clients/{id}/restore",
     *     tags={"Clients"},
     *     summary="Restore a Client from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function trash(Request $request)
    {
        $this->authorize('delete', Client::class);

        $clients = $this->clientService->paginateFromTrash($request->all());
        return ClientResource::collection($clients);
    }

    public function restore(string $id)
    {
        $this->authorize('restore', Client::class);

        $client = $this->clientService->restoreOne($id);
        return new ClientResource($client);
    }
}
