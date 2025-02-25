<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;

class Offer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasTranslations;

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
}
