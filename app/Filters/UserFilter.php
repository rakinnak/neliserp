<?php

namespace App\Filters;

class UserFilter extends Filter
{
    protected $filters = [
        'q',
        'username',
        'name',
        'sort',
    ];

    protected function q($q)
    {
        return $this->builder->where(function ($query) use ($q) {
            $query->where('username', 'LIKE', "%{$q}%")
                  ->orWhere('name', 'LIKE', "%{$q}%");
        });
    }

    protected function username($username)
    {
        return $this->builder->where('username', 'LIKE', "%{$username}%");
    }

    protected function name($name)
    {
        return $this->builder->where('name', 'LIKE', "%{$name}%");
    }

    protected function sort($sort)
    {
        return $this->builder->orderBy($sort, request('order', 'asc'));
    }
}
