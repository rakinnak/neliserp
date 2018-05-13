<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\CityFilter;

class City extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'code',
        'name',
        'district_id',
        'district_uuid',
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

    public function scopeFilter($builder, CityFilter $filter)
    {
        return $filter->apply($builder);
    }
}
