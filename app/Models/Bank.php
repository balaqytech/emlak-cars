<?php

namespace App\Models;

use App\Models\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy(PublishedScope::class)]
class Bank extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasTranslations;

    protected $fillable = [
        'name',
        'percentage',
        'benefits',
        'insurance',
        'management_fees',
        'period',
        'is_active'
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $translatable = [
        'name',
    ];
}
