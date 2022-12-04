<?php

namespace App\Filters;

use App\Helpers\Common\StringHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionFilter extends QueryFilter
{
    protected $filterable = [
        'date', 'dateStart', 'dateEnd', 'nameNft' ,'price'
    ];
    

    // Find transaction in current date
    public function filterDate($date)
    {
        return $this->builder->whereDate('created_at', $date);
    }

    public function filterDateStart($dateStart)
    {
        return $this->builder->whereDate('created_at', $dateStart);
    }

    public function filterDateEnd($dateEnd)
    {
        return $this->builder->whereDate('created_at', $dateEnd);
    }
    
    public function filterNameNft($nameNft)
    {
        return $this->builder
            ->join('nfts','nfts.id', '=','transactions.nft_id')
            ->where('nfts.name','like','%'.$nameNft.'%')
            ->select('transactions.*');
    }

    // Tìm transaction theo giá giao dịch
    public function filterPriceTransaction($price)
    {
        $min = ((int)$price)-(((int)$price)/10);
        $max = ((int)$price)+(((int)$price)/10);
        return $this->builder
            ->select('transactions.*')
            ->orwhere(function (Builder $query) {
                return $query->where('price', '>=',$min)
                             ->where('price', '<=',$max);
            })
            ->where('transactions.price', '=', $price);
    }

}
