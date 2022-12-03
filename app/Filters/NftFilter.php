<?php

namespace App\Filters;


class NftFilter extends QueryFilter
{
    protected $filterable = [
        'name' , 'price', 'status'
    ];
    
    public function filterName($name)
    {
        return $this->builder->where('nfts.name', 'like', '%' . $name . '%');
    }

    public function filterPrice($price)
    {
        return $this->builder->where('nfts.price', 'like', '%' . $price . '%');
    }

    public function filterStatus($price)
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
}
