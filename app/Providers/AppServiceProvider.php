<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;

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

        Paginator::defaultView('components.pagination');
        Paginator::defaultSimpleView('components.pagination');

        $description = str(FilamentFlatPage::get('about.json', 'about_description'))->stripTags()->limit(155)->toString();

        Config::set('seo.site_name', general_settings('site_name'));
        Config::set('seo.favicon', public_path('storage/' . general_settings('site_favicon')));
        Config::set('seo.title.suffix', ' - ' . general_settings('site_name'));
        Config::set('seo.title.homepage_title', general_settings('site_name') . ' - ' . general_settings('site_tagline'));
        Config::set('seo.description.fallback', $description);
        Config::set('seo.image.fallback', public_path('storage/' . general_settings('site_banner')));
    }
}
