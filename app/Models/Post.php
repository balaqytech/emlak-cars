<?php

namespace App\Models;

use App\Models\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[ScopedBy(PublishedScope::class)]
class Post extends Model
{
    use HasTranslations;

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
}
