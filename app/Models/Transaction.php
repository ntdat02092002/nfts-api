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
        'buyer_id',
        'seller_id',
        'nft_id',
        'date',
        'crypto_id',
        'price'
    ];

    public function crypto() 
    {
        return $this->belongsTo('App\Models\Crypto');
    }

    public function buyer() 
    {
        return $this->belongsTo('App\Models\User', 'buyer_id');
    }

    public function seller() 
    {
        return $this->belongsTo('App\Models\User', 'seller_id');
    }

    public function nft() 
    {
        return $this->belongsTo('App\Models\Nft', 'nft_id');
    }
}
