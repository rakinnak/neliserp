<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\ItemFilter;

class Item extends CrudModel
{
    protected $fillable = [
        'code',
        'name',
    ];

    public function scopeFilter($builder, ItemFilter $filter)
    {
        return $filter->apply($builder);
    }
}
