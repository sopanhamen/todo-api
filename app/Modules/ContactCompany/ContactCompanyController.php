<?php

namespace App\Modules\ContactCompany;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ContactCompany\ContactCompanyService;
use App\Modules\ContactCompany\Resources\ContactCompanyResource;
use App\Modules\ContactCompany\Requests\CreateContactCompanyRequest;
use App\Modules\ContactCompany\Requests\UpdateContactCompanyRequest;

class ContactCompanyController extends Controller
{
    protected $contactCompanyService;

    public function __construct(ContactCompanyService $contactCompanyService)
    {
        $this->contactCompanyService = $contactCompanyService;
    }

    /**
     * @OA\GET(
     *     path="/api/contact-companies",
     *     tags={"Contact Companies"},
     *     summary="Get Contact Companies list",
     *     description="Get Contact Companies List as Array",
     *     operationId="index",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ContactCompany::class);

        $contactCompanies = $this->contactCompanyService->paginate($request->all());
        return ContactCompanyResource::collection($contactCompanies);
    }

    /**
     * @OA\GET(
     *     path="/api/contact-companies/{id}",
     *     tags={"Contact Companies"},
     *     summary="Get Contact Company detail",
     *     operationId="show",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        $this->authorize('view', ContactCompany::class);

        $contactCompany = $this->contactCompanyService->getOneOrFail($id, $request->all());
        return new ContactCompanyResource($contactCompany);
    }

    /**
     * @OA\POST(
     *     path="/api/contact-companies",
     *     tags={"Contact Companies"},
     *     summary="Create a new Contact Company",
     *     operationId="store",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateContactCompanyRequest $request)
    {
        $contactCompany = $this->contactCompanyService->createOne($request->all());
        return new ContactCompanyResource($contactCompany);
    }

    /**
     * @OA\PUT(
     *     path="/api/contact-companies/{id}",
     *     tags={"Contact Companies"},
     *     summary="Update an existing Contact Company",
     *     operationId="update",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateContactCompanyRequest $request, int $id)
    {
        $this->authorize('update', ContactCompany::class);

        $contactCompany = $this->contactCompanyService->updateOne($id, $request->all());
        return new ContactCompanyResource($contactCompany);
    }

    /**
     * @OA\DELETE(
     *     path="/api/contact-companies/{id}",
     *     tags={"Contact Companies"},
     *     summary="Delete a Contact Company",
     *     operationId="destroy",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        $this->authorize('delete', ContactCompany::class);

        $contactCompany = $this->contactCompanyService->deleteOne($id);
        return new ContactCompanyResource($contactCompany);
    }

    /**
     * @OA\POST(
     *     path="/api/contact-companies/{id}/restore",
     *     tags={"Contact Companies"},
     *     summary="Restore a Contact Company from trash",
     *     operationId="restore",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        $this->authorize('restore', ContactCompany::class);

        $contactCompany = $this->contactCompanyService->restoreOne($id);
        return new ContactCompanyResource($contactCompany);
    }
}