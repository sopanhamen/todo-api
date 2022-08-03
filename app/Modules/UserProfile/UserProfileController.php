<?php

namespace App\Modules\UserProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\UserProfile\UserProfileService;
use App\Modules\UserProfile\Resources\UserProfileResource;
use App\Modules\UserProfile\Requests\CreateUserProfileRequest;
use App\Modules\UserProfile\Requests\UpdateUserProfileRequest;

class UserProfileController extends Controller
{
    protected $userProfileService;

    public function __construct(UserProfileService $userProfileService)
    {
        $this->middleware('auth');
        $this->userProfileService = $userProfileService;
    }

    /**
     * @OA\GET(
     *     path="/api/user-profiles",
     *     tags={"User Profiles"},
     *     summary="Get User Profiles list",
     *     description="Get User Profiles List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', UserProfile::class);

        $userProfiles = $this->userProfileService->paginate($request->all());
        return UserProfileResource::collection($userProfiles);
    }

    /**
     * @OA\GET(
     *     path="/api/user-profiles/{id}",
     *     tags={"User Profiles"},
     *     summary="Get User Profile detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        $this->authorize('view', UserProfile::class);

        $userProfile = $this->userProfileService->getOneOrFail($id, $request->all());
        return new UserProfileResource($userProfile);
    }

    /**
     * @OA\POST(
     *     path="/api/user-profiles",
     *     tags={"User Profiles"},
     *     summary="Create a new User Profile",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateUserProfileRequest $request)
    {
        $this->authorize('create', UserProfile::class);

        $userProfile = $this->userProfileService->createOne($request->all());
        return new UserProfileResource($userProfile);
    }

    /**
     * @OA\PUT(
     *     path="/api/user-profiles/{id}",
     *     tags={"User Profiles"},
     *     summary="Update an existing User Profile",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateUserProfileRequest $request, int $id)
    {
        $this->authorize('update', UserProfile::class);

        $userProfile = $this->userProfileService->updateOne($id, $request->all());
        return new UserProfileResource($userProfile);
    }

    /**
     * @OA\DELETE(
     *     path="/api/user-profiles/{id}",
     *     tags={"User Profiles"},
     *     summary="Delete a User Profile",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        $this->authorize('delete', UserProfile::class);

        $userProfile = $this->userProfileService->deleteOne($id);
        return new UserProfileResource($userProfile);
    }

    /**
     * @OA\POST(
     *     path="/api/user-profiles/{id}/restore",
     *     tags={"User Profiles"},
     *     summary="Restore a User Profile from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        $this->authorize('restore', UserProfile::class);

        $userProfile = $this->userProfileService->restoreOne($id);
        return new UserProfileResource($userProfile);
    }
}
