<?php

namespace App\Modules\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Contact\ContactService;
use App\Modules\Contact\Resources\ContactResource;
use App\Modules\Contact\Requests\CreateContactRequest;
use App\Modules\Contact\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->middleware('auth');
        $this->contactService = $contactService;
    }

    /**
     * @OA\GET(
     *     path="/api/contacts",
     *     tags={"Contacts"},
     *     summary="Get Contacts list",
     *     description="Get Contacts List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Contact::class);

        $contacts = $this->contactService->paginate($request->all());
        return ContactResource::collection($contacts);
    }

    /**
     * @OA\GET(
     *     path="/api/contacts/{id}",
     *     tags={"Contacts"},
     *     summary="Get Contact detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $this->authorize('view', Contact::class);

        $contact = $this->contactService->getOneOrFail($id, $request->all());
        return new ContactResource($contact);
    }

    /**
     * @OA\POST(
     *     path="/api/contacts",
     *     tags={"Contacts"},
     *     summary="Create a new Contact",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateContactRequest $request)
    {
        $this->authorize('create', Contact::class);

        $contact = $this->contactService->createOne($request->all());
        return new ContactResource($contact);
    }

    /**
     * @OA\PUT(
     *     path="/api/contacts/{id}",
     *     tags={"Contacts"},
     *     summary="Update an existing Contact",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateContactRequest $request, string $id)
    {
        $this->authorize('update', Contact::class);

        $contact = $this->contactService->updateOne($id, $request->all());
        return new ContactResource($contact);
    }

    /**
     * @OA\DELETE(
     *     path="/api/contacts/{id}",
     *     tags={"Contacts"},
     *     summary="Delete a Contact",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Contact::class);

        $contact = $this->contactService->deleteOne($id);
        return new ContactResource($contact);
    }

    /**
     * @OA\POST(
     *     path="/api/contacts/{id}/restore",
     *     tags={"Contacts"},
     *     summary="Restore a Contact from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', Contact::class);

        $contact = $this->contactService->restoreOne($id);
        return new ContactResource($contact);
    }
}
