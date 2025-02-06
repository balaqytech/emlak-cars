<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['title', 'slug', 'image', 'excerpt', 'due_date', 'content', 'faqs'];
   
    protected $casts = [
        'due_date' => 'date',
        'faqs' => 'array',
    ];
}
