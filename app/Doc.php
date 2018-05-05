<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\DocFilter;
use Carbon\Carbon;

class Doc extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'name',
        'type',
        'user_id',
        'user_uuid',
        'user_username',
        'partner_id',
        'partner_uuid',
        'partner_code',
        'partner_name',
        'issued_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
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

    public function getIssuedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function doc_items()
    {
        return $this->hasMany(DocItem::class);
    }
}
