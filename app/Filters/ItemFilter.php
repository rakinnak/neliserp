<?php

namespace App\Filters;

class ItemFilter extends Filter
{
    protected $filters = [
        'code',
        'name',
        'sort',
    ];

    protected function code($code)
    {
        return $this->builder->where('code', 'LIKE', "%{$code}%");
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
