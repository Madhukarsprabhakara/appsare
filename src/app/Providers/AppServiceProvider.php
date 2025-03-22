<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Laravel\Jetstream\Events\TeamCreated;
use App\Listeners\EnableNotificationsOnTeamCreation;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
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
        
    }
}
