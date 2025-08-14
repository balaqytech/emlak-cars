<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Page;
use App\Models\Post;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use App\Models\Offer;

use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a sitemap for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $locales = config('app.locales', ['ar', 'en']);

        $sitemap = Sitemap::create();

        // Add homepage for each locale with alternates
        $homeUrl = url('/');
        foreach ($locales as $locale) {
            $localized = localizedUrl('');
            $url = Url::create(localizedUrl(''))
                ->setLastModificationDate(Carbon::now())
                ->setPriority(1.0);

            // add alternates
            foreach ($locales as $alt) {
                $url->addAlternate(localizedUrl('', $alt), $alt);
            }

            $sitemap->add($url);
            // only add once, break after first to avoid duplicates
            break;
        }

        // Add some static pages (if they're not stored in the Page model already)
        $this->line('Adding static pages (about, contact, faqs) if needed...');
        $staticPages = ['about', 'contact', 'faqs'];
        foreach ($staticPages as $slug) {
            // skip if this static page exists as a Page record
            if (Page::where('slug', $slug)->exists()) {
                continue;
            }

            $url = Url::create(localizedUrl($slug))
                ->setLastModificationDate(Carbon::now())
                ->setPriority(0.6);

            foreach ($locales as $locale) {
                $url->addAlternate(localizedUrl($slug, $locale), $locale);
            }

            $sitemap->add($url);
        }

        // Add archive pages for lists (posts, offers, vehicles)
        $this->line('Adding archive pages (posts, offers, vehicles)...');
        $archives = ['posts', 'offers', 'vehicles'];
        foreach ($archives as $archive) {
            $url = Url::create(localizedUrl($archive))
                ->setLastModificationDate(Carbon::now())
                ->setPriority(0.7);

            foreach ($locales as $locale) {
                $url->addAlternate(localizedUrl($archive, $locale), $locale);
            }

            $sitemap->add($url);
        }

        $this->line('Adding pages...');
        Page::where('is_active', true)->get()->each(function (Page $page) use ($sitemap) {
            $locales = config('app.locales');
            $url = Url::create(localizedUrl('pages/' . $page->slug))
                ->setLastModificationDate($page->updated_at ?? $page->created_at)
                ->setPriority(0.8);

            foreach ($locales as $locale) {
                $url->addAlternate(localizedUrl('pages/' . $page->slug, $locale), $locale);
            }

            $sitemap->add($url);
        });

        $this->line('Adding posts...');
        Post::where('is_active', true)->get()->each(function (Post $post) use ($sitemap) {
            $locales = config('app.locales');
            $url = Url::create(localizedUrl('posts/' . $post->slug))
                ->setLastModificationDate($post->updated_at ?? $post->created_at)
                ->setPriority(0.7);

            foreach ($locales as $locale) {
                $url->addAlternate(localizedUrl('posts/' . $post->slug, $locale), $locale);
            }

            $sitemap->add($url);
        });

        $this->line('Adding vehicles and models...');
        Vehicle::where('is_active', true)->get()->each(function (Vehicle $vehicle) use ($sitemap) {
            $locales = config('app.locales');
            $url = Url::create(localizedUrl('vehicles/' . $vehicle->slug))
                ->setLastModificationDate($vehicle->updated_at ?? $vehicle->created_at)
                ->setPriority(0.9);

            foreach ($locales as $locale) {
                $url->addAlternate(localizedUrl('vehicles/' . $vehicle->slug, $locale), $locale);
            }

            $sitemap->add($url);

            // vehicle models
            $vehicle->vehicleModels()->where('is_active', true)->get()->each(function (VehicleModel $model) use ($sitemap, $vehicle) {
                $locales = config('app.locales');
                $url = Url::create(localizedUrl('vehicles/' . $vehicle->slug . '/' . $model->slug))
                    ->setLastModificationDate($model->updated_at ?? $model->created_at)
                    ->setPriority(0.8);

                foreach ($locales as $locale) {
                    $url->addAlternate(localizedUrl('vehicles/' . $vehicle->slug . '/' . $model->slug, $locale), $locale);
                }

                $sitemap->add($url);
            });
        });

        // Offers
        if (class_exists(Offer::class)) {
            $this->line('Adding offers...');
            // Offer model has its own global scope for availability (due_date >= today())
            Offer::get()->each(function (Offer $offer) use ($sitemap) {
                $locales = config('app.locales');
                $url = Url::create(localizedUrl('offers/' . $offer->slug))
                    ->setLastModificationDate($offer->updated_at ?? $offer->created_at)
                    ->setPriority(0.7);

                foreach ($locales as $locale) {
                    $url->addAlternate(localizedUrl('offers/' . $offer->slug, $locale), $locale);
                }

                $sitemap->add($url);
            });
        }

        $path = public_path('sitemap.xml');
        $sitemap->writeToFile($path);

        $this->info('Sitemap written to: ' . $path);

        return 0;
    }
}
