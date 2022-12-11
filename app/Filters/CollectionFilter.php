<?php

namespace App\Filters;

use App\Helpers\Common\StringHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CollectionFilter extends QueryFilter
{
    protected $filterable = [
        'name', 'description'
    ];

    public function filterName($name)
    {
        return $this->builder->where('collections.name', 'like', '%' . $name . '%');
    }

    public function filterIncludeTopic($include = 0)
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
            ->where('topics.name', 'like', '%' . $name . '%')
            ->select('collections.*');
    }

    public function filterOwnerId($id)
    {
        return $this->builder->where('owner_id', '=', $id);
    }

    public function filterCreatorId($id)
    {
        return $this->builder->where('creator_id', '=', $id);
    }

    public function filterDescription($description)
    {
        return $this->builder->where('collections.description', 'like', '%' . $description . '%');
    }

    public function filterIncludeCreator($include = 0)
    {
        if ($include == 1) {
            return $this->builder->with('creator');
        }
        return $this->builder;
    }

    public function filterIncludeOwner($include = 0)
    {
        if ($include == 1) {
            return $this->builder->with('owner');
        }
        return $this->builder;
    }
}