<?php

namespace App\Modules\UserTeam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\UserTeam\UserTeamService;
use App\Modules\UserTeam\Resources\UserTeamResource;
use App\Modules\UserTeam\Requests\CreateUserTeamRequest;
use App\Modules\UserTeam\Requests\UpdateUserTeamRequest;

class UserTeamController extends Controller
{
    protected $userTeamService;

    public function __construct(UserTeamService $userTeamService)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->userTeamService = $userTeamService;
    }

    /**
     * @OA\GET(
     *     path="/api/user-teams",
     *     tags={"User Teams"},
     *     summary="Get UserTeams list",
     *     description="Get UserTeams List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', UserTeam::class);

        $userTeams = $this->userTeamService->paginate($request->all());
        return UserTeamResource::collection($userTeams);
    }

    /**
     * @OA\POST(
     *     path="/api/user-teams",
     *     tags={"User Teams"},
     *     summary="CREATE a new UserTeam",
     *     description="CREATE a new UserTeam",
     *     @OA\Response(response=400, description="Bad request create"),
     *     @OA\Response(response=422, description="Resource Error"),
     * )
     */
    public function store(CreateUserTeamRequest $request)
    {
        $this->authorize('create', UserTeam::class);

        $userTeams = $this->userTeamService->createOne($request->all());
        return new UserTeamResource($userTeams);
    }

    /**
     * @OA\GET(
     *     path="/api/user-teams/{id}",
     *     tags={"User Teams"},
     *     summary="Get userTeams detail",
     *     description="Get userTeams detail by ID",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $this->authorize('view', UserTeam::class);

        $userTeams = $this->userTeamService->getOneOrFail($id, $request->all());
        return new UserTeamResource($userTeams);
    }

    /**
     * @OA\PUT(
     *     path="/api/user-teams/{id}",
     *     tags={"User Teams"},
     *     summary="UPDATE an existing UserTeam",
     *     description="UPDATE an existing UserTeam",
     *     @OA\Response(response=400, description="Bad request update"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(UpdateUserTeamRequest $request, string $id)
    {
        $this->authorize('update', UserTeam::class);

        $userTeams = $this->userTeamService->updateOne($id, $request->all());
        return new UserTeamResource($userTeams);
    }

    /**
     * @OA\DELETE(
     *     path="/api/user-teams/{id}",
     *     tags={"User Teams"},
     *     summary="DELETE a UserTeam",
     *     description="DELETE a UserTeam",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {

        $this->authorize('delete',  UserTeam::class);

        $userTeam = $this->userTeamService->getOneOrFail($id, ['counts' => 'users']);
        if ($userTeam->users_count > 0) {
            abort(403);
        }
        $this->userTeamService->deleteModel($userTeam);

        return new UserTeamResource($userTeam);
    }
}
