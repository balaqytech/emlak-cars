<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        \Spatie\Translatable\Facades\Translatable::fallback(
            fallbackLocale: 'ar',
        );

        // override the default audit policy to disable restore
        Gate::define('audit', function ($user, $resource) {
            return $user->hasRole('super_admin');
        });

        Gate::define('restoreAudit', function ($user, $resource) {
            return false;
        });
    }
}
