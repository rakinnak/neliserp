<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\PartnerFilter;

class Partner extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'code',
        'name',
        'type',
        'subject_type',
        'subject_id',
        'subject_uuid',
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

    public function scopeFilter($builder, PartnerFilter $filter)
    {
        return $filter->apply($builder);
    }

    public function subject()
    {
        return $this->morphTo();
    }
}
