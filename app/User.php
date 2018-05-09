<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Person;
use App\Filters\UserFilter;

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
        'username',
        'name',
        'email',
        'password',
        'api_token',
        'person_id',
        'person_uuid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
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

    public function scopeFilter($builder, UserFilter $filter)
    {
        return $filter->apply($builder);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
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

    public function getFirstNameAttribute()
    {
        return $this->person->first_name;
    }

    public function getLastNameAttribute()
    {
        return $this->person->last_name;
    }
}
