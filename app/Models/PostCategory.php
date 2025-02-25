<?php

namespace App\Models;

use App\Models\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy(PublishedScope::class)]
class PostCategory extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $translatable = ['name'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
