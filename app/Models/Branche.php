<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branche extends Model
{
    protected $fillable = [
        'name',
        'address',
        'working_hours',
        'contact_mobile',
        'lat',
        'lag',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

}
