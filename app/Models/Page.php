<?php

namespace App\Models;

use App\Models\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy(PublishedScope::class)]
class Page extends Model
{
    use HasTranslations;

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
}
