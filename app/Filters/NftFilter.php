<?php

namespace App\Filters;


class NftFilter extends QueryFilter
{
    protected $filterable = [
        'name' , 'price', 'status'
    ];
    
    public function filterName($name)
    {
        return $this->builder->where('name', 'like', '%' . $name . '%');
    }

    public function filterPrice($price)
    {
        return $this->builder->where('price', 'like', '%' . $price . '%');
    }

    public function filterStatus($price)
    {
        return $this->builder->where('status', 'like', '%' . $status . '%');
    }
}
