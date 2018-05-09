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
        'lft',
        'rgt',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = uuid();

            // calculate lft, rgt
            $locations = self::all();
            $rgt = $locations->max('rgt') ?: 0;
            $lft = $rgt + 1;
            $rgt = $lft + 1;

            $model->lft = $lft;
            $model->rgt = $rgt;
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
