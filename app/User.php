<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    use RecordsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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

    public function scopeFilter($builder, UserFilter $filter)
    {
        return $filter->apply($builder);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function assignRole($role_name)
    {
        return $this->roles()->save(
            Role::where('name', $role_name)
                ->firstOrFail()
        );
    }

    public function hasPermission($permission_name)
    {
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                if ($permission_name == $permission->name) {
                    return true;
                }
            }
        }

        return false;
    }
}
