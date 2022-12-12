<?php

namespace App\Filters;

use App\Helpers\Common\StringHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountBalanceFilter extends QueryFilter
{
    protected $filterable = [
    ];
    
    public function filterUserId($id)
    {
        return $this->builder->where('user_id', '=', $id);
    }
}