<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define passport routes
        Passport::routes();
        Passport::tokensExpireIn(now()->addDay(config('passport.lifetime')));

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole(config('user.default_user.super_admin.role_name')) ? true : null;
        });

        // Auto discover policy classes for each module
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            return $modelClass  . 'Policy';
        });

        // Customize reset password link
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return config('app.website_url') . '/admin/auth/reset-password?token=' . $token . '&email=' . $user->email;
        });
    }
}
