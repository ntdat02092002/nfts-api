<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
class Crypto extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'cryptos';

    protected $fillable = [
    	'name'
    ];

    public function crypto_nft()
    {
        return $this->hasMany('App\Models\Nft', 'crypto_id');
    }
}
