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
        'description',
        'crypto_id',
        'url_image_nft',
        'owner_id',
        'creator_id',
        'collection_id',
        'reaction',
        'status',
        'price'
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'creator_id');
    }

    public function crypto()
    {
        return $this->belongsTo('App\Models\Crypto', 'crypto_id');
    }

    public function collection()
    {
        return $this->belongsTo('App\Models\Collection', 'collection_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }
}
