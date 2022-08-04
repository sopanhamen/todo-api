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
        $this->authorizeResource(UserProfile::class, 'user_profile');
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
    public function show(Request $request, string $id)
    {
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
    public function update(UpdateUserProfileRequest $request, string $id)
    {
        $userProfile = $this->userProfileService->updateOne($id, $request->all());
        return new UserProfileResource($userProfile);
    }

    /**
     * @OA\DELETE(
     *     path="/api/user-profiles/{id}",
     *    tags={"User Profiles"},
     *     summary="Delete a User Profile",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $userProfile = $this->userProfileService->deleteOne($id);
        return new UserProfileResource($userProfile);
    }
}
