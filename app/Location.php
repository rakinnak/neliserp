<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\LocationFilter;

class Location extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'code',
        'name',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function scopeFilter($builder, LocationFilter $filter)
    {
        return $filter->apply($builder);
    }
}
