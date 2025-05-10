<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamMemberAdded;
use App\Listeners\HandleSubscriptionCreated;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Spark\Events\SubscriptionCreated;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Gate::define('viewPulse', function (User $user) {
            return $user->isAdmin();
        });
        Event::listen(
            SubscriptionCreated::class,
            HandleSubscriptionCreated::class,
           
        );
        Event::listen(
            TeamMemberAdded::class,
            \App\Listeners\EnableDefaultNotificationsOnAddedMember::class
        );
    }
}
