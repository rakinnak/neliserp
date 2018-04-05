<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'uuid',
        'code',
        'name',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
