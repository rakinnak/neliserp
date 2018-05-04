<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\PersonFilter;

class Person extends Model
{
    use RecordsActivity;

    protected $table = 'persons';

    protected $fillable = [
        'code',
        'first_name',
        'last_name',
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

    public function scopeFilter($builder, PersonFilter $filter)
    {
        return $filter->apply($builder);
    }
}
