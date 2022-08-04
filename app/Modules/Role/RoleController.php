<?php

namespace App\Modules\Role;

use App\Http\Controllers\Controller;
use App\Modules\Role\Requests\CreateRoleRequest;
use App\Modules\Role\Requests\UpdateRoleRequest;
use App\Modules\Role\Requests\UpdateRolesRequest;
use Illuminate\Http\Request;
use App\Modules\Role\RoleService;
use App\Modules\Role\Resources\RoleResource;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->middleware('auth');
        $this->roleService = $roleService;
    }

    /**
     * @OA\GET(
     *     path="/api/users/roles",
     *     tags={"Roles"},
     *     summary="Get Roles list",
     *     description="Get Roles List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Role::class);

        $roles = $this->roleService->paginate($request->all());
        return RoleResource::collection($roles);
    }

    /**
     * @OA\GET(
     *     path="/api/users/roles/{id}",
     *     tags={"Roles"},
     *     summary="Get Role detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $this->authorize('view', Role::class);

        $role = $this->roleService->getOneOrFail($id, $request->all());
        return new RoleResource($role);
    }

    /**
     * @OA\POST(
     *     path="/api/users/roles",
     *     tags={"Roles"},
     *     summary="Create a Role",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(CreateRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        $role = $this->roleService->createOne($request->all());
        return new RoleResource($role);
    }

    /**
     * @OA\PUT(
     *     path="/api/users/roles/{id}",
     *     tags={"Roles"},
     *     summary="Update an existing Role",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        $this->authorize('update', Role::class);

        $role = $this->roleService->updateOne($id, $request->all());
        return new RoleResource($role);
    }

    /**
     * @OA\PUT(
     *     path="/api/users/roles",
     *     tags={"Roles"},
     *     summary="Update multiple Roles",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function updateMultiple(UpdateRolesRequest $request)
    {
        $this->authorize('update', Role::class);

        $roles = $this->roleService->updateMultiple($request->input('roles'));
        // return RoleResource::collection($roles);

        return $roles;
    }

    /**
     * @OA\DELETE(
     *     path="/api/users/roles/{id}",
     *     tags={"Roles"},
     *     summary="Delete a Role",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Role::class);

        $role = $this->roleService->getOneOrFail($id, ['counts' => 'users']);

        if ($role->users_count > 0) {
            abort(403);
        }

        $this->roleService->deleteModel($role);

        return new RoleResource($role);
    }

    /**
     * @OA\POST(
     *     path="/api/users/roles/{id}",
     *     tags={"Roles"},
     *     summary="Restore a Role from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', Role::class);

        $role = $this->roleService->restoreOne($id);
        return new RoleResource($role);
    }
}
