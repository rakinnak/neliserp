<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\PermissionFilter;

class Permission extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'name',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function path()
    {
        return "/permissions/{$this->id}";
    }

    public function scopeFilter($builder, PermissionFilter $filter)
    {
        return $filter->apply($builder);
    }
}
