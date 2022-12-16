<?php

namespace App\Filters;
use App\Helpers\Common\StringHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NotifyFilter extends QueryFilter
{
    protected $filterable = [
        'user_id'
    ];
    
    public function filterUserId($user_id)
    {
        return $this->builder->where('notifies.user_id', '=', $user_id);
    }
}
