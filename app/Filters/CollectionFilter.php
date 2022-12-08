<?php

namespace App\Filters;
use App\Helpers\Common\StringHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CollectionFilter extends QueryFilter
{
    protected $filterable = [
        'name'
    ];
    
    public function filterName($name)
    {
        return $this->builder->where('collections.name', 'like', '%' . $name . '%');
    }

    public function filterIncludeTopic($include=0)
    {
        if ($include == 1) {
            return $this->builder->with('topic');
        }
        return $this->builder;
    }

    public function filterTopicName($name)
    {
        return $this->builder
            ->join('topics', 'topics.id', '=', 'collections.topic_id') 
            ->where('topics.name', 'like', '%'. $name. '%')
            ->select('collections.*');
    }
}
