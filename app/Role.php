<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\RoleFilter;

class Role extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'name',
    ];

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
