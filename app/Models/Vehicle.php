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
class Vehicle extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasTranslations;
    use HasSEO;

    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'year',
        'image',
        'show_least_price',
        'banner',
        'overview',
        'is_active',
        'vehicle_category_id',
        'vehicle_brand_id',
        'order',
        'is_featured',
    ];

    protected $casts = [
        // 'features' => 'array',
        'is_active' => 'boolean',
        'show_least_price' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public $translatable = [
        'name',
        'excerpt',
        'overview',
        // 'features',
    ];

    public function vehicleFeatures()
    {
        return $this->hasMany(VehicleFeature::class, 'vehicle_id');
    }

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(VehicleBrand::class, 'vehicle_brand_id');
    }

    public function vehicleModels()
    {
        return $this->hasMany(VehicleModel::class, 'vehicle_id');
    }

    public function getLeastPriceAttribute()
    {
        return $this->vehicleModels()
            ->join('colors', 'vehicle_models.id', '=', 'colors.vehicle_model_id')
            ->min('colors.cash_price');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getDynamicSEOData(): SEOData
    {
        $title = $this->getTranslation('name', app()->getLocale()) . ' - ' . $this->brand->name . ' - ' . $this->year;
        $description = $this->getTranslation('excerpt', app()->getLocale()) ?? str($this->getTranslation('overview', app()->getLocale()))->stripTags()->limit(155)->toString();
        $image = asset('storage/' . $this->image);
        $url = localizedUrl('vehicles/' . $this->slug);
        $alternates = collect(config('app.locales'))->map(function ($locale) {
            return new AlternateTag($locale, localizedUrl('vehicles/' . $this->slug, $locale));
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
                ->add(fn() => [
                    '@context' => 'https://schema.org',
                    '@type' => 'Vehicle',
                    'name' => $title,
                    'model' => $this->name,
                    'description' => $description,
                    'image' => $image,
                    'inLanguage' => app()->getLocale(),
                    'brand' => [
                        '@type' => 'Brand',
                        'name' => $this->brand->name,
                    ],
                    'offers' => [
                        '@type' => 'AggregateOffer',
                        'lowPrice' => $this->least_price,
                        'priceCurrency' => 'SAR',
                        'availability' => 'https://schema.org/InStock',
                    ],
                    'vehicleModelDate' => $this->year,
                    'vehicleCategory' => $this->category->name,
                ])
        );
    }
}
