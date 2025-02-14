<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
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
}
