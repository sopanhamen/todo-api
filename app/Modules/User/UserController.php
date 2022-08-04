<?php

namespace App\Modules\User;

use App\Http\Controllers\Controller;
use App\Modules\User\Requests\CreateUserRequest;
use App\Modules\User\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Modules\User\UserService;
use App\Modules\User\Resources\UserResource;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    /**
     * @OA\GET(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Get users list",
     *     description="Get User List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $users = $this->userService->paginate($request->all());
        return UserResource::collection($users);
    }

    /**
     * @OA\GET(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Get User detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $this->authorize('view', User::class);

        $user = $this->userService->getOneOrFail($id, $request->all());
        return new UserResource($user);
    }

    /**
     * @OA\GET(
     *     path="/api/verify",
     *     tags={"Users"},
     *     summary="Verify User active status",
     *     operationId="verify",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function verify(Request $request)
    {
        $user = $this->userService->getOneByEmail($request->user ?? '');
        return new UserResource($user);
    }

    /**
     * @OA\POST(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Create a User",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(CreateUserRequest $request)
    {
        $this->authorize('create', User::class);

        $user = $this->userService->createOne($request->all());
        return new UserResource($user);
    }

    /**
     * @OA\PUT(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Update an existing User",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $this->authorize('update', User::class);

        $user = $this->userService->updateOne($id, $request->all());
        return new UserResource($user);
    }

    /**
     * @OA\DELETE(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Delete a User",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(Request $request, string $id)
    {
        $user = $this->userService->getOneOrFail($id, $request->all());

        $this->authorize('delete', $user);

        $this->userService->deleteModel($user);

        return new UserResource($user);
    }

    /**
     * @OA\GET(
     *     path="/api/users/trash",
     *     tags={"Users"},
     *     summary="Get users trashed list",
     *     description="Get users trashed List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function trash(Request $request)
    {
        $this->authorize('delete', User::class);

        $user = $this->userService->paginateFromTrash($request->all());
        return UserResource::collection($user);
    }

    /**
     * @OA\POST(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Restore a User from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', User::class);

        $user = $this->userService->restoreOne($id);
        return new UserResource($user);
    }

    /**
     * @OA\GET(
     *     path="/api/users/teammates",
     *     tags={"Users"},
     *     summary="Get teammate users list",
     *     description="Get Teammate User List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function teammates(Request $request)
    {
        $users = $this->userService->getTeammates($request->user());
        return UserResource::collection($users);
    }
}
