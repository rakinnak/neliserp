<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\ItemFilter;

class Item extends Model
{
    use RecordsActivity;

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
