<?php

namespace App\Filters;

class DocFilter extends Filter
{
    protected $filters = [
        'name',
        'sort',
    ];

    protected function name($name)
    {
        return $this->builder->where('name', 'LIKE', "%{$name}%");
    }

    protected function sort($sort)
    {
        return $this->builder->orderBy($sort, request('order', 'asc'));
    }
}
