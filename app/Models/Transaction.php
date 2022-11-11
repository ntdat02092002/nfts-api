<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Transaction extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'transactions';

    protected $fillable = [
    	'name',
        'buyer_id',
        'seller_id',
        'nft_id',
        'date',
        'crypto_id'
    ];
}
