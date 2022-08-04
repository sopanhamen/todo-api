<?php

namespace App\Modules\Commune;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Commune\CommuneService;
use App\Modules\Commune\Exports\CommunesExport;
use App\Modules\Commune\Resources\CommuneResource;
use App\Modules\Commune\Requests\CreateCommuneRequest;
use App\Modules\Commune\Requests\UpdateCommuneRequest;
use Maatwebsite\Excel\Facades\Excel;

class CommuneController extends Controller
{
    protected $communeService;

    public function __construct(CommuneService $communeService)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->communeService = $communeService;
    }

    /**
     * @OA\GET(
     *     path="/api/communes",
     *     tags={"Communes"},
     *     summary="Get Communes list",
     *     description="Get Communes List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function index(Request $request)
    {
        $communes = $this->communeService->paginate($request->all());
        return CommuneResource::collection($communes);
    }

    /**
     * @OA\POST(
     *     path="/api/communes",
     *     tags={"Communes"},
     *     summary="Create a new Commune",
     *     description="Create a new Commune",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateCommuneRequest $request)
    {
        $communes = $this->communeService->createOne($request->all());
        return new CommuneResource($communes);
    }

    /**
     * @OA\GET(
     *     path="/api/communes/{id}",
     *     tags={"Communes"},
     *     summary="Get communes detail",
     *     description="Get communes detail by ID",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $communes = $this->communeService->getOneOrFail($id, $request->all());
        return new CommuneResource($communes);
    }

    /**
     * @OA\PUT(
     *     path="/api/communes/{id}",
     *     tags={"Communes"},
     *     summary="Update an existing Commune",
     *     description="Update an existing Commune",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateCommuneRequest $request, string $id)
    {
        $communes = $this->communeService->updateOne($id, $request->all());
        return new CommuneResource($communes);
    }

    /**
     * @OA\DELETE(
     *     path="/api/communes/{id}",
     *     tags={"Communes"},
     *     summary="Delete a Commune",
     *     description="Delete a Commune",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $communes = $this->communeService->deleteOne($id);
        return new CommuneResource($communes);
    }

    /**
     * @OA\POST(
     *     path="/api/communes/exports",
     *     tags={"Communes"},
     *     summary="Export communes to excel",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function exports()
    {
        return Excel::download(new CommunesExport, 'communes.xlsx');
    }
}
