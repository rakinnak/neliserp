<?php

namespace App\Filters;

class CompanyFilter extends Filter
{
    protected $filters = [
        'q',
        'code',
        'name',
        'sort',
    ];

    protected function q($q)
    {
        return $this->builder->where(function ($query) use ($q) {
            $query->where('code', 'LIKE', "%{$q}%")
                  ->orWhere('name', 'LIKE', "%{$q}%");
        });
    }

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
