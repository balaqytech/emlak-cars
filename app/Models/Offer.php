<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\AlternateTag;

class Offer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasTranslations;
    use HasSEO;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'excerpt',
        'due_date',
        'content',
        'faqs'
    ];

    protected $casts = [
        'due_date' => 'date',
        'faqs' => 'array',
    ];

    public $translatable = [
        'title',
        'excerpt',
        'content',
        'faqs'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('available', function (Builder $builder) {
            $builder->where('due_date', '>=', today());
        });
    }

    public function getDynamicSEOData(): SEOData
    {
        $title = $this->getTranslation('title', app()->getLocale());
        $description = $this->getTranslation('excerpt', app()->getLocale()) ?? str($this->getTranslation('content', app()->getLocale()))->stripTags()->limit(155)->toString();
        $image = asset('storage/' . $this->image);
        $url = localizedUrl('offers/' . $this->slug);
        $alternates = collect(config('app.locales'))->map(function ($locale) {
            return new AlternateTag($locale, localizedUrl('offers/' . $this->slug, $locale));
        })->all();
        $robots = $this->due_date && $this->due_date < today() ? 'noindex, nofollow' : null;
        $faqs = collect($this->getTranslation('faqs', app()->getLocale()))->map(function ($faq) {
            return [
                'question' => $faq['question'],
                'answer' => $faq['answer'],
            ];
        })->all();

        return new SEOData(
            title: $title,
            description: $description,
            image: $image,
            url: $url,
            alternates: $alternates,
            robots: $robots,
            published_time: $this->created_at,
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
                ->add(fn() => [
                    '@context' => 'https://schema.org',
                    '@type' => 'Offer',
                    'name' => $title,
                    'description' => $description,
                    'image' => $image ? secure_url($image) : null,
                    'url' => $url,
                    'validFrom' => optional($this->created_at)->toIso8601String(),
                    'validThrough' => optional($this->due_date)->toIso8601String(),
                    'category' => 'Automotive',
                ])
                ->add(fn() => [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => collect($faqs)->map(function ($faq) {
                        return [
                            '@type' => 'Question',
                            'name' => $faq['question'],
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => strip_tags($faq['answer']),
                            ],
                        ];
                    })->all(),
                ])
        );
    }
}
