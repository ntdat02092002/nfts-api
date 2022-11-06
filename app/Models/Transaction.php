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
        'id_buyer',
        'id_seller',
        'id_nft',
        'date',
        'price',
        'id_crypto'
    ];
}
