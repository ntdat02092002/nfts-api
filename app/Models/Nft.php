<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Nft extends Model
{
    use HasFactory;
    use Filterable;
    protected $table = 'nfts';

    protected $fillable = [
    	'name', 
        'owner_id',
        'creator_id',
        'reaction',
        'status',
        'price'
    ];
}
