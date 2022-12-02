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

    public function filterIncludeCollection($include=0)
    {
        if ($include == 1) {
            return $this->builder->with('collection');
        }
        return $this->builder;
    }

    public function filterCollectionName($name)
    {
        return $this->builder->whereHas('collection', fn ($query) => 
            $query->where('name', 'like', '%'. $name. '%')
        );
    }

    public function filterTopicName($name)
    {
        return $this->builder->whereHas('collection.topic', fn ($query) => 
            $query->where('name', 'like', '%'. $name. '%')
        );
    }
}
