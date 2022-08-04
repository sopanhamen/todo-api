<?php

namespace App\Modules\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Modules\Auth\AuthService;
use App\Modules\User\UserService;
use App\Http\Controllers\Controller;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\User\Resources\UserResource;
use App\Modules\Auth\Resources\LoginResource;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Modules\Auth\Resources\AuthUserResource;
use App\Modules\Auth\Requests\UpdateProfileRequest;
use App\Modules\Auth\Requests\ForgetPasswordRequest;
use App\Modules\Auth\Requests\UpdatePasswordRequest;

class AuthController extends Controller
{
    public $authService;
    public $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'resetPassword', 'forgetPassword', 'updatePassword']]);
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /**
     * @OA\POST(
     *     path="/api/auth/login",
     *     tags={"Authentication"},
     *     summary="Login",
     *     description="Login",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string", example="manirujjamanakash@gmail.com"),
     *              @OA\Property(property="password", type="string", example="123456")
     *          ),
     *      ),
     *      @OA\Response(response=200, description="Login" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=422, description="Unprocessable entity"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     * @OA\SecurityScheme(
     *   securityScheme="Bearer",type="apiKey",description="JWT",name="Authorization",in="header",
     * )
     */
    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request->email, $request->password);
        if (!$data) {
            return abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        return new LoginResource($data);
    }

    /**
     * @OA\POST(
     *     path="/api/auth/register",
     *     tags={"Authentication"},
     *     summary="Register User",
     *     description="Register New User",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Jhon Doe"),
     *              @OA\Property(property="email", type="string", example="jhondoe@example.com"),
     *              @OA\Property(property="password", type="string", example="123456"),
     *              @OA\Property(property="password_confirmation", type="string", example="123456")
     *          ),
     *      ),
     *      @OA\Response(response=200, description="Register New User Data" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function register(RegisterRequest $request)
    {
        $formData = $request->only('name', 'email', 'password', 'password_confirmation');
        $user = $this->userService->createOne($formData);
        if (!$user) {
            return response(null, Response::HTTP_ACCEPTED);
        }

        $data = $this->authService->login($user->email, $request->password);
        return new LoginResource($data);
    }

    /**
     * @OA\GET(
     *     path="/api/auth/me",
     *     tags={"Authentication"},
     *     summary="Authenticated User Profile",
     *     description="Authenticated User Profile",
     *     @OA\Response(response=200, description="Authenticated User Profile" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function me(Request $request)
    {
        $user = $this->authService->getLoggedUserDetail();

        return new AuthUserResource($user);
    }

    /**
     * @OA\POST(
     *     path="/api/auth/logout",
     *     tags={"Authentication"},
     *     summary="Logout",
     *     description="Logout",
     *     @OA\Response(response=200, description="Logout" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $this->authService->logout($user);

        return new UserResource($user);
    }

    /**
     * @OA\GET(
     *     path="/api/users/permissions",
     *     tags={"Authentication"},
     *     summary="Get permissions of current user",
     *     description="Get permissions of current user",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function permissions(Request $request)
    {
        if ($request->user()->hasRole(config('user.default_user.default_user.super_admin.role_name'))) {
            return ['*'];
        }

        return $this->authService->getPermissions($request->user());
    }

    /**
     * @OA\GET(
     *     path="/api/auth/update-profile",
     *     tags={"Authentication"},
     *     summary="Update profile of current user",
     *     description="Update profile of current user",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        return $this->authService->updateProfile($request->all());
    }



    /**
     * @OA\GET(
     *     path="/api/auth/forget-password",
     *     tags={"Authentication"},
     *     summary="Forget password of current user",
     *     description="Forget password of current user",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function forgetPassword(ForgetPasswordRequest $request)
    {
        return $this->authService->forgetPassword($request->all());
    }

    /**
     * @OA\GET(
     *     path="/api/auth/update-password",
     *     tags={"Authentication"},
     *     summary="Update password of current user",
     *     description="Update password of current user",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        return $this->authService->updatePassword($request);
    }
}
