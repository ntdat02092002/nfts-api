<?php

namespace App\Filters;
use App\Helpers\Common\StringHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class NftFilter extends QueryFilter
{
    protected $filterable = [
        'name' , 'price', 'status', 'reaction'
    ];
    
    public function filterName($name)
    {
        return $this->builder->where('name', 'like', '%' . $name . '%');
    }

    public function filterPrice($price)
    {
        return $this->builder->where('price', 'like', '%' . $price . '%');
    }

    public function filterStatus($status)
    {
        return $this->builder->where('status', 'like', '%' . $status . '%');
    }

    public function filterReaction($reaction)
    {
        return $this->builder->where('reaction','>=', $reaction);
    }

    public function filterIncludeCollection($include=0)
    {
        if ($include == 1) {
            return $this->builder->with('collection');
        }
        return $this->builder;
    }
}
