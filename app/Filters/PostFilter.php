<?php

namespace App\Filters;


class PostFilter extends QueryFilter
{
    protected $filterable = [
        'name', 'description'
    ];
    
    public function filterName($name)
    {
        return $this->builder->where('name', 'like', '%' . $name . '%');
    }

    public function filterDescription($description)
    {
        return $this->builder->where('description', 'like', '%' . $description . '%');
    }
}
