<?php

namespace App\Models;

use App\Models\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\AlternateTag;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy(PublishedScope::class)]
class Page extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasTranslations;
    use HasSEO;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $translatable = [
        'title',
        'excerpt',
        'content',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            cache()->forget('pages');
        });
    }

    public function getDynamicSEOData(): SEOData
    {
        $title = $this->getTranslation('title', app()->getLocale());
        $description = $this->getTranslation('excerpt', app()->getLocale()) ?? str($this->getTranslation('content', app()->getLocale()))->stripTags()->limit(155)->toString();
        $image = asset('storage/' . $this->image);
        $url = localizedUrl('pages/' . $this->slug);
        $alternates = collect(config('app.locales'))->map(function ($locale) {
            return new AlternateTag($locale, localizedUrl('pages/' . $this->slug, $locale));
        })->all();
        $robots = (!$this->is_active)
            ? 'noindex,nofollow'
            : null;

        return new SEOData(
            title: $title,
            description: $description,
            image: $image,
            url: $url,
            alternates: $alternates,
            robots: $robots,
            schema: SchemaCollection::make()
                ->add(fn () => [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => $title,
                    'description' => $description,
                    'inLanguage' => app()->getLocale(),
                    'image' => $image ? secure_url($image) : null,
                    'alternate' => $alternates,
                    'isPartOf' => [
                        '@type' => 'WebSite',
                        'name' => general_settings('site_name'),
                        'url' => url('/'),
                    ],
                    'datePublished' => optional($this->created_at)->toIso8601String(),
                    'dateModified' => optional($this->updated_at)->toIso8601String(),
                ])
        );
    }
}
