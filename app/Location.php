<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\LocationFilter;

class Location extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'parent_id',
        'parent_uuid',
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
            if ($model->parent_uuid) {
                $parent_location = self::where('uuid', $model->parent_uuid)->first();

                // update others
                self::where('lft', '>', $parent_location->rgt)
                    ->increment('lft', 2);

                self::where('lft', '>', $parent_location->rgt)
                    ->increment('rgt', 2);

                // update parent
                $parent_location->rgt = $parent_location->rgt + 2;
                $parent_location->save();

                $lft = $parent_location->rgt - 2;
                $rgt = $parent_location->rgt - 1;
            } else {
                $locations = self::all();
                $rgt = $locations->max('rgt') ?: 0;
                $lft = $rgt + 1;
                $rgt = $lft + 1;
            }

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
