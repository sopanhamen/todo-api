<?php

namespace App\Modules\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\User\UserService;
use App\Modules\User\Resources\UserResource;
use App\Modules\User\Requests\CreateUserRequest;
use App\Modules\User\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->userService = $userService;
    }

    /**
     * @OA\GET(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Get Users list",
     *     description="Get Users List as Array",
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
    public function show(Request $request, int $id)
    {
        $this->authorize('view', User::class);

        $user = $this->userService->getOneOrFail($id, $request->all());
        return new UserResource($user);
    }

    /**
     * @OA\POST(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Create a new User",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateUserRequest $request)
    {
        // $this->authorize('create', User::class);

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
    public function update(UpdateUserRequest $request, int $id)
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
    public function destroy(int $id)
    {
        $this->authorize('delete', User::class);

        $user = $this->userService->deleteOne($id);
        return new UserResource($user);
    }

    /**
     * @OA\POST(
     *     path="/api/users/{id}/restore",
     *     tags={"Users"},
     *     summary="Restore a User from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        $this->authorize('restore', User::class);

        $user = $this->userService->restoreOne($id);
        return new UserResource($user);
    }
}
