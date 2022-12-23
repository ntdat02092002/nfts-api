<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Notify extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'notifies';

    protected $fillable = [
        'user_id',
        'nft_id',
        'notify',
        'seen'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
