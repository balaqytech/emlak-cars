<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
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
}
