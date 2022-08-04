<?php

namespace App\Providers;

use App\Modules\Company\Company;
use App\Modules\Company\CompanyObserver;
use App\Modules\CompanyBranch\CompanyBranch;
use App\Modules\CompanyBranch\CompanyBranchObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Company::class => [CompanyObserver::class],
        CompanyBranch::class => [CompanyBranchObserver::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }

    /**
     * Get the listener directories that should be used to discover events.
     *
     * @return array
     */
    protected function discoverEventsWithin()
    {
        return [
            app()->path('Modules/User/Listeners'),
            app()->path('Modules/Company/Listeners'),
            app()->path('Modules/CompanyBranch/Listeners'),
            app()->path('Modules/Role/Listeners'),
            app()->path('Modules/Client/Listeners'),
            app()->path('Modules/Property/Listeners'),
            app()->path('Modules/Exclusive/Listeners'),
            app()->path('Modules/Proposal/Listeners'),
            app()->path('Modules/SiteInquiry/Listeners'),
            app()->path('Modules/ContactCompany/Listeners'),
        ];
    }
}