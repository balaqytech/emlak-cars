<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $fillable = ['name', 'is_active'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
