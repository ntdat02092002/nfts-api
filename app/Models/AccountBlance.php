<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class AccountBlance extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'account_blances';

    protected $fillable = [
    	'user_id',
        'crypto_id',
        'balance'
    ];
}
