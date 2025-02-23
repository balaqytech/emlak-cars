<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Offer extends Model
{
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
}
