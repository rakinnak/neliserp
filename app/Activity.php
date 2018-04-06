<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\ActivityFilter;
use App\User;

class Activity extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'type',
        'subject_id',
        'subject_type',
        'before',
        'after',
        'created_at',
    ];

    public function subject()
    {
        return $this->morphTo()
            ->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($builder, ActivityFilter $filter)
    {
        return $filter->apply($builder);
    }
}
