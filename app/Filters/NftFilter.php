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
        return $this->builder->where('nfts.name', 'like', '%' . $name . '%');
    }

    public function filterPrice($price)
    {
        return $this->builder->where('nfts.price', 'like', '%' . $price . '%');
    }

    public function filterStatus($status)
    {
        return $this->builder->where('nfts.status', 'like', '%' . $status . '%');
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
        return $this->builder
            ->join('collections', 'collections.id', '=', 'nfts.collection_id') 
            ->where('collections.name', 'like', '%'. $name. '%')
            ->select('nfts.*');
    }

    public function filterTopicName($name)
    {
        return $this->builder
            ->join('collections as collection_of_topic', 'collection_of_topic.id', '=', 'nfts.collection_id') 
            ->join('topics', 'topics.id', '=', 'collection_of_topic.topic_id')
            ->where('topics.name', 'like', '%'. $name. '%')
            ->select('nfts.*');
    }

    public function filterReaction($reaction)
    {
        return $this->builder->where('reaction','>=', $reaction);
    }

    public function filterOwnerId($id)
    {
        return $this->builder->where('owner_id', '=', $id);
    }

    public function filterCreatorId($id)
    {
        return $this->builder->where('creator_id', '=', $id);
    }

    public function filterIncludeCreator($include=0)
    {
        if ($include == 1) {
            return $this->builder->with('creator');
        }
        return $this->builder;
    }

    public function filterIncludeOnwer($include=0)
    {
        if ($include == 1) {
            return $this->builder->with('owner');
        }
        return $this->builder;
    }
}
