<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\CompanyFilter;

class Company extends Model
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

    public function scopeFilter($builder, CompanyFilter $filter)
    {
        return $filter->apply($builder);
    }
}
