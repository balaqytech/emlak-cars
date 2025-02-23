<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Bank extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'percentage',
        'benefits',
        'insurance',
        'management_fees',
        'period',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $translatable = [
        'name',
    ];
}
