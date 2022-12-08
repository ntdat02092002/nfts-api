<?php

namespace App\Filters;

use App\Helpers\Common\StringHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicFilter extends QueryFilter
{
    protected $filterable = [
        'name'
    ];
    
    // Find topics with name topic 
    public function filterName($name)
    {
        return $this->builder->where('topics.name','like','%'.$name.'%');
    }
}
