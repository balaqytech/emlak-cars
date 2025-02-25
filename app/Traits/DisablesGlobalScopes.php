<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait DisablesGlobalScopes
{
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }
}
