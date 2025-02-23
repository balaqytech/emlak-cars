<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Branch extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'address',
        'working_hours',
        'contact_mobile',
        'contact_whatsapp',
        'lat',
        'lag',
        'map_embed',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $translatable = [
        'name',
        'address',
        'working_hours',
    ];
}
