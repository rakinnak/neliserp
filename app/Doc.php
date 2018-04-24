<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\DocFilter;

class Doc extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'name',
        'company_id',
        'company_uuid',
        'company_code',
        'company_name',
        'issued_at',
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

    public function scopeFilter($builder, DocFilter $filter)
    {
        return $filter->apply($builder);
    }
}
