<?php

namespace App\Models;

use App\Casts\ModelColorCast;
use App\Models\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\AlternateTag;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy(PublishedScope::class)]
class VehicleModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasTranslations;
    use HasSEO;

    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'image',
        'overview',
        'specifications',
        'vehicle_id',
        'is_active',
    ];

    public $translatable = [
        'name',
        'excerpt',
        'overview',
        'specifications',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function colors(): HasMany
    {
        return $this->hasMany(Color::class);
    }

    public function availableColors(): HasMany
    {
        return $this->hasMany(Color::class)->where('is_available', true);
    }

    public function lowestPrice()
    {
        return $this->colors()->min('cash_price');
    }

    public function hightestPrice()
    {
        return $this->colors()->max('cash_price');
    }

    public function getDynamicSEOData(): SEOData
    {
        $title = $this->vehicle->brand->name . ' ' . $this->vehicle->name . ' ' . $this->getTranslation('name', app()->getLocale()) . ' ' . $this->vehicle->year;
        $description = $this->getTranslation('excerpt', app()->getLocale()) ?? str($this->getTranslation('overview', app()->getLocale()))->stripTags()->limit(155)->toString();
        $image = asset('storage/' . $this->image);
        $url = localizedUrl('vehicles/' . $this->vehicle->slug . '/' . $this->slug);
        $alternates = collect(config('app.locales'))->map(function ($locale) {
            return new AlternateTag($locale, localizedUrl('vehicles/' . $this->vehicle->slug . '/' . $this->slug, $locale));
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
            published_time: $this->created_at,
            modified_time: $this->updated_at,
            schema: SchemaCollection::make()
                ->add(fn() => [
                    '@context' => 'https://schema.org',
                    '@type' => 'Vehicle',
                    'name' => $title,
                    'model' => $this->vehicle->name,
                    'url' => $url,
                    'description' => $description,
                    'image' => $image,
                    'brand' => [
                        '@type' => 'Brand',
                        'name' => $this->vehicle->brand->name,
                    ],
                    'category' => $this->vehicle->category->name,
                    'vehicleModelDate' => $this->vehicle->year,
                    'isPartOf' => [
                        '@type' => 'Vehicle',
                        'name' => $this->vehicle->name,
                        'url' => localizedUrl('vehicles/' . $this->vehicle->slug),
                    ],
                    'offers' => [
                        '@type' => 'Offer',
                        'lowPrice' => $this->lowestPrice(),
                        'highPrice' => $this->hightestPrice(),
                    ]
                ])
                ->add(function () use ($title, $description, $image) {
                    return [
                        '@context' => 'https://schema.org',
                        '@type' => 'ProductModel',
                        'name' => $title,
                        'description' => $description,
                        'image' => $image,
                        'hasVariant' => $this->availableColors->map(function ($color) use ($title) {
                            return [
                                '@type' => 'Product',
                                'name' => $color->name,
                                'color' => $color->hex,
                                'image' => $color->image ? asset('storage/' . $color->image) : asset('storage/' . $this->image),
                                'isVariantOf' => [
                                    '@type' => 'ProductModel',
                                    'name' => $title,
                                    'sameAs' => localizedUrl('vehicles/' . $this->vehicle->slug . '/' . $this->slug),
                                ],
                                'offers' => [
                                    '@type' => 'Offer',
                                    'price' => $color->cash_price,
                                    'priceCurrency' => 'SAR',
                                    'availability' => $color->is_available ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                                ],
                            ];
                        })->all(),
                        'itemList' => [
                            '@type' => 'ItemList',
                            'itemListElement' => $this->availableColors->map(function ($color) use ($title) {
                                return [
                                    '@type' => 'ListItem',
                                    'position' => $color->id,
                                    'item' => $color->name,
                                ];
                            })->all(),
                        ]
                    ];
                })
        );
    }
}
