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
class Post extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasTranslations;
    use HasSEO;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'video',
        'image',
        'is_active',
        'is_featured',
        'published_at',
        'post_category_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public $translatable = [
        'title',
        'excerpt',
        'content',
    ];

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function getDynamicSEOData(): SEOData
    {
        $title = $this->getTranslation('title', app()->getLocale());
        $description = $this->getTranslation('excerpt', app()->getLocale()) ?? str($this->getTranslation('content', app()->getLocale()))->stripTags()->limit(155)->toString();
        $image = asset('storage/' . $this->image);
        $url = localizedUrl('posts/' . $this->slug);
        $alternates = collect(config('app.locales'))->map(function ($locale) {
            return new AlternateTag($locale, localizedUrl('posts/' . $this->slug, $locale));
        })->all();
        $robots = (!$this->is_active || optional($this->published_at)->isFuture())
            ? 'noindex,nofollow'
            : null;

        return new SEOData(
            title: $title,
            description: $description,
            image: $image,
            url: $url,
            published_time: $this->published_at ?? $this->created_at,
            modified_time: $this->updated_at,
            locale: app()->getLocale(),
            alternates: $alternates,
            robots: $robots,
            schema: SchemaCollection::make()
                ->add(fn() => [
                    '@context' => 'https://schema.org',
                    '@type' => 'Article',
                    'headline' => $this->title,
                    'datePublished' => optional($this->published_at ?? $this->created_at)->toIso8601String(),
                    'dateModified' => optional($this->updated_at)->toIso8601String(),
                    'image' => $image ? secure_url($image) : null,
                    'author' => [
                        '@type' => 'Organization',
                        'name' => general_settings('site_name'),
                    ],
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => general_settings('site_name'),
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => secure_url('storage/' . general_settings('site_favicon')),
                        ],
                    ],
                    'description' => $description,
                ])
        );
    }
}
