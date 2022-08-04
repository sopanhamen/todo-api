<?php

namespace App\Modules\Auth;

use App\Modules\User\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Modules\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Modules\User\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;

class AuthService
{
    private UserService $userService;
    private UserRepository $repo;


    public function __construct(UserService $userService, UserRepository $repo)
    {
        $this->userService = $userService;
        $this->repo = $repo;
    }

    protected $tokenName = 'APPA API Personal Access Client';

    /**
     * Login user with email and password
     * @param string $emailOrPhone
     * @param string $password
     * @return array [access_token, token_type, expires_in, user]
     */
    public function login(string $emailOrPhone, string $password): ?array
    {
        $user = User::where('email', $emailOrPhone)
            ->orWhere('phone', $emailOrPhone)
            ->first();

        if (!$user) {
            return null;
        }

        if (!Hash::check($password, $user->password)) {
            return null;
        }

        $token = $user->createToken($this->tokenName)->accessToken;
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => config('passport.lifetime') * 24 * 60 * 60, // seconds
            'user' => $user
        ];
    }

    /**
     * @param User $user
     * @return User
     */
    public function logout(User $user): User
    {
        $user->token()->revoke();
        return $user;
    }

    /**
     * Get list of permissions name
     * To get array of permission object, use $user->getAllPermissions()
     * See: https://spatie.be/docs/laravel-permission/v5/basic-usage/basic-usage
     *
     * @param User $user
     *
     * @return array permission names
     */
    public function getPermissions(User $user): mixed
    {
        return $user->getAllPermissions()->pluck('name');
    }

    public function getLoggedUserDetail()
    {
        $user = request()->user();
        $user = $this->userService->getOne($user->id, [
            'relations' => 'teams,profile,profile.contact'
        ]);

        $permissions = $user->hasRole(config('user.default_user.super_admin.role_name'))
            ? ['*']
            : $user->getAllPermissions()->pluck('name');

        $user->setRelation('permissions', $permissions);

        return $user;
    }

    public function updateProfile(array $data)
    {
        return $this->userService->updateOne(Auth::id(), $data);
    }

    public function forgetPassword($request)
    {
        $superAdmin = $this->repo->findSuperUser($request['email']);

        if ($superAdmin) {
            abort(422);
        }

        $status = Password::sendResetLink($request);

        if ($status === Password::RESET_LINK_SENT) {
            return [
                'status' =>  __($status)
            ];
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function updatePassword($request)
    {

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response([
                'message' => __($status)
            ], 200);
        }
        return response([
            'message' => __($status)
        ], 500);
    }
}
