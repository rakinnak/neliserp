<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\PermissionFilter;

class Permission extends Model
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

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function scopeFilter($builder, PermissionFilter $filter)
    {
        return $filter->apply($builder);
    }
}
