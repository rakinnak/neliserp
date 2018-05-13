<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\DistrictFilter;

class District extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'code',
        'name',
        'province_id',
        'province_uuid',
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

    public function scopeFilter($builder, DistrictFilter $filter)
    {
        return $filter->apply($builder);
    }
}
