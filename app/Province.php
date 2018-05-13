<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\ProvinceFilter;

class Province extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'code',
        'name',
        'country_id',
        'country_uuid',
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

    public function scopeFilter($builder, ProvinceFilter $filter)
    {
        return $filter->apply($builder);
    }
}
