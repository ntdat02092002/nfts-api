<?php

namespace App\Filters;

use App\Helpers\Common\StringHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionFilter extends QueryFilter
{
    protected $filterable = [
        'cur_date', 'date_start', 'date_end', 'name_nft'
    ];
    

    // Find transaction in current date
    public function filterCurDate($cur_date)
    {
        return $this->builder->whereDate('create_at', $cur_date);
    }

    public function filterWithinDate($date_start, $date_end)
    {
        $trans = DB::table('transactions')
            ->select('transactions.*')
            ->whereDate('transactions.create_at' ,'>=',$date_start)
            ->whereDate('transactions.create_at' ,'<=',$date_end)
            ->get();

        return $trans;
    }
    
    public function filterNameNft($name_nft)
    {
        $trans = DB::table("transactions")
            -join('nfts', 'nfts.id','=','transactions.nft_id')
            ->select('transaction.*')
            ->where('nfts.name', 'like','%'.$name_nft.'%')
            ->get();

        return $trans;
    }

}
