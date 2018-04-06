<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\ItemFilter;

class Item extends Model
{
    protected $fillable = [
        'uuid',
        'code',
        'name',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function scopeFilter($builder, ItemFilter $filter)
    {
        return $filter->apply($builder);
    }
}
