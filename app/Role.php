<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\RoleFilter;

class Role extends Model
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

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeFilter($builder, RoleFilter $filter)
    {
        return $filter->apply($builder);
    }

    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()
            ->save($permission);
    }
}
